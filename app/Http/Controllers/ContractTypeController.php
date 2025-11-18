<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use Illuminate\Http\Request; // <-- ¡Asegúrate de que este 'use' esté!

class ContractTypeController extends Controller
{
    /**
     * Muestra una lista paginada y filtrable de tipos de contrato.
     */
    public function index(Request $request)
    {
        $query = ContractType::query();

        // 1. Aplicamos el filtro de búsqueda (si existe)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // 2. Paginamos los resultados (5 por página)
        $tipos = $query->latest('created_at')->paginate(5);

        // 3. Devolvemos la vista con los datos
        return view('contract_types.index', [
            'tipos' => $tipos,
            'filters' => $request->only(['search']) // Para recordar qué se buscó
        ]);
    }

    /**
     * Muestra el formulario de creación
     */
    public function create()
    {
        return view('contract_types.create');
    }

    /**
     * Guarda el nuevo tipo
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:contract_types,name']);
        
        ContractType::create($request->all()); 
        
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato creado.');
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit(ContractType $tiposContrato)
    {
        // Gracias a Route::resource, Laravel pasa el objeto completo
        return view('contract_types.edit', compact('tiposContrato'));
    }

    /**
     * Actualiza el tipo
     */
    public function update(Request $request, ContractType $tiposContrato)
    {
        $request->validate(['name' => 'required|string|unique:contract_types,name,' . $tiposContrato->id]);
        $tiposContrato->update($request->all());
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato actualizado.');
    }

    /**
     * Elimina el tipo
     */
    public function destroy(ContractType $tiposContrato)
    {
        $tiposContrato->delete();
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato eliminado.');
    }
}