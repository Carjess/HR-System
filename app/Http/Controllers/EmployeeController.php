<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = User::with('position')->get();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            // 1. Buscamos todos los puestos en la BD
        $posiciones = Position::all();

        // 2. Devolvemos la vista (que crearemos ahora) y le pasamos la lista de puestos
        return view('empleados.create', compact('posiciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación (simple por ahora)
    // Si falla, Laravel automáticamente regresa al formulario
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email', // 'unique:users' asegura que el email no exista ya
        'password' => 'required|string|min:8',
        'position_id' => 'required|exists:positions,id' // Asegura que el 'id' del puesto exista
    ]);

    // 2. Crear el Empleado (User)
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // ¡Importante! Encriptar la contraseña
        'telefono' => $request->telefono,
        'direccion' => $request->direccion,
        'fecha_contratacion' => $request->fecha_contratacion,
        'position_id' => $request->position_id,
    ]);

    // 3. Redireccionar de vuelta a la lista
    // 'with' añade un mensaje de éxito temporal
    return redirect()->route('empleados.index')->with('status', 'Empleado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $empleado)
    {
        // Ahora también cargamos 'timesheets'
        $empleado->load('contracts.type', 'position', 'timesheets', 'payslips');

         return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $empleado)
    {
        // 'User $empleado' se llama Route Model Binding.
        // Laravel automáticamente busca al empleado con el ID de la URL.

        // 1. Buscamos todos los puestos para el menú desplegable
        $posiciones = Position::all();

        // 2. Devolvemos la vista (que crearemos ahora) y le pasamos
        //    el empleado que encontramos Y la lista de puestos
        return view('empleados.edit', compact('empleado', 'posiciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $empleado)
{
    // 1. Validación
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            // Esta regla 'unique' ignora el email del empleado actual
            Rule::unique('users')->ignore($empleado->id),
        ],
        'password' => 'nullable|string|min:8', // 'nullable' lo hace opcional
        'position_id' => 'required|exists:positions,id'
    ]);

    // 2. Preparar los datos
    $data = $request->only('name', 'email', 'telefono', 'direccion', 'fecha_contratacion', 'position_id');

    // 3. Actualizar la contraseña SÓLO SI se escribió una nueva
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // 4. Guardar los cambios en el empleado
    $empleado->update($data);

    // 5. Redireccionar de vuelta a la lista con un mensaje
    return redirect()->route('empleados.index')->with('status', 'Empleado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $empleado)
    {
        // 1. Elimina al empleado de la base de datos
        $empleado->delete();

        // 2. Redirecciona de vuelta a la lista con un mensaje
        return redirect()->route('empleados.index')->with('status', 'Empleado eliminado exitosamente.');
    }
}
