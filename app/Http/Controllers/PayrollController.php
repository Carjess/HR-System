<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contract;
use App\Models\Timesheet;
use App\Models\Payslip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // <-- ¡Importante para agrupar resultados!

class PayrollController extends Controller
{
    /**
     * Muestra la página de generación de nómina y el historial.
     */
    public function index()
    {
        // Obtenemos el historial de nóminas generadas
        // Agrupamos por fecha de inicio y fin para mostrar "lotes" de pago
        $payrollHistory = Payslip::select(
                'pay_period_start',
                'pay_period_end',
                DB::raw('count(*) as total_employees'),
                DB::raw('sum(net_pay) as total_amount')
            )
            ->groupBy('pay_period_start', 'pay_period_end')
            ->orderBy('pay_period_start', 'desc')
            ->paginate(5); // Paginación de 5 en 5

        return view('payroll.index', compact('payrollHistory'));
    }

    /**
     * Genera la nómina para un mes y año específicos.
     */
    public function generate(Request $request)
    {
        // 1. Validar la entrada
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
        ]);

        $month = $request->month;
        $year = $request->year;

        // 2. Definir el período de pago
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // 3. Obtener TODOS los empleados
        $employees = User::all();
        $payslipsGenerated = 0;

        // 4. Borrar nóminas viejas de ESE período para evitar duplicados y permitir regenerar
        Payslip::whereBetween('pay_period_start', [$startDate, $endDate])->delete();

        // 5. Recorrer cada empleado para calcular su nómina
        foreach ($employees as $employee) {

            // 6. Encontrar el contrato ACTIVO de este empleado
            // Usamos whereDate para asegurar que el contrato cubra el periodo
            $contract = $employee->contracts()
                ->where('start_date', '<=', $endDate)
                ->where(function($query) use ($startDate) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>=', $startDate);
                })
                ->first();

            // Si no tiene contrato activo en este periodo, saltamos.
            if (!$contract) {
                continue;
            }

            // 7. Encontrar las horas trabajadas en ESE período
            // (Podrías filtrar por 'aprobado' si hubieras implementado ese flujo completo)
            $totalHours = $employee->timesheets()
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('hours_worked');

            // 8. Calcular el pago
            $baseSalary = $contract->salary;
            
            // Ejemplo simple: Si el tipo de contrato es 'Por Hora' (id X), podrías multiplicar.
            // Por ahora asumimos salario mensual fijo + horas extra conceptuales si quisieras.
            
            $bonuses = 0;
            $deductions = $baseSalary * 0.10; // Ejemplo: 10% deducciones de ley

            // Cálculo final
            $netPay = ($baseSalary + $bonuses) - $deductions;
            
            // 9. Guardar el recibo (Payslip)
            Payslip::create([
                'employee_id' => $employee->id,
                'pay_period_start' => $startDate,
                'pay_period_end' => $endDate,
                'base_salary' => $baseSalary,
                'total_hours' => $totalHours,
                'bonuses' => $bonuses,
                'deductions' => $deductions,
                'net_pay' => $netPay,
            ]);

            $payslipsGenerated++;
        }

        if ($payslipsGenerated == 0) {
            return redirect()->route('payroll.index')->with('error', "No se encontraron empleados con contrato activo para el período $month/$year.");
        }

        return redirect()->route('payroll.index')->with('status', "Se generaron $payslipsGenerated recibos de nómina para $month/$year exitosamente.");
    }
}