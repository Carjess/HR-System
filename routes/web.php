<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\MessageController; 
use App\Http\Controllers\DashboardController; // Importante: Nuevo Controlador

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (VISIBLES SIN INICIAR SESIÓN)
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('pages.home'); })->name('home');
Route::get('/sobre-nosotros', function () { return view('pages.about'); })->name('about');

// Rutas de Páginas de Productos
Route::get('/productos/gestion-de-personal', function () { return view('pages.products-personnel'); })->name('products.personnel');
Route::get('/productos/gestion-de-contratos', function () { return view('pages.products-contracts'); })->name('products.contracts');
Route::get('/productos/facturacion-de-horas', function () { return view('pages.products-timesheets'); })->name('products.timesheets');
Route::get('/productos/pagos-de-nomina', function () { return view('pages.products-payroll'); })->name('products.payroll');

/*
|--------------------------------------------------------------------------
| RUTAS DE LA APLICACIÓN (PROTEGIDAS - REQUIEREN INICIO DE SESIÓN)
|--------------------------------------------------------------------------
*/

// --- RUTA API (Para los Selects Dinámicos en Modales) ---
Route::get('/api/departamentos/{departamento}/cargos', [DepartmentController::class, 'getPositions'])->name('api.departamentos.cargos');


// --- DASHBOARD ---
// Toda la lógica ahora vive en DashboardController@index
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// --- GRUPOS DE RUTAS AUTENTICADAS ---
Route::middleware('auth')->group(function () {
    
    // Perfil de Usuario (Editar contraseña, borrar cuenta, etc.)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ZONA DE ADMIN (Solo accesible con permiso 'is-admin') ---
    Route::middleware('can:is-admin')->group(function () {
        
        // Gestión de Empleados
        Route::get('/empleados', [EmployeeController::class, 'index'])->name('empleados.index');
        Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('empleados.create'); 
        Route::post('/empleados', [EmployeeController::class, 'store'])->name('empleados.store');
        Route::get('/empleados/{empleado}/editar', [EmployeeController::class, 'edit'])->name('empleados.edit');
        Route::patch('/empleados/{empleado}', [EmployeeController::class, 'update'])->name('empleados.update');
        Route::delete('/empleados/{empleado}', [EmployeeController::class, 'destroy'])->name('empleados.destroy');
        
        // Bandeja de Entrada de Mensajes (Inbox)
        Route::get('/mensajes', [MessageController::class, 'inbox'])->name('messages.inbox');
        
        // Configuración (CRUDs)
        Route::resource('tipos-contrato', ContractTypeController::class);
        Route::resource('departamentos', DepartmentController::class);
        Route::resource('puestos', PositionController::class);

        // Gestión de Contratos
        Route::get('/contratos/{contract}/editar', [ContractController::class, 'edit'])->name('contratos.edit');
        Route::patch('/contratos/{contract}', [ContractController::class, 'update'])->name('contratos.update');
        Route::delete('/contratos/{contract}', [ContractController::class, 'destroy'])->name('contratos.destroy');
        // Crear contrato desde perfil (Admin)
        Route::get('/empleados/{empleado}/contratos/crear', [ContractController::class, 'create'])->name('empleados.contratos.create');
        Route::post('/empleados/{empleado}/contratos', [ContractController::class, 'store'])->name('empleados.contratos.store');
        
        // Gestión de Timesheets (Admin)
        Route::get('/timesheets/{timesheet}/editar', [TimesheetController::class, 'edit'])->name('timesheets.edit');
        Route::patch('/timesheets/{timesheet}', [TimesheetController::class, 'update'])->name('timesheets.update');
        Route::delete('/timesheets/{timesheet}', [TimesheetController::class, 'destroy'])->name('timesheets.destroy');
        
        // Nómina
        Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
        Route::post('/payroll/generate', [PayrollController::class, 'generate'])->name('payroll.generate');
        
        // Gestión de Ausencias (Aprobar/Rechazar)
        Route::get('/ausencias', [LeaveRequestController::class, 'index'])->name('ausencias.index');
        Route::patch('/ausencias/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('ausencias.approve');
        Route::patch('/ausencias/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('ausencias.reject');

        // Enviar mensaje (Solo Admin puede INICIAR la conversación desde el perfil)
        Route::post('/empleados/{empleado}/message', [EmployeeController::class, 'sendMessage'])->name('empleados.message');
    });

    // --- ZONA DE EMPLEADO (ACCESIBLE POR TODOS LOS LOGUEADOS) ---
    
    // Ver Perfil Propio (o de otros si eres admin)
    Route::get('/empleados/{empleado}', [EmployeeController::class, 'show'])->name('empleados.show');
    
    // Acciones de Empleado (Timesheets y Ausencias)
    Route::get('/empleados/{empleado}/timesheets/crear', [TimesheetController::class, 'create'])->name('timesheets.create');
    Route::post('/empleados/{empleado}/timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');
    
    Route::get('/empleados/{empleado}/ausencias/crear', [LeaveRequestController::class, 'create'])->name('ausencias.create');
    Route::post('/empleados/{empleado}/ausencias', [LeaveRequestController::class, 'store'])->name('ausencias.store');

    // --- RUTAS DEL CHAT INTERNO ---
    
    // API Chat Global (Widget)
    Route::post('/chat/open/{user}', [MessageController::class, 'openChat'])->name('chat.open');
    Route::post('/chat/close', [MessageController::class, 'closeChat'])->name('chat.close');

    // Pantalla de Chat Dedicada
    Route::get('/chat/{user}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/chat/{user}', [MessageController::class, 'store'])->name('messages.store');

});

require __DIR__.'/auth.php';