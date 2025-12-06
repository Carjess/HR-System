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
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('pages.home'); })->name('home');
Route::get('/sobre-nosotros', function () { return view('pages.about'); })->name('about');

// Productos
Route::get('/productos/gestion-de-personal', function () { return view('pages.products-personnel'); })->name('products.personnel');
Route::get('/productos/gestion-de-contratos', function () { return view('pages.products-contracts'); })->name('products.contracts');
Route::get('/productos/facturacion-de-horas', function () { return view('pages.products-timesheets'); })->name('products.timesheets');
Route::get('/productos/pagos-de-nomina', function () { return view('pages.products-payroll'); })->name('products.payroll');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (AUTH)
|--------------------------------------------------------------------------
*/

// Semáforo de Dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->can('is-admin')) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('employee.portal');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {

    // --- RUTAS COMUNES (EMPLEADOS Y ADMINS) ---

    Route::get('/mi-portal', [EmployeeController::class, 'portal'])->name('employee.portal');
    
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->middleware('can:is-admin')
        ->name('admin.dashboard');

    // Calendario
    Route::get('/calendar', [EventController::class, 'index'])->name('calendar.index');
    Route::post('/calendar', [EventController::class, 'store'])->name('calendar.store');
    Route::delete('/calendar/{event}', [EventController::class, 'destroy']);

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // API Auxiliar
    Route::get('/api/departamentos/{departamento}/cargos', [DepartmentController::class, 'getPositions'])->name('api.departamentos.cargos');

    // =================================================================
    // === CHAT / MENSAJERÍA (MOVIDO AQUÍ: FUERA DEL GRUPO ADMIN) ===
    // =================================================================
    // Al estar aquí, cualquier usuario logueado puede acceder, pero el 
    // MessageController se encarga de restringir QUÉ ven.
    
    Route::get('/mensajes', [MessageController::class, 'inbox'])->name('messages.inbox'); // Bandeja
    Route::get('/contactar-rrhh', [MessageController::class, 'createTicket'])->name('messages.create_ticket'); // Crear Ticket
    
    // Funcionalidad del Chat
    Route::get('/chat/{user}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/chat/{user}', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/chat/open/{user}', [MessageController::class, 'openChat'])->name('chat.open');
    Route::post('/chat/close', [MessageController::class, 'closeChat'])->name('chat.close');


    // --- ZONA DE ADMIN (SOLO GESTIÓN) ---
    Route::middleware('can:is-admin')->group(function () {
        // Empleados CRUD
        Route::get('/empleados', [EmployeeController::class, 'index'])->name('empleados.index');
        Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('empleados.create'); 
        Route::post('/empleados', [EmployeeController::class, 'store'])->name('empleados.store');
        Route::get('/empleados/{empleado}/editar', [EmployeeController::class, 'edit'])->name('empleados.edit');
        Route::patch('/empleados/{empleado}', [EmployeeController::class, 'update'])->name('empleados.update');
        Route::delete('/empleados/{empleado}', [EmployeeController::class, 'destroy'])->name('empleados.destroy');
        
        // CRUDs Config
        Route::resource('tipos-contrato', ContractTypeController::class);
        Route::resource('departamentos', DepartmentController::class);
        Route::resource('puestos', PositionController::class);

        // Contratos
        Route::get('/contratos/{contract}/editar', [ContractController::class, 'edit'])->name('contratos.edit');
        Route::patch('/contratos/{contract}', [ContractController::class, 'update'])->name('contratos.update');
        Route::delete('/contratos/{contract}', [ContractController::class, 'destroy'])->name('contratos.destroy');
        Route::get('/empleados/{empleado}/contratos/crear', [ContractController::class, 'create'])->name('empleados.contratos.create');
        Route::post('/empleados/{empleado}/contratos', [ContractController::class, 'store'])->name('empleados.contratos.store');
        
        // Gestión
        Route::get('/timesheets/{timesheet}/editar', [TimesheetController::class, 'edit'])->name('timesheets.edit');
        Route::patch('/timesheets/{timesheet}', [TimesheetController::class, 'update'])->name('timesheets.update');
        Route::delete('/timesheets/{timesheet}', [TimesheetController::class, 'destroy'])->name('timesheets.destroy');
        
        Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
        Route::post('/payroll/generate', [PayrollController::class, 'generate'])->name('payroll.generate');
        
        // Ausencias (Aprobación)
        Route::get('/ausencias', [LeaveRequestController::class, 'index'])->name('ausencias.index');
        Route::patch('/ausencias/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('ausencias.approve');
        Route::patch('/ausencias/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('ausencias.reject');

        // Mensaje directo desde perfil (iniciar como admin)
        Route::post('/empleados/{empleado}/message', [EmployeeController::class, 'sendMessage'])->name('empleados.message');
        

    });

    // --- ZONA DE EMPLEADO ---
    Route::get('/empleados/{empleado}', [EmployeeController::class, 'show'])->name('empleados.show');
    Route::get('/empleados/{empleado}/mis-ausencias', [EmployeeController::class, 'misAusencias'])->name('empleados.ausencias.list');
    
    //  Mis Recibos (Lista)
    Route::get('/empleados/{empleado}/mis-recibos', [App\Http\Controllers\PayrollController::class, 'misRecibos'])->name('empleados.recibos.list');

    // Ruta de descarga de PDF (Ya la tenías, pero confirmamos que esté fuera del grupo admin)
    Route::get('/payroll/{payslip}/download', [App\Http\Controllers\PayrollController::class, 'download'])->name('payroll.download');


    Route::get('/empleados/{empleado}/timesheets/crear', [TimesheetController::class, 'create'])->name('timesheets.create');
    Route::post('/empleados/{empleado}/timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');
    
    Route::get('/empleados/{empleado}/ausencias/crear', [LeaveRequestController::class, 'create'])->name('ausencias.create');
    Route::post('/empleados/{empleado}/ausencias', [LeaveRequestController::class, 'store'])->name('ausencias.store');
});

require __DIR__.'/auth.php';