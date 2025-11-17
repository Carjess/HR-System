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

Route::get('/', function () {
    return view('welcome');
});

// --- RUTA DEL DASHBOARD CORREGIDA ---
// La lógica debe ir DENTRO de la función.
Route::get('/dashboard', function () {

    // 1. Conteo de Empleados
    $totalEmpleados = User::count();

    // 2. Conteo de Contratos Activos
    $totalContratosActivos = Contract::whereNull('end_date')
                                    ->orWhere('end_date', '>', Carbon::now())
                                    ->count();

    // 3. Total de Horas Registradas este Mes
    $horasEsteMes = Timesheet::whereBetween('date', [
                                    Carbon::now()->startOfMonth(),
                                    Carbon::now()->endOfMonth()
                                ])->sum('hours_worked');

    // 4. Empleados Recientes (los últimos 5)
    $empleadosRecientes = User::with('position')
                                ->latest('fecha_contratacion')
                                ->take(5)
                                ->get();

    // 5. Pasamos todas las variables a la vista
    return view('dashboard', [
        'totalEmpleados' => $totalEmpleados,
        'totalContratosActivos' => $totalContratosActivos,
        'horasEsteMes' => $horasEsteMes,
        'empleadosRecientes' => $empleadosRecientes
    ]);

})->middleware(['auth', 'verified'])->name('dashboard');
// --- FIN DE LA RUTA DEL DASHBOARD ---


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- RUTAS DE EMPLEADOS (ORDEN CORREGIDO) ---
    Route::get('/empleados', [EmployeeController::class, 'index'])->name('empleados.index');
    Route::get('/empleados/crear', [EmployeeController::class, 'create'])->name('empleados.create'); 
    Route::post('/empleados', [EmployeeController::class, 'store'])->name('empleados.store');
    Route::get('/empleados/{empleado}', [EmployeeController::class, 'show'])->name('empleados.show');
    Route::get('/empleados/{empleado}/editar', [EmployeeController::class, 'edit'])->name('empleados.edit');
    Route::patch('/empleados/{empleado}', [EmployeeController::class, 'update'])->name('empleados.update');
    Route::delete('/empleados/{empleado}', [EmployeeController::class, 'destroy'])->name('empleados.destroy');
    // --- FIN RUTAS DE EMPLEADOS ---
    
    Route::resource('tipos-contrato', ContractTypeController::class);
    
    // Rutas de Contratos
    Route::get('/empleados/{empleado}/contratos/crear', [ContractController::class, 'create'])->name('empleados.contratos.create');
    Route::post('/empleados/{empleado}/contratos', [ContractController::class, 'store'])->name('empleados.contratos.store');
    Route::get('/contratos/{contract}/editar', [ContractController::class, 'edit'])->name('contratos.edit');
    Route::patch('/contratos/{contract}', [ContractController::class, 'update'])->name('contratos.update');
    Route::delete('/contratos/{contract}', [ContractController::class, 'destroy'])->name('contratos.destroy');
    
    // Rutas de Timesheets
    Route::get('/empleados/{empleado}/timesheets/crear', [TimesheetController::class, 'create'])->name('timesheets.create');
    Route::post('/empleados/{empleado}/timesheets', [TimesheetController::class, 'store'])->name('timesheets.store');
    Route::get('/timesheets/{timesheet}/editar', [TimesheetController::class, 'edit'])->name('timesheets.edit');
    Route::patch('/timesheets/{timesheet}', [TimesheetController::class, 'update'])->name('timesheets.update');
    Route::delete('/timesheets/{timesheet}', [TimesheetController::class, 'destroy'])->name('timesheets.destroy');
    
    // Rutas de Nómina
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::post('/payroll/generate', [PayrollController::class, 'generate'])->name('payroll.generate');

});

require __DIR__.'/auth.php';