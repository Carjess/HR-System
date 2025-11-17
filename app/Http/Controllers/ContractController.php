<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Contract;
use App\Models\ContractType;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function create(User $empleado)
{
    // $empleado se obtiene automáticamente de la URL

    // 1. Buscamos los tipos de contrato (Temporal, Indefinido, etc.)
    $tiposContrato = ContractType::all();

    // 2. Mostramos la vista y le pasamos el empleado y los tipos
    return view('contracts.create', compact('empleado', 'tiposContrato'));
}

/**
 * Guarda el nuevo contrato en la base de datos.
 */
public function store(Request $request, User $empleado)
{
    // 1. Validación
    $request->validate([
        'contract_type_id' => 'required|exists:contract_types,id',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after:start_date',
        'salary' => 'required|numeric|min:0',
    ]);

    // 2. Crear el contrato USANDO la relación
    // Esto automáticamente asigna el 'employee_id' correcto
    $empleado->contracts()->create([
        'contract_type_id' => $request->contract_type_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'salary' => $request->salary,
    ]);

    // 3. Redireccionar (idealmente, al perfil del empleado)
    // Por ahora, volvemos a la lista general de empleados
    return redirect()->route('empleados.index')->with('status', 'Contrato añadido al empleado exitosamente.');
}
public function edit(Contract $contract)
{
    // $contract se obtiene automáticamente de la URL

    // 1. Buscamos los tipos de contrato para el menú desplegable
    $tiposContrato = ContractType::all();

    // 2. Mostramos la vista (que crearemos ahora)
    return view('contracts.edit', compact('contract', 'tiposContrato'));
}

/**
 * Actualiza el contrato en la base de datos.
 */
public function update(Request $request, Contract $contract)
    {
        // 1. Validación (similar a 'store')
        $request->validate([
            'contract_type_id' => 'required|exists:contract_types,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'salary' => 'required|numeric|min:0',
        ]);

        // 2. Actualiza el contrato
        $contract->update([
            'contract_type_id' => $request->contract_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'salary' => $request->salary,
        ]);

        // 3. Redireccionar de vuelta al perfil del empleado
        // Usamos la relación para saber a qué perfil volver
        return redirect()->route('empleados.show', $contract->employee_id)->with('status', 'Contrato actualizado exitosamente.');
    }

public function destroy(Contract $contract)
    {
        // Guardamos el ID del empleado ANTES de borrar el contrato
        $employeeId = $contract->employee_id;

        // 1. Elimina el contrato
        $contract->delete();

        // 2. Redirecciona de vuelta al perfil del empleado
        return redirect()->route('empleados.show', $employeeId)->with('status', 'Contrato eliminado exitosamente.');
    }

}

