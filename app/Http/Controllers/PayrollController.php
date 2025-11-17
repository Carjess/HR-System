<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contract;
use App\Models\Timesheet;
use App\Models\Payslip;
use Carbon\Carbon; 


class PayrollController extends Controller
{
    public function index()
    {
        return view('payroll.index');
    }

   
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

        // 4. Borrar nóminas viejas de ESE período para evitar duplicados
        Payslip::whereBetween('pay_period_start', [$startDate, $endDate])->delete();

        // 5. Recorrer cada empleado para calcular su nómina
        foreach ($employees as $employee) {

            // 6. Encontrar el contrato ACTIVO de este empleado
            // (Asumimos que es el contrato más reciente, puedes hacer esta lógica más compleja)
            $contract = $employee->contracts()->latest('start_date')->first();

            // Si no tiene contrato, no podemos pagarle. Saltamos a la siguiente persona.
            if (!$contract) {
                continue;
            }

            // 7. Encontrar las horas trabajadas en ESE período
            $totalHours = $employee->timesheets()
                ->whereBetween('date', [$startDate, $endDate])
                // ->where('status', 'aprobado') // (No hicimos el status, pero así sería)
                ->sum('hours_worked');

            // 8. Calcular el pago
            // Lógica simple: si tiene horas, le pagamos por hora.
            // Si no tiene horas (ej. es asalariado), le pagamos el salario base.
            
            $baseSalary = $contract->salary; // Salario base del contrato
            $netPay = $baseSalary; // Por defecto, es el salario base

            // (Aquí podrías añadir una lógica más compleja)
            // EJ: Si el salario es por hora, $netPay = $totalHours * $baseSalary;
            // Por ahora, solo pagaremos el salario base + un bonus por horas extra (ej.)
            
            $bonuses = 0;
            $deductions = $baseSalary * 0.10; // Ej. 10% de deducción

            // Cálculo final (muy simple, puedes mejorarlo)
            $netPay = ($baseSalary + $bonuses) - $deductions;
            
            // 9. Guardar el recibo (Payslip) en la base de datos
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

        return redirect()->route('payroll.index')->with('status', "$payslipsGenerated recibos de nómina generados para $month/$year.");
    }
}
