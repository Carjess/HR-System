<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /**
     * Muestra la lista de solicitudes (Admin) con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = LeaveRequest::with('employee');

        // 1. Filtro de Búsqueda (Por nombre del empleado)
        if ($request->filled('search')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Filtro por Estado (Pendiente, Aprobado, Rechazado)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Ordenamiento y Paginación
        // Primero las pendientes, luego las más recientes
        $requests = $query->orderByRaw("FIELD(status, 'pendiente', 'aprobado', 'rechazado')")
            ->orderByDesc('created_at')
            ->paginate(5); // 5 por página para probar la paginación redonda

        return view('leave_requests.index', [
            'requests' => $requests,
            'filters' => $request->only(['search', 'status'])
        ]);
    }

    /**
     * Muestra el formulario para crear una nueva solicitud de ausencia (Empleado).
     */
    public function create(User $empleado)
    {
        return view('leave_requests.create', compact('empleado'));
    }

    /**
     * Guarda la nueva solicitud de ausencia (Empleado).
     */
    public function store(Request $request, User $empleado)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:255',
        ]);

        $empleado->leaveRequests()->create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pendiente',
        ]);

        return redirect()->route('empleados.show', $empleado->id)->with('status', 'Solicitud de ausencia enviada exitosamente.');
    }

    /**
     * Aprueba una solicitud y guarda el mensaje opcional.
     */
    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        // Aquí guardamos el mensaje opcional del admin
        $leaveRequest->update([
            'status' => 'aprobado',
            'admin_response' => $request->admin_response 
        ]);
        
        return back()->with('status', 'Solicitud aprobada.');
    }

    /**
     * Rechaza una solicitud y guarda el mensaje opcional.
     */
    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        // Aquí guardamos el mensaje opcional del admin
        $leaveRequest->update([
            'status' => 'rechazado',
            'admin_response' => $request->admin_response
        ]);
        
        return back()->with('status', 'Solicitud rechazada.');
    }
}