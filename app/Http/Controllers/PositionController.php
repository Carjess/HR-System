<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $query = Position::with('department');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $positions = $query->orderBy('name')->paginate(10);
        return view('positions.index', [
            'positions' => $positions,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('positions.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        Position::create($request->all());

        // CAMBIO: Usamos back() para volver a la página anterior (útil para el modal)
        return back()->with('status', 'Puesto creado exitosamente.');
    }

    public function edit(Position $puesto)
    {
        $departments = Department::orderBy('name')->get();
        return view('positions.edit', compact('puesto', 'departments'));
    }

    public function update(Request $request, Position $puesto)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $puesto->update($request->all());

        // CAMBIO: Usamos back()
        return back()->with('status', 'Puesto actualizado exitosamente.');
    }

    public function destroy(Position $puesto)
    {
        $puesto->delete();
        return back()->with('status', 'Puesto eliminado exitosamente.');
    }
}