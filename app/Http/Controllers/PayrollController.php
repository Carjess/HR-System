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
use Illuminate\Support\Facades\Auth; 
// Quitamos el 'use' problemático y lo llamamos directo abajo

class PayrollController extends Controller
{
    /**
     * Muestra la página de generación de nómina y el historial (ADMIN).
     */
    public function index()
    {
        $departments = Department::orderBy('name')->get();

        $payrollHistory = Payslip::select(
                'pay_period_start',
                'pay_period_end',
                'notes', 
                DB::raw('count(*) as total_employees'),
                DB::raw('sum(net_pay) as total_amount')
            )
            ->groupBy('pay_period_start', 'pay_period_end', 'notes') 
            ->orderBy('pay_period_start', 'desc')
            ->paginate(5);

        return view('payroll.index', compact('payrollHistory', 'departments'));
    }

    /**
     * Muestra la lista de recibos de nómina de un empleado específico.
     */
    public function misRecibos(Request $request, User $empleado)
    {
        $user = Auth::user();
        
        if ($user->id !== $empleado->id && !$user->can('is-admin')) {
            abort(403, 'No tienes permiso para ver estos recibos.');
        }

        $payslips = $empleado->payslips()
            ->orderBy('pay_period_start', 'desc')
            ->paginate(10);

        return view('empleados.recibos', compact('empleado', 'payslips'));
    }

    /**
     * Genera la nómina (Pago de Nómina) - ADMIN.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
            'department_id' => 'nullable|exists:departments,id',
            'position_id'   => 'nullable|exists:positions,id',
            'notes'         => 'nullable|string|max:500', 
        ]);

        $month = $request->month;
        $year = $request->year;
        $departmentId = $request->department_id;
        $positionId = $request->position_id;
        $notes = $request->notes; 

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

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
            return redirect()->route('payroll.index')
                ->with('error', "Error: Ya existen pagos registrados para este periodo.");
        }

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

        foreach ($employees as $employee) {
            $contract = $employee->contracts()
                ->where('start_date', '<=', $endDate)
                ->where(function($query) use ($startDate) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>=', $startDate);
                })
                ->first();

            if (!$contract) continue; 

            $totalHours = $employee->timesheets()
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('hours_worked');

            $baseSalary = $contract->salary;
            $bonuses = 0;
            $deductions = $baseSalary * 0.10; 
            $netPay = ($baseSalary + $bonuses) - $deductions;
            
            Payslip::create([
                'employee_id' => $employee->id,
                'pay_period_start' => $startDate,
                'pay_period_end' => $endDate,
                'base_salary' => $baseSalary,
                'total_hours' => $totalHours,
                'bonuses' => $bonuses,
                'deductions' => $deductions,
                'net_pay' => $netPay,
                'notes' => $notes,
            ]);

            $payslipsGenerated++;
        }

        if ($payslipsGenerated == 0) {
            return redirect()->route('payroll.index')->with('error', "No se encontraron empleados aptos para pago.");
        }

        return redirect()->route('payroll.index')->with('status', "¡Éxito! Se generaron $payslipsGenerated recibos.");
    }

    /**
     * Descargar el recibo en PDF.
     */
    public function download(Payslip $payslip)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->id !== $payslip->employee_id) {
            abort(403, 'No tienes permiso para ver este recibo.');
        }

        $payslip->load('employee.position.department');

        // CORRECCIÓN: Usamos la clase completa con barra invertida inicial para evitar problemas de alias
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.payslip', compact('payslip'));
        
        $pdf->setPaper('letter', 'portrait');

        return $pdf->download('Recibo_Nomina_' . $payslip->employee->name . '_' . $payslip->pay_period_start . '.pdf');
    }
}