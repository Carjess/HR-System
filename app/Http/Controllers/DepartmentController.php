<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Lista de departamentos con búsqueda y conteos.
     */
    public function index(Request $request)
    {
        // Usamos withCount('positions') para saber cuántos cargos tiene cada depto.
        // También cargamos 'positions.users' para contar el personal (esto ya lo usábamos en la vista)
        $query = Department::with(['positions.users'])->withCount('positions');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $departments = $query->orderBy('name')->paginate(10);

        return view('departments.index', [
            'departments' => $departments,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create($request->all());

        return redirect()->route('departamentos.index')->with('status', 'Departamento creado exitosamente.');
    }

    public function edit(Department $departamento)
    {
        return view('departments.edit', compact('departamento'));
    }

    public function update(Request $request, Department $departamento)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $departamento->id,
        ]);

        $departamento->update($request->all());

        return redirect()->route('departamentos.index')->with('status', 'Departamento actualizado exitosamente.');
    }

    public function destroy(Department $departamento)
    {
        $departamento->delete();
        return redirect()->route('departamentos.index')->with('status', 'Departamento eliminado exitosamente.');
    }

    public function getPositions(Department $departamento)
    {
        return response()->json($departamento->positions()->select('id', 'name')->get());
    }
}