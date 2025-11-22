<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class ContractTypeController extends Controller
{
    public function index(Request $request)
    {
        // Cargamos departamento y cargo para mostrar en la lista
        // También cargamos todos los departamentos para el modal de "Crear" en la vista index
        $query = ContractType::with(['department', 'position']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $tipos = $query->latest('created_at')->paginate(5);
        
        // Necesitamos los departamentos para el select del modal de crear
        $departments = Department::orderBy('name')->get();

        return view('contract_types.index', [
            'tipos' => $tipos,
            'departments' => $departments,
            'filters' => $request->only(['search'])
        ]);
    }

    // create() y edit() ya no se usarán porque usaremos modales en el index, 
    // pero los mantenemos por compatibilidad con la ruta resource.
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('contract_types.create', compact('departments'));
    }

    public function edit(ContractType $tiposContrato)
    {
        $departments = Department::orderBy('name')->get();
        return view('contract_types.edit', compact('tiposContrato', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contract_types,name',
            'salary' => 'required|numeric|min:0',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id', // Validamos cargo
            'description' => 'nullable|string|max:1000',
        ]);
        
        ContractType::create($request->all()); 
        
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato creado exitosamente.');
    }

    public function update(Request $request, ContractType $tiposContrato)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contract_types,name,' . $tiposContrato->id,
            'salary' => 'required|numeric|min:0',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'description' => 'nullable|string|max:1000',
        ]);

        $tiposContrato->update($request->all());
        
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato actualizado exitosamente.');
    }

    public function destroy(ContractType $tiposContrato)
    {
        $tiposContrato->delete();
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato eliminado.');
    }
}