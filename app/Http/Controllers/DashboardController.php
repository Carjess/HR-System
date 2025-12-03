<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contract;
use App\Models\Timesheet;
use App\Models\Department;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Estadísticas Generales
        $totalEmpleados = User::count();
        
        // --- CORRECCIÓN AQUÍ ---
        // Eliminamos "where('is_active', true)" porque tu tabla no tiene esa columna.
        // Ahora solo miramos las fechas: si no tiene fecha fin, o si la fecha fin es en el futuro, cuenta como activo.
        $totalContratosActivos = Contract::where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', Carbon::now());
            })->count();
            
        $horasEsteMes = Timesheet::whereBetween('date', [
            Carbon::now()->startOfMonth(), 
            Carbon::now()->endOfMonth()
        ])->sum('hours_worked');

        // 2. Empleados Recientes (Usamos created_at para asegurar que salgan los nuevos)
        $empleadosRecientes = User::with('position.department')
                                  ->latest('created_at') 
                                  ->take(5)
                                  ->get();

        // 3. Gráfica de Distribución
        $deptStats = [];
        if ($totalEmpleados > 0) {
            $departments = Department::with('positions.users')->get();
            
            foreach ($departments as $dept) {
                $count = $dept->positions->flatMap->users->count();
                
                if ($count > 0) {
                    $percentage = round(($count / $totalEmpleados) * 100);
                    $deptStats[] = [
                        'name' => $dept->name,
                        'count' => $count,
                        'percentage' => $percentage,
                        'color' => $dept->color_hex ?? '#3B82F6'
                    ];
                }
            }
        }
        
        $departmentsList = Department::orderBy('name')->get();

        return view('dashboard', [
            'totalEmpleados' => $totalEmpleados,
            'totalContratosActivos' => $totalContratosActivos,
            'horasEsteMes' => $horasEsteMes,
            'empleadosRecientes' => $empleadosRecientes,
            'deptStats' => $deptStats,
            'departments' => $departmentsList 
        ]);
    }
}