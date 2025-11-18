<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ContractTypeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\PayrollController;

// Los modelos se usan DENTRO de la ruta del dashboard
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
// (Estas deben estar AFUERA del 'auth')
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

// --- RUTA DEL DASHBOARD ---
Route::get('/dashboard', function () {
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
})->middleware(['auth', 'verified'])->name('dashboard');
// --- FIN RUTA DASHBOARD ---


// --- RUTAS DE PERFIL Y APLICACIÓN ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTAS DE EMPLEADOS
    Route::get('/empleados', [EmployeeController::class, 'index'])->name('empleados.index');
    Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('empleados.create'); 
    Route::post('/empleados', [EmployeeController::class, 'store'])->name('empleados.store');
    Route::get('/empleados/{empleado}', [EmployeeController::class, 'show'])->name('empleados.show');
    Route::get('/empleados/{empleado}/editar', [EmployeeController::class, 'edit'])->name('empleados.edit');
    Route::patch('/empleados/{empleado}', [EmployeeController::class, 'update'])->name('empleados.update');
    Route::delete('/empleados/{empleado}', [EmployeeController::class, 'destroy'])->name('empleados.destroy');
    
    // RUTAS DE TIPOS DE CONTRATO
    Route::resource('tipos-contrato', ContractTypeController::class);
    
    // RUTAS DE CONTRATOS
    Route::get('/empleados/{empleado}/contratos/crear', [ContractController::class, 'create'])->name('empleados.contratos.create');
    Route::post('/empleados/{empleado}/contratos', [ContractController::class, 'store'])->name('empleados.contratos.store');
    Route::get('/contratos/{contract}/editar', [ContractController::class, 'edit'])->name('contratos.edit');
    Route::patch('/contratos/{contract}', [ContractController::class, 'update'])->name('contratos.update');
    Route::delete('/contratos/{contract}', [ContractController::class, 'destroy'])->name('contratos.destroy');
    
    // RUTAS DE TIMESHEETS
    Route::get('/empleados/{empleado}/timesheets/crear', [TimesheetController::class, 'create'])->name('timesheets.create');
    Route::post('/empleados/{empleado}/timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');
    Route::get('/timesheets/{timesheet}/editar', [TimesheetController::class, 'edit'])->name('timesheets.edit');
    Route::patch('/timesheets/{timesheet}', [TimesheetController::class, 'update'])->name('timesheets.update');
    Route::delete('/timesheets/{timesheet}', [TimesheetController::class, 'destroy'])->name('timesheets.destroy');
    
    // RUTAS DE NÓMINA
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::post('/payroll/generate', [PayrollController::class, 'generate'])->name('payroll.generate');

});

require __DIR__.'/auth.php';