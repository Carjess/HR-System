<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveRequestController;
use App\Models\User;
use App\Models\Contract;
use App\Models\Timesheet;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (VISIBLES SIN INICIAR SESIÓN)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/sobre-nosotros', function () {
    return view('pages.about');
})->name('about');

// --- RUTAS PARA LAS PÁGINAS DE PRODUCTOS ---
Route::get('/productos/gestion-de-personal', function () {
    return view('pages.products-personnel');
})->name('products.personnel');

Route::get('/productos/gestion-de-contratos', function () {
    return view('pages.products-contracts');
})->name('products.contracts');

Route::get('/productos/facturacion-de-horas', function () {
    return view('pages.products-timesheets');
})->name('products.timesheets');

Route::get('/productos/pagos-de-nomina', function () {
    return view('pages.products-payroll');
})->name('products.payroll');
// --- FIN DE RUTAS DE PRODUCTOS ---


/*
|--------------------------------------------------------------------------
| RUTAS DE LA APLICACIÓN (PROTEGIDAS - REQUIEREN INICIO DE SESIÓN)
|--------------------------------------------------------------------------
*/

// --- RUTA DEL DASHBOARD (CON LÓGICA DE ROLES) ---
Route::get('/dashboard', function () {

    // 1. Verificamos si el usuario es un 'admin'
    if (auth()->user()->role === 'admin') {
        
        // Si es admin, le mostramos el dashboard de estadísticas
        $totalEmpleados = User::count();
        $totalContratosActivos = Contract::whereNull('end_date')->orWhere('end_date', '>', Carbon::now())->count();
        $horasEsteMes = Timesheet::whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('hours_worked');
        $empleadosRecientes = User::with('position')->latest('fecha_contratacion')->take(5)->get();
        
        return view('dashboard', [
            'totalEmpleados' => $totalEmpleados,
            'totalContratosActivos' => $totalContratosActivos,
            'horasEsteMes' => $horasEsteMes,
            'empleadosRecientes' => $empleadosRecientes
        ]);
    }

    // 2. Si NO es admin (es 'employee'), lo redirigimos a su propio perfil
    return redirect()->route('empleados.show', auth()->user()->id);

})->middleware(['auth', 'verified'])->name('dashboard');
// --- FIN RUTA DASHBOARD ---


// --- RUTAS DE PERFIL Y APLICACIÓN ---
Route::middleware('auth')->group(function () {
    
    // RUTAS DE PERFIL (Para todos los usuarios logueados)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- INICIO DEL GRUPO SÓLO PARA ADMINS ---
    Route::middleware('can:is-admin')->group(function () {

        // RUTAS DE GESTIÓN DE EMPLEADOS
        Route::get('/empleados', [EmployeeController::class, 'index'])->name('empleados.index');
        Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('empleados.create'); 
        Route::post('/empleados', [EmployeeController::class, 'store'])->name('empleados.store');
        Route::get('/empleados/{empleado}/editar', [EmployeeController::class, 'edit'])->name('empleados.edit');
        Route::patch('/empleados/{empleado}', [EmployeeController::class, 'update'])->name('empleados.update');
        Route::delete('/empleados/{empleado}', [EmployeeController::class, 'destroy'])->name('empleados.destroy');
        
        // RUTAS DE TIPOS DE CONTRATO
        Route::resource('tipos-contrato', ContractTypeController::class);
        
        // RUTAS DE GESTIÓN DE CONTRATOS (Admin)
        Route::get('/contratos/{contract}/editar', [ContractController::class, 'edit'])->name('contratos.edit');
        Route::patch('/contratos/{contract}', [ContractController::class, 'update'])->name('contratos.update');
        Route::delete('/contratos/{contract}', [ContractController::class, 'destroy'])->name('contratos.destroy');
        // Admin también puede crear contratos para empleados desde el panel
        Route::get('/empleados/{empleado}/contratos/crear', [ContractController::class, 'create'])->name('empleados.contratos.create');
        Route::post('/empleados/{empleado}/contratos', [ContractController::class, 'store'])->name('empleados.contratos.store');
        
        // RUTAS DE GESTIÓN DE TIMESHEETS (Admin)
        Route::get('/timesheets/{timesheet}/editar', [TimesheetController::class, 'edit'])->name('timesheets.edit');
        Route::patch('/timesheets/{timesheet}', [TimesheetController::class, 'update'])->name('timesheets.update');
        Route::delete('/timesheets/{timesheet}', [TimesheetController::class, 'destroy'])->name('timesheets.destroy');
        
        // RUTAS DE NÓMINA
        Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
        Route::post('/payroll/generate', [PayrollController::class, 'generate'])->name('payroll.generate');

        // --- NUEVAS RUTAS: GESTIÓN DE AUSENCIAS (Admin) ---
        // Estas son las rutas que te faltaban en el mensaje anterior
        Route::get('/ausencias', [LeaveRequestController::class, 'index'])->name('ausencias.index');
        Route::patch('/ausencias/{leaveRequest}/approve', [LeaveRequestController::class, 'approve'])->name('ausencias.approve');
        Route::patch('/ausencias/{leaveRequest}/reject', [LeaveRequestController::class, 'reject'])->name('ausencias.reject');

    });
    // --- FIN DEL GRUPO SÓLO PARA ADMINS ---


    // --- RUTAS PÚBLICAS DE EMPLEADO (Para todos los usuarios logueados) ---
    
    // Ver perfil (Esta ruta DEBE ir después de las rutas específicas como /crear para evitar conflictos)
    Route::get('/empleados/{empleado}', [EmployeeController::class, 'show'])->name('empleados.show');
    
    // Timesheets (Crear)
    Route::get('/empleados/{empleado}/timesheets/crear', [TimesheetController::class, 'create'])->name('timesheets.create');
    Route::post('/empleados/{empleado}/timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');

    // Ausencias (Crear)
    Route::get('/empleados/{empleado}/ausencias/crear', [LeaveRequestController::class, 'create'])->name('ausencias.create');
    Route::post('/empleados/{empleado}/ausencias', [LeaveRequestController::class, 'store'])->name('ausencias.store');

});

require __DIR__.'/auth.php';