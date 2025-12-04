<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
                
                {{ __('Agenda Corporativa') }}
            </h2>
            
            @can('is-admin')
            <!-- Botón Global para abrir panel -->
            <div x-data>
                <button @click="$dispatch('open-create-panel')" class="group relative inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-orange-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-700 hover:bg-orange-700 shadow-lg">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nuevo Evento
                </button>
            </div>
            @endcan
        </div>
    </x-slot>

    <!-- ESTILOS FULLCALENDAR (Optimizado Dark Mode y Grid Visible) -->
    <style>
        body { overflow: hidden; } 

        :root {
            /* Bordes visibles para la cuadrícula */
            --fc-border-color: #CBD5E1; 
            --fc-button-bg-color: #fff;
            --fc-button-text-color: #374151;
            --fc-button-border-color: #94A3B8;
            --fc-button-hover-bg-color: #F8FAFC;
            --fc-page-bg-color: #ffffff;
            --fc-neutral-bg-color: #F8FAFC;
            --fc-list-event-hover-bg-color: #F1F5F9;
        }
        
        .dark {
            --fc-border-color: #4B5563;
            --fc-button-bg-color: #1F2937;
            --fc-button-text-color: #E5E7EB;
            --fc-button-border-color: #6B7280;
            --fc-page-bg-color: #1F2937;
            --fc-neutral-bg-color: #374151;
            --fc-list-event-hover-bg-color: #374151;
            color: #E5E7EB;
        }

        .fc { font-family: 'Figtree', sans-serif; }
        
        /* Ajustes Dark Mode para textos */
        .dark .fc-col-header-cell-cushion,
        .dark .fc-daygrid-day-number,
        .dark .fc-timegrid-slot-label-cushion {
            color: #E5E7EB !important; 
        }

        /* Cabecera de días */
        .fc-col-header-cell {
            background-color: #315762 !important; 
            border: 1px solid #1f3a42 !important;
            padding: 10px 0 !important;
        }
        .fc-col-header-cell:first-child { border-top-left-radius: 16px !important; }
        .fc-col-header-cell:last-child { border-top-right-radius: 16px !important; }

        .fc-col-header-cell-cushion {
            color: white !important; 
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-decoration: none !important;
        }

        .fc-theme-standard td, .fc-theme-standard th {
            border: 1px solid var(--fc-border-color) !important;
        }

        .fc-daygrid-day { transition: background-color 0.2s ease !important; }
        .fc-daygrid-day-frame { min-height: 100%; padding: 4px; }
        
        .fc-daygrid-day:hover { background-color: #F8FAFC !important; cursor: pointer; }
        .dark .fc-daygrid-day:hover { background-color: #374151 !important; }

        /* Estilo del día de hoy (Sin amarillo) */
        .fc .fc-day-today { background-color: transparent !important; }
        .fc .fc-day-today .fc-daygrid-day-frame {
            background-color: rgba(49, 87, 98, 0.05) !important; 
            border: 2px solid #315762 !important; 
            border-radius: 8px;
        }
        .dark .fc .fc-day-today .fc-daygrid-day-frame {
            background-color: rgba(49, 87, 98, 0.3) !important;
            border-color: #438591 !important;
        }

        .fc-scrollgrid {
            border-radius: 16px !important;
            overflow: hidden;
            border: 1px solid var(--fc-border-color) !important;
        }

        .fc-button {
            border-radius: 10px !important;
            font-weight: 700 !important;
            text-transform: capitalize !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            padding: 0.5rem 1rem !important;
        }
        .fc-button-active {
            background-color: #315762 !important;
            color: white !important;
            border-color: #315762 !important;
        }
        .dark .fc-button-active { background-color: #438591 !important; border-color: #438591 !important; }

        /* ESTILO CRÍTICO PARA EL COLOR DEL EVENTO */
        .fc-event {
            border: none !important;
            border-radius: 6px !important;
            font-size: 0.75rem;
            font-weight: 600;
            margin: 2px 3px !important;
            padding: 3px 6px !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            cursor: pointer;
            /* Forzar que el color de fondo definido inline tenga prioridad */
            background-color: var(--fc-event-bg-color, #3788d8) !important;
            border-color: var(--fc-event-border-color, #3788d8) !important;
        }
        .fc-event:hover { transform: scale(1.05); }

        .fc-toolbar-title { 
            font-size: 1.5rem !important; 
            font-weight: 800; 
            color: #1F2937; 
            letter-spacing: -0.025em;
        }
        .dark .fc-toolbar-title { color: white !important; }
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <!-- COMPONENTE PRINCIPAL CON ID ÚNICO -->
    <div id="calendar-state" x-data="{ 
        showCreatePanel: false, 
        showDetailPanel: false, 
        showDayInfoPanel: false, 
        showEmptyModal: false,   
        selectedColor: '#315762', 
        daySummary: { date: '', rawDate: '', events: [] },
        eventDetail: { id: null, title: '', start: '', description: '', type: '', icon: '', color: '' }
    }" @open-create-panel.window="showCreatePanel = true">
        
        <div class="w-full h-[calc(100vh-9rem)] px-4 pb-4 overflow-hidden flex flex-col">
            @if (session('status'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="absolute top-20 right-6 z-50 p-4 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center gap-3 shadow-lg animate-fade-in-down">
                    <span class="font-medium">{{ session('status') }}</span>
                </div>
            @endif

            <div class="flex-1 bg-white dark:bg-gray-800 shadow-xl rounded-3xl border border-gray-200 dark:border-gray-700 overflow-hidden relative">
                <div class="absolute inset-0 p-6">
                    <div id='calendar' class="h-full w-full"></div>
                </div>
            </div>
        </div>

        <!-- MODAL: DÍA VACÍO (BACKDROP CORREGIDO PARA MODO OSCURO) -->
        <div x-show="showEmptyModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="showEmptyModal = false">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center transform transition-all scale-100" @click.stop>
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Sin Actividades</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">No hay nada agendado para el <span x-text="daySummary.date" class="font-bold text-primary-600"></span>.</p>
                <div class="flex flex-col gap-3">
                    <button @click="showEmptyModal = false" class="w-full py-2.5 px-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl transition-colors">Entendido</button>
                    @can('is-admin')
                    <button @click="showEmptyModal = false; showCreatePanel = true; $nextTick(() => { document.querySelector('input[name=start_date]').value = daySummary.rawDate; document.querySelector('input[name=end_date]').value = daySummary.rawDate; })" class="w-full py-2.5 px-4 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors">+ Crear Evento Aquí</button>
                    @endcan
                </div>
            </div>
        </div>

        <!-- SLIDE-OVER: RESUMEN DEL DÍA (BACKDROP CORREGIDO) -->
        <div class="relative z-50" x-show="showDayInfoPanel" style="display: none;" x-cloak>
            <div x-show="showDayInfoPanel" class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="showDayInfoPanel = false"></div>
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="showDayInfoPanel" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md">
                            <div class="flex h-full flex-col bg-white dark:bg-gray-800 shadow-2xl">
                                <div class="bg-primary-600 px-6 py-8 relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-2xl"></div>
                                    <button @click="showDayInfoPanel = false" class="absolute top-4 right-4 text-primary-200 hover:text-white"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                                    <h2 class="text-3xl font-bold text-white mb-1" x-text="daySummary.date.split(',')[0]"></h2>
                                    <p class="text-primary-100 font-medium text-lg capitalize" x-text="daySummary.date.split(',')[1]"></p>
                                </div>
                                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Agenda del día</h3>
                                    
                                    <!-- AQUI ESTÁ EL CAMBIO PRINCIPAL PARA LOS COLORES -->
                                    <template x-for="event in daySummary.events" :key="event.id">
                                        <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border-l-[6px] shadow-sm hover:shadow-md transition-all cursor-default flex justify-between items-start group relative overflow-hidden" 
                                             :style="'border-left-color: ' + event.backgroundColor">
                                            
                                            <!-- Fondo sutil del color del evento -->
                                            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" :style="'background-color: ' + event.backgroundColor"></div>

                                            <div class="flex-1 relative z-10">
                                                <div class="flex justify-between items-start mb-2">
                                                    <!-- ETIQUETA CON EL COLOR DEL EVENTO -->
                                                    <span class="text-[10px] font-black px-2 py-1 rounded shadow-sm text-white uppercase tracking-wide" 
                                                          :style="'background-color: ' + event.backgroundColor"
                                                          x-text="event.extendedProps.type">
                                                    </span>
                                                </div>
                                                <h4 class="font-bold text-gray-900 dark:text-white text-lg leading-tight" x-text="event.title"></h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-300 mt-2 line-clamp-2" x-text="event.extendedProps.description || 'Sin detalles adicionales'"></p>
                                            </div>
                                            
                                            @can('is-admin')
                                            <template x-if="!event.extendedProps.is_vacation">
                                                <form :action="'/calendar/' + event.extendedProps.real_id_formatted" method="POST" class="ml-2 opacity-0 group-hover:opacity-100 transition-opacity relative z-10">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('¿Eliminar este evento?')" title="Eliminar">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </template>
                                            @endcan
                                        </div>
                                    </template>
                                </div>
                                @can('is-admin')
                                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                                    <button @click="showDayInfoPanel = false; showCreatePanel = true; $nextTick(() => { document.querySelector('input[name=start_date]').value = daySummary.rawDate; })" class="w-full flex justify-center items-center gap-2 py-3 px-4 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Añadir otro evento hoy
                                    </button>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE-OVER: CREAR EVENTO (BACKDROP CORREGIDO) -->
        <div class="relative z-50" x-show="showCreatePanel" style="display: none;" x-cloak>
            <div x-show="showCreatePanel" class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="showCreatePanel" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md" @click.away="showCreatePanel = false">
                            <div class="flex h-full flex-col overflow-y-scroll bg-white dark:bg-gray-800 shadow-2xl no-scrollbar">
                                <div class="bg-primary-600 px-4 py-6 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <h2 class="text-xl font-bold text-white">Nuevo Evento</h2>
                                        <button type="button" @click="showCreatePanel = false" class="text-primary-100 hover:text-white"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                                    </div>
                                    <p class="mt-1 text-sm text-primary-100">Agendar feriado, entrega o noticia.</p>
                                </div>
                                <div class="relative flex-1 px-4 py-6 sm:px-6">
                                    <form action="{{ route('calendar.store') }}" method="POST" class="space-y-6">
                                        @csrf
                                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Título</label><input type="text" name="title" class="mt-1 block w-full rounded-xl border-gray-300 py-3 pl-3 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></div>
                                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Categoría</label><select name="type" class="mt-1 block w-full rounded-xl border-gray-300 py-3 pl-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"><option value="general">Reunión General</option><option value="feriado">Día Feriado</option><option value="entrega">Entrega / Deadline</option><option value="noticia">Noticia</option></select></div>
                                        <div class="grid grid-cols-2 gap-4"><div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Inicio</label><input type="date" name="start_date" class="mt-1 block w-full rounded-xl border-gray-300 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></div><div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Fin</label><input type="date" name="end_date" class="mt-1 block w-full rounded-xl border-gray-300 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></div></div>
                                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Destinatario</label><select name="department_id" class="mt-1 block w-full rounded-xl border-gray-300 py-3 pl-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"><option value="">Global</option><optgroup label="Departamentos">@foreach($departments as $dept)<option value="{{ $dept->id }}">{{ $dept->name }}</option>@endforeach</optgroup></select></div>
                                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Color</label><input type="hidden" name="color" x-model="selectedColor"><div class="flex flex-wrap gap-3"><template x-for="color in ['#315762', '#438591', '#F59E0B', '#EF4444', '#10B981', '#6366F1', '#EC4899', '#8B5CF6']"><button type="button" @click="selectedColor = color" :class="{'ring-2 ring-offset-2 ring-gray-400 scale-110': selectedColor === color}" class="w-8 h-8 rounded-full shadow-sm border border-black/10" :style="'background-color: ' + color"></button></template></div></div>
                                        <div><label class="block text-sm font-bold text-gray-700 dark:text-gray-300">Descripción</label><textarea name="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea></div>
                                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700"><button type="button" @click="showCreatePanel = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-bold text-gray-700 hover:bg-gray-50">Cancelar</button><button type="submit" class="rounded-xl bg-primary-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-primary-700">Guardar</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE-OVER: DETALLE EVENTO (BACKDROP CORREGIDO) -->
        <div class="relative z-50" x-show="showDetailPanel" style="display: none;" x-cloak>
            <div x-show="showDetailPanel" class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity" @click="showDetailPanel = false"></div>
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="showDetailPanel" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md">
                            <div class="flex h-full flex-col overflow-y-scroll bg-white dark:bg-gray-800 shadow-2xl relative">
                                <div class="h-32 w-full absolute top-0 left-0 z-0" :style="'background-color: ' + (eventDetail.color || '#315762')"></div>
                                <div class="h-32 w-full absolute top-0 left-0 z-0 bg-gradient-to-b from-transparent to-black/40"></div>
                                <button @click="showDetailPanel = false" class="absolute top-4 right-4 z-10 bg-white/20 hover:bg-white/40 text-white rounded-full p-1 backdrop-blur-md transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                <div class="relative z-10 px-6 mt-20">
                                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-6 border border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300" x-text="eventDetail.type"></span>
                                        </div>
                                        <h2 class="text-2xl font-black text-gray-900 dark:text-white leading-tight mb-2" x-text="eventDetail.title"></h2>
                                        <p class="text-sm font-bold text-primary-600 dark:text-primary-400 mb-6 uppercase tracking-wider" x-text="eventDetail.start"></p>
                                        <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 text-base leading-relaxed">
                                            <p x-text="eventDetail.description || 'Sin descripción detallada.'"></p>
                                        </div>
                                        @can('is-admin')
                                        <template x-if="!eventDetail.is_vacation">
                                            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                                                <form :action="'/calendar/' + eventDetail.id" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-red-50 transition-colors" onclick="return confirm('¿Eliminar?')"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Eliminar</button>
                                                </form>
                                            </div>
                                        </template>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var rawEvents = @json($events);
            var processedEvents = [];

            function parseLocal(dateStr) {
                if (!dateStr) return new Date();
                let cleanDate = dateStr.split('T')[0];
                const [year, month, day] = cleanDate.split('-').map(Number);
                return new Date(year, month - 1, day);
            }

            function handleDayClick(clickedDateStr) {
                let allEvents = calendar.getEvents();
                let dayEvents = allEvents.filter(e => e.startStr === clickedDateStr);

                let container = document.getElementById('calendar-state');
                let data = Alpine.$data(container);

                if (dayEvents.length > 0) {
                    let dateObj = parseLocal(clickedDateStr);
                    data.daySummary = {
                        date: dateObj.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }),
                        rawDate: clickedDateStr,
                        events: dayEvents.map(e => ({
                            id: e.id,
                            title: e.title,
                            // ASIGNAR COLOR CORRECTAMENTE AL PANEL DE DETALLES
                            backgroundColor: e.backgroundColor || e.extendedProps.backgroundColor || '#315762', 
                            extendedProps: e.extendedProps
                        }))
                    };
                    data.showDayInfoPanel = true;
                } else {
                    let dateObj = parseLocal(clickedDateStr);
                    data.daySummary.date = dateObj.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    data.daySummary.rawDate = clickedDateStr;
                    data.showEmptyModal = true;
                }
            }

            rawEvents.forEach(event => {
                let startStr = event.start.split('T')[0];
                let endStr = event.end ? event.end.split('T')[0] : startStr;
                
                let startDate = parseLocal(startStr);
                let endDate = parseLocal(endStr);
                
                // --- CORRECCIÓN DE COLOR: Obtener el color desde cualquier posible propiedad ---
                let eventColor = event.backgroundColor || event.color || event.borderColor || '#315762';

                if (startStr !== endStr) {
                    let loop = new Date(startDate);
                    while (loop <= endDate) {
                        let newEvent = JSON.parse(JSON.stringify(event)); 
                        let isoDate = loop.getFullYear() + '-' + String(loop.getMonth() + 1).padStart(2, '0') + '-' + String(loop.getDate()).padStart(2, '0');
                        newEvent.start = isoDate;
                        newEvent.end = isoDate; 
                        newEvent.extendedProps.real_id_formatted = event.id;
                        
                        // ASIGNAR EXPLÍCITAMENTE EL COLOR AL NUEVO OBJETO
                        newEvent.backgroundColor = eventColor;
                        newEvent.borderColor = eventColor;
                        newEvent.color = eventColor; // Redundancia para seguridad
                        
                        processedEvents.push(newEvent);
                        loop.setDate(loop.getDate() + 1);
                    }
                } else {
                    event.start = startStr; 
                    event.end = startStr;
                    event.extendedProps.real_id_formatted = event.id;
                    
                    // ASIGNAR EXPLÍCITAMENTE EL COLOR
                    event.backgroundColor = eventColor;
                    event.borderColor = eventColor;
                    event.color = eventColor;
                    
                    processedEvents.push(event);
                }
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                themeSystem: 'standard',
                height: '100%',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth listWeek'
                },
                buttonText: { today: 'Hoy', month: 'Mes', list: 'Agenda' },
                dayMaxEvents: true,
                events: processedEvents,

                // Inyectar el color directamente en el elemento HTML del evento
                eventDidMount: function(info) {
                    if (info.event.backgroundColor) {
                        info.el.style.backgroundColor = info.event.backgroundColor;
                        info.el.style.borderColor = info.event.backgroundColor;
                    }
                },

                dateClick: function(info) {
                    handleDayClick(info.dateStr);
                },

                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    let eventDateStr = info.event.startStr;
                    handleDayClick(eventDateStr);
                }
            });
            calendar.render();
        });
    </script>
</x-app-layout>