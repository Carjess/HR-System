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

use App\Models\User;
use App\Models\Contract;
use App\Models\Timesheet;
use App\Models\Department;
use Carbon\Carbon;

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
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        
        $totalEmpleados = User::count();
        $totalContratosActivos = Contract::whereNull('end_date')->orWhere('end_date', '>', Carbon::now())->count();
        $horasEsteMes = Timesheet::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('hours_worked');
        
        // Cargamos datos para las tablas y modales del dashboard
        $empleadosRecientes = User::with('position.department')->latest('fecha_contratacion')->take(5)->get();
        $departments = Department::orderBy('name')->get(); // Necesario para el modal de editar en dashboard

        return view('dashboard', [
            'totalEmpleados' => $totalEmpleados,
            'totalContratosActivos' => $totalContratosActivos,
            'horasEsteMes' => $horasEsteMes,
            'empleadosRecientes' => $empleadosRecientes,
            'departments' => $departments
        ]);
    }
    // Si es empleado, redirigir a su perfil
    return redirect()->route('empleados.show', auth()->user()->id);

})->middleware(['auth', 'verified'])->name('dashboard');


// --- GRUPOS DE RUTAS AUTENTICADAS ---
Route::middleware('auth')->group(function () {
    
    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ZONA DE ADMIN ---
    Route::middleware('can:is-admin')->group(function () {
        
        // Gestión de Empleados
        Route::get('/empleados', [EmployeeController::class, 'index'])->name('empleados.index');
        Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('empleados.create'); 
        Route::post('/empleados', [EmployeeController::class, 'store'])->name('empleados.store');
        Route::get('/empleados/{empleado}/editar', [EmployeeController::class, 'edit'])->name('empleados.edit');
        Route::patch('/empleados/{empleado}', [EmployeeController::class, 'update'])->name('empleados.update');
        Route::post('/empleados/{empleado}/message', [EmployeeController::class, 'sendMessage'])->name('empleados.message');
        Route::delete('/empleados/{empleado}', [EmployeeController::class, 'destroy'])->name('empleados.destroy');
        
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
        
        // Gestión de Ausencias
        Route::get('/ausencias', [LeaveRequestController::class, 'index'])->name('ausencias.index');
        Route::patch('/ausencias/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('ausencias.approve');
        Route::patch('/ausencias/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('ausencias.reject');
    });

    // --- ZONA DE EMPLEADO (Y ADMIN) ---
    // Ver Perfil Propio (Esta ruta DEBE ir después de /empleados/crear para evitar conflictos)
    Route::get('/empleados/{empleado}', [EmployeeController::class, 'show'])->name('empleados.show');
    
    // Acciones de Empleado
    Route::get('/empleados/{empleado}/timesheets/crear', [TimesheetController::class, 'create'])->name('timesheets.create');
    Route::post('/empleados/{empleado}/timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');
    Route::get('/empleados/{empleado}/ausencias/crear', [LeaveRequestController::class, 'create'])->name('ausencias.create');
    Route::post('/empleados/{empleado}/ausencias', [LeaveRequestController::class, 'store'])->name('ausencias.store');
});

require __DIR__.'/auth.php';