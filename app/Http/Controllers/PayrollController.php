<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contract;
use App\Models\Timesheet;
use App\Models\Payslip;
use App\Models\Department;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Muestra la página de generación de nómina y el historial.
     */
    public function index()
    {
        // 1. Obtenemos departamentos para el filtro
        $departments = Department::orderBy('name')->get();

        // 2. Historial de nóminas
        // Agrupamos por periodo para mostrar "lotes" de pago
        $payrollHistory = Payslip::select(
                'pay_period_start',
                'pay_period_end',
                'notes', // <-- Traemos también la nota para mostrarla en detalles
                DB::raw('count(*) as total_employees'),
                DB::raw('sum(net_pay) as total_amount')
            )
            ->groupBy('pay_period_start', 'pay_period_end', 'notes') // Agrupamos también por nota
            ->orderBy('pay_period_start', 'desc')
            ->paginate(5);

        return view('payroll.index', compact('payrollHistory', 'departments'));
    }

    /**
     * Genera la nómina (Pago de Nómina).
     */
    public function generate(Request $request)
    {
        // 1. Validar la entrada
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
            'department_id' => 'nullable|exists:departments,id',
            'position_id'   => 'nullable|exists:positions,id',
            'notes'         => 'nullable|string|max:500', // <-- Validación para el mensaje
        ]);

        $month = $request->month;
        $year = $request->year;
        $departmentId = $request->department_id;
        $positionId = $request->position_id;
        $notes = $request->notes; // Capturamos el mensaje

        // 2. Definir el período de pago
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // 3. SEGURIDAD: Verificar si ya existen pagos para este grupo
        $existingQuery = Payslip::whereBetween('pay_period_start', [$startDate, $endDate]);

        if ($departmentId) {
            $existingQuery->whereHas('employee.position', function($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }
        if ($positionId) {
            $existingQuery->whereHas('employee', function($q) use ($positionId) {
                $q->where('position_id', $positionId);
            });
        }

        if ($existingQuery->exists()) {
            $target = "la selección actual";
            if($departmentId) $target = Department::find($departmentId)->name;
            if($positionId) $target .= " (" . Position::find($positionId)->name . ")";

            return redirect()->route('payroll.index')
                ->with('error', "Error de Seguridad: Ya existen pagos registrados para $target en $month/$year.");
        }


        // 4. Obtener los empleados a pagar
        $employeesQuery = User::query();

        if ($departmentId) {
            $employeesQuery->whereHas('position', function($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }
        if ($positionId) {
            $employeesQuery->where('position_id', $positionId);
        }

        $employees = $employeesQuery->get();
        $payslipsGenerated = 0;


        // 5. Procesar Nómina
        foreach ($employees as $employee) {

            $contract = $employee->contracts()
                ->where('start_date', '<=', $endDate)
                ->where(function($query) use ($startDate) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>=', $startDate);
                })
                ->first();

            if (!$contract) continue;

            // Calcular horas
            $totalHours = $employee->timesheets()
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('hours_worked');

            // Cálculos
            $baseSalary = $contract->salary;
            $bonuses = 0;
            $deductions = $baseSalary * 0.10;
            $netPay = ($baseSalary + $bonuses) - $deductions;
            
            // Crear recibo CON LA NOTA
            Payslip::create([
                'employee_id' => $employee->id,
                'pay_period_start' => $startDate,
                'pay_period_end' => $endDate,
                'base_salary' => $baseSalary,
                'total_hours' => $totalHours,
                'bonuses' => $bonuses,
                'deductions' => $deductions,
                'net_pay' => $netPay,
                'notes' => $notes, // <-- Guardamos el mensaje aquí
            ]);

            $payslipsGenerated++;
        }

        if ($payslipsGenerated == 0) {
            return redirect()->route('payroll.index')->with('error', "No se encontraron empleados aptos para pago en esta selección.");
        }

        return redirect()->route('payroll.index')->with('status', "¡Éxito! Se generaron $payslipsGenerated recibos de nómina.");
    }
}