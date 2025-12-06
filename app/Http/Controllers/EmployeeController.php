<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Department; 
use App\Models\ContractType;
use App\Models\Message; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Importante para fechas

class EmployeeController extends Controller
{
    /**
     * Muestra el portal principal del empleado logueado (Self-Service).
     * Este es el "Dashboard" personal del empleado.
     */
    public function portal()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // 1. Cargar relaciones necesarias para la vista rápida
        $user->load('position.department');

        // 2. Obtener últimas solicitudes de ausencia (Para la tabla de resumen)
        // Se asume que la relación en el modelo User se llama 'leaveRequests'
        $leaveRequests = $user->leaveRequests()
            ->latest()
            ->take(5) // Mostramos las últimas 5
            ->get();
        
        // 3. Calcular horas trabajadas este mes (Para la tarjeta de resumen)
        // Se asume que la relación en el modelo User se llama 'timesheets'
        $hoursThisMonth = $user->timesheets()
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->sum('hours_worked');

        // Retornamos la nueva vista "home-empleado"
        return view('empleados.home-empleado', compact('user', 'leaveRequests', 'hoursThisMonth'));
    }

    /**
     * Muestra la lista completa de ausencias de un empleado específico.
     * Usada en la sección "Mis Ausencias".
     */
    public function misAusencias(Request $request, User $empleado)
    {
        // Seguridad: Asegurarse de que el usuario solo vea sus propias ausencias 
        // (a menos que sea admin, pero esta vista es pensada para el empleado)
        if (auth()->user()->id !== $empleado->id && !auth()->user()->can('is-admin')) {
            abort(403, 'No tienes permiso para ver estas ausencias.');
        }

        // Iniciar consulta sobre las ausencias del empleado
        $query = $empleado->leaveRequests()->latest();

        // Filtro por búsqueda (motivo)
        if ($request->filled('search')) {
            $query->where('reason', 'like', '%' . $request->search . '%');
        }

        // Filtro por tipo
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Paginación
        $ausencias = $query->paginate(10);

        return view('empleados.ausencia', compact('empleado', 'ausencias'));
    }

    /**
     * Muestra la lista de empleados con filtros y paginación (Vista Admin).
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
     * Muestra el formulario de creación.
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
     * Muestra el perfil del empleado (Vista 360).
     */
    public function show(User $empleado)
    {
        // Cargamos relaciones del empleado
        $empleado->load('contracts.type', 'position', 'timesheets', 'payslips', 'leaveRequests');
        
        // Cargamos los tipos de contrato para el modal
        $contractTypes = ContractType::all();

        // --- Cargar historial de chat para el widget flotante ---
        $messages = Message::where(function($q) use ($empleado) {
                $q->where('sender_id', Auth::id())
                  ->where('receiver_id', $empleado->id);
            })
            ->orWhere(function($q) use ($empleado) {
                $q->where('sender_id', $empleado->id)
                  ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('empleados.show', compact('empleado', 'contractTypes', 'messages'));
    }

    /**
     * Muestra el formulario de edición.
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