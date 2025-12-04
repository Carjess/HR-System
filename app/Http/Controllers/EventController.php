<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\LeaveRequest;
use App\Models\Department;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Muestra el calendario con todos los eventos.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Obtener Eventos Manuales (Feriados, Reuniones, Entregas)
        $eventsQuery = Event::where(function($q) use ($user) {
            $q->whereNull('department_id') // Para todos
              ->orWhere('department_id', $user->position?->department_id) // Para mi depto
              ->orWhere('created_by', $user->id); // CORRECCIÓN: Ver eventos que YO creé (Admin)
        });
        
        $systemEvents = $eventsQuery->get()->map(function ($event) {
            return [
                'id' => 'evt_' . $event->id,
                'title' => $event->title,
                'start' => $event->start_date->toIso8601String(),
                'end' => $event->end_date ? $event->end_date->toIso8601String() : null,
                'description' => $event->description,
                'backgroundColor' => $event->color ?? '#3B82F6', // Usar color guardado o azul por defecto
                'borderColor' => $event->color ?? '#3B82F6',
                'extendedProps' => [
                    'type' => $event->type,
                    'is_vacation' => false,
                    'department' => $event->department ? $event->department->name : 'General',
                    'real_id' => $event->id
                ]
            ];
        });

        // 2. Obtener Vacaciones Aprobadas
        $vacations = LeaveRequest::with('employee')
            ->where('status', 'aprobado')
            ->get()
            ->map(function ($leave) {
                // Las vacaciones suelen incluir el día final, ajustamos visualmente si es necesario
                // Pero para la lógica de bucle JS, pasamos las fechas tal cual.
                return [
                    'id' => 'leave_' . $leave->id,
                    'title' => '🏖️ ' . explode(' ', $leave->employee->name)[0],
                    'start' => $leave->start_date,
                    'end' => $leave->end_date, // Pasamos fecha fin real de la solicitud
                    'description' => 'Vacaciones de ' . $leave->employee->name,
                    'backgroundColor' => '#10B981', // Verde Esmeralda
                    'borderColor' => '#10B981',
                    'extendedProps' => [
                        'type' => 'vacation',
                        'is_vacation' => true,
                        'real_id' => $leave->id
                    ]
                ];
            });

        // 3. Fusionar todo
        $allEvents = $systemEvents->toBase()->merge($vacations);
        
        $departments = Department::orderBy('name')->get();

        return view('calendar.index', [
            'events' => $allEvents,
            'departments' => $departments
        ]);
    }

    /**
     * Guardar evento nuevo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'type' => 'required|string',
            'color' => 'nullable|string', 
        ]);

        Event::create([
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type,
            'department_id' => $request->department_id,
            'description' => $request->description,
            'color' => $request->color, 
            'created_by' => Auth::id()
        ]);

        return back()->with('status', 'Evento agendado correctamente.');
    }
    
    /**
     * Eliminar evento.
     */
    public function destroy($id)
    {
        $realId = str_replace('evt_', '', $id);
        $event = Event::findOrFail($realId);
        $event->delete();
        
        return back()->with('status', 'Evento eliminado.');
    }
}