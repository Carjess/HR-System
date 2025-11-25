<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Department; 
use App\Models\ContractType;
use App\Models\Message; // <-- Importante para la función de mensajes

class EmployeeController extends Controller
{

    /**
     * Muestra la lista de empleados con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = User::with(['position.department.positions']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('department_id')) {
            $query->whereHas('position', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }
        
        $empleados = $query->latest('created_at')->paginate(10);
        $departments = Department::orderBy('name')->get();

        return view('empleados.index', [
            'empleados' => $empleados,
            'departments' => $departments,
            'filters' => $request->only(['search', 'department_id'])
        ]);
    }

    /**
     * Muestra el formulario de creación (aunque ahora usamos modal, se mantiene por si acaso).
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('empleados.create', compact('departments'));
    }

    /**
     * Guarda un nuevo empleado.
     */
    public function store(Request $request)
    {
        // 1. Limpieza previa de datos
        $input = $request->all();
        if (isset($input['telefono'])) {
            $input['telefono'] = preg_replace('/[^0-9]/', '', $input['telefono']);
        }
        $request->replace($input);

        // 2. Validación
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'position_id' => 'required|exists:positions,id',
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => 'nullable|string|max:255',
            'fecha_contratacion' => 'nullable|date',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_contratacion' => $request->fecha_contratacion,
            'position_id' => $request->position_id,
        ]);

        return redirect()->route('empleados.index')->with('status', 'Empleado creado exitosamente.');
    }

    /**
     * Muestra el perfil del empleado.
     */
    public function show(User $empleado)
    {
        // Cargamos todas las relaciones necesarias para el perfil
        $empleado->load('contracts.type', 'position', 'timesheets', 'payslips', 'leaveRequests');
        
        // Cargamos los tipos de contrato para el modal de "Nuevo Contrato"
        $contractTypes = ContractType::all();

        return view('empleados.show', compact('empleado', 'contractTypes'));
    }

    /**
     * Muestra el formulario de edición (usado por el modal en index).
     */
    public function edit(User $empleado)
    {
        $departments = Department::orderBy('name')->get();
        $currentDepartmentId = $empleado->position ? $empleado->position->department_id : null;
        $positions = $currentDepartmentId ? Position::where('department_id', $currentDepartmentId)->get() : [];

        return view('empleados.edit', compact('empleado', 'departments', 'currentDepartmentId', 'positions'));
    }

    /**
     * Actualiza un empleado existente.
     */
    public function update(Request $request, User $empleado)
    {
        // 1. Limpieza previa de datos
        $input = $request->all();
        if (isset($input['telefono'])) {
            $input['telefono'] = preg_replace('/[^0-9]/', '', $input['telefono']);
        }
        $request->replace($input);

        // 2. Validación
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($empleado->id),
            ],
            'password' => 'nullable|string|min:8',
            'position_id' => 'required|exists:positions,id',
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => 'nullable|string|max:255',
            'fecha_contratacion' => 'nullable|date',
        ]);

        $data = $request->only('name', 'email', 'telefono', 'direccion', 'fecha_contratacion', 'position_id');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $empleado->update($data);

        return redirect()->route('empleados.index')->with('status', 'Empleado actualizado exitosamente.');
    }

    /**
     * Elimina un empleado.
     */
    public function destroy(User $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')->with('status', 'Empleado eliminado exitosamente.');
    }

    /**
     * Envía un mensaje interno a un empleado.
     */
    public function sendMessage(Request $request, User $empleado)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => auth()->id(),      // El admin logueado
            'receiver_id' => $empleado->id,   // El empleado del perfil
            'subject' => $request->subject,
            'body' => $request->message,
            'allow_reply' => true,            // Por defecto permitimos respuesta
        ]);
        
        return back()->with('status', 'Mensaje enviado correctamente a ' . $empleado->name);
    }
}