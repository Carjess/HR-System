<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
        public function create(User $empleado)
    {
        return view('timesheets.create', compact('empleado'));
    }

    /**
     * Guarda el nuevo registro de horas.
     */
    public function store(Request $request, User $empleado)
    {
        $request->validate([
            'date' => 'required|date',
            'hours_worked' => 'required|numeric|min:0.1|max:24',
        ]);

        $empleado->timesheets()->create([
            'date' => $request->date,
            'hours_worked' => $request->hours_worked,
            'status' => 'aprobado' // Por ahora, lo aprobamos automáticamente.
        ]);

        return redirect()->route('empleados.show', $empleado->id)->with('status', 'Horas registradas exitosamente.');
    }

    /**
     * Muestra el formulario para editar un registro de horas.
     */
    public function edit(Timesheet $timesheet)
    {
        // $timesheet ya se cargó gracias al Route Model Binding
        return view('timesheets.edit', compact('timesheet'));
    }

    /**
     * Actualiza un registro de horas.
     */
    public function update(Request $request, Timesheet $timesheet)
    {
        $request->validate([
            'date' => 'required|date',
            'hours_worked' => 'required|numeric|min:0.1|max:24',
        ]);

        $timesheet->update([
            'date' => $request->date,
            'hours_worked' => $request->hours_worked,
        ]);

        // Redireccionamos de vuelta al perfil del empleado
        return redirect()->route('empleados.show', $timesheet->employee_id)->with('status', 'Registro de horas actualizado.');
    }

    /**
     * Elimina un registro de horas.
     */
    public function destroy(Timesheet $timesheet)
    {
        $employeeId = $timesheet->employee_id;
        $timesheet->delete();

        return redirect()->route('empleados.show', $employeeId)->with('status', 'Registro de horas eliminado.');
    }
}
