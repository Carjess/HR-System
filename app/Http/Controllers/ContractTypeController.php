<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use Illuminate\Http\Request; // <-- ¡Asegúrate de añadir este use!

class ContractTypeController extends Controller
{
    // Muestra la lista
    public function index()
    {
        $tipos = ContractType::all();
        return view('contract_types.index', compact('tipos'));
    }

    // Muestra el formulario de creación
    public function create()
    {
        return view('contract_types.create');
    }

    // Guarda el nuevo tipo
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:contract_types,name']);
        
        // Necesitamos $fillable en el modelo! (Paso 4)
        ContractType::create($request->all()); 
        
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato creado.');
    }

    // Muestra el formulario de edición
    public function edit(ContractType $tiposContrato)
    {
        // Gracias a Route::resource, Laravel pasa el objeto completo
        return view('contract_types.edit', compact('tiposContrato'));
    }

    // Actualiza el tipo
    public function update(Request $request, ContractType $tiposContrato)
    {
        $request->validate(['name' => 'required|string|unique:contract_types,name,' . $tiposContrato->id]);
        $tiposContrato->update($request->all());
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato actualizado.');
    }

    // Elimina el tipo
    public function destroy(ContractType $tiposContrato)
    {
        $tiposContrato->delete();
        return redirect()->route('tipos-contrato.index')->with('status', 'Tipo de contrato eliminado.');
    }
}