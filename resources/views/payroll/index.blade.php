<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Centro de Nómina') }}
        </h2>
        
        <style>
            /* Animaciones reutilizables */
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }

            .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #f9fafb; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }

            /* Ocultar X del input search si hubiera */
            input[type="search"]::-webkit-search-decoration,
            input[type="search"]::-webkit-search-cancel-button,
            input[type="search"]::-webkit-search-results-button,
            input[type="search"]::-webkit-search-results-decoration { display: none; }
        </style>
    </x-slot>

    <div class="w-full space-y-8">
            
        <!-- Mensajes de Estado -->
        @if (session('status'))
            <div class="p-4 mb-4 text-base text-green-800 rounded-xl bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800 shadow-sm flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div><span class="font-bold">¡Éxito!</span> {{ session('status') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-base text-red-800 rounded-xl bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800 shadow-sm flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div><span class="font-bold">Atención:</span> {{ session('error') }}</div>
            </div>
        @endif

        <!-- 1. PANEL DE CONTROL DE NÓMINA (DISEÑO HORIZONTAL) -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700">
            
            <!-- Cabecera Visual -->
            <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-primary-600 text-white rounded-xl shadow-lg shadow-primary-500/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Generador de Pagos</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Configura y dispersa la nómina masiva en 3 pasos.</p>
                    </div>
                </div>
                <!-- Decoración sutil -->
                <div class="hidden md:block text-gray-200 dark:text-gray-700">
                    <svg class="w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
                </div>
            </div>

            <!-- Formulario de 3 Columnas -->
            <form method="POST" action="{{ route('payroll.generate') }}" class="p-8">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                    
                    <!-- COLUMNA 1: SELECCIÓN DE PERSONAL -->
                    <div class="space-y-5 relative">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 text-primary-700 font-bold text-xs">1</span>
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Filtro de Personal</h4>
                        </div>
                        
                        <!-- Departamento -->
                        <div>
                            <label for="department_id" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">Departamento</label>
                            <div class="relative">
                                <select name="department_id" id="department_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3.5 pl-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm cursor-pointer hover:border-primary-300 transition-colors">
                                    <option value="">-- Todos los Departamentos --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Cargo -->
                        <div>
                            <label for="position_id" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">Cargo <span class="font-normal text-gray-400 text-xs">(Opcional)</span></label>
                            <select name="position_id" id="position_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3.5 pl-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm cursor-pointer hover:border-primary-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <option value="">-- Selecciona Dept primero --</option>
                            </select>
                        </div>

                        <!-- Separador Vertical (Solo Desktop) -->
                        <div class="hidden lg:block absolute right-[-1.5rem] top-4 bottom-4 w-px bg-gray-100 dark:bg-gray-700"></div>
                    </div>

                    <!-- COLUMNA 2: PERIODO -->
                    <div class="space-y-5 relative">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 text-primary-700 font-bold text-xs">2</span>
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Periodo de Pago</h4>
                        </div>

                        <!-- Mes -->
                        <div>
                            <label for="month" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">Mes</label>
                            <select name="month" id="month" class="bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3.5 pl-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm cursor-pointer hover:border-primary-300 transition-colors" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Año -->
                        <div>
                            <label for="year" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">Año</label>
                            <select name="year" id="year" class="bg-gray-50 border border-gray-200 text-gray-900 text-base rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3.5 pl-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm cursor-pointer hover:border-primary-300 transition-colors" required>
                                @for ($i = date('Y'); $i >= date('Y') - 2; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Separador Vertical (Solo Desktop) -->
                        <div class="hidden lg:block absolute right-[-1.5rem] top-4 bottom-4 w-px bg-gray-100 dark:bg-gray-700"></div>
                    </div>

                    <!-- COLUMNA 3: CONFIRMACIÓN -->
                    <div class="space-y-5 flex flex-col">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 text-primary-700 font-bold text-xs">3</span>
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Detalles</h4>
                        </div>

                        <!-- Nota -->
                        <div class="flex-grow">
                            <label for="notes" class="block mb-2 text-sm font-bold text-gray-700 dark:text-gray-300">Nota Interna <span class="font-normal text-gray-400 text-xs">(Opcional)</span></label>
                            <textarea name="notes" id="notes" rows="4" class="block p-3.5 w-full text-base text-gray-900 bg-gray-50 rounded-xl border border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm hover:border-primary-300 transition-colors resize-none h-[132px]" placeholder="Ej. Bono trimestral incluido..."></textarea>
                        </div>

                        <!-- Botón Acción -->
                        <button type="submit" class="btn-anim w-full text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 font-bold rounded-xl text-lg px-6 py-4 dark:bg-emerald-600 dark:hover:bg-emerald-700 focus:outline-none dark:focus:ring-emerald-800 flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 mt-auto" onclick="return confirm('¿Estás seguro de procesar estos pagos? Esta acción es definitiva.')">
                            <span>Procesar Nómina</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <!-- 2. HISTORIAL DE NÓMINAS -->
        <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
            <div class="py-6">
                <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 px-2 border-l-4 border-primary-500 pl-4">Historial de Pagos</h3>

                <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700">
                    <table class="w-full text-left text-gray-500 dark:text-gray-400">
                        <!-- Header Verde Petróleo -->
                        <thead class="text-sm text-white uppercase font-bold tracking-wider bg-primary-600 dark:bg-primary-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 pl-8">Periodo</th>
                                <th scope="col" class="px-6 py-4">Empleados</th>
                                <th scope="col" class="px-6 py-4">Total Neto</th>
                                <th scope="col" class="px-6 py-4">Estado</th>
                                <th scope="col" class="px-6 py-4 text-right pr-8">Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($payrollHistory as $history)
                                <!-- 
                                    CAMBIO IMPORTANTE: @click="showDetailModal = true" AÑADIDO AL TR
                                    Esto hace que toda la fila sea clicable.
                                -->
                                <tr class="bg-white dark:bg-gray-800 row-card transition-colors" 
                                    x-data="{ showDetailModal: false }" 
                                    @click="showDetailModal = true">
                                    
                                    <!-- Periodo -->
                                    <td class="px-6 py-6 pl-8 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-300 border border-primary-100 dark:border-primary-800">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-lg font-bold text-gray-900 dark:text-white block leading-tight capitalize">
                                                    {{ \Carbon\Carbon::parse($history->pay_period_start)->translatedFormat('F Y') }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($history->pay_period_start)->format('d/m') }} - {{ \Carbon\Carbon::parse($history->pay_period_end)->format('d/m/Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Empleados -->
                                    <td class="px-6 py-6">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                            {{ $history->total_employees }} Pagados
                                        </span>
                                    </td>

                                    <!-- Total -->
                                    <td class="px-6 py-6">
                                        <div class="text-xl font-bold text-emerald-600 dark:text-emerald-400">
                                            ${{ number_format($history->total_amount, 2) }}
                                        </div>
                                    </td>

                                    <!-- Estado -->
                                    <td class="px-6 py-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800 shadow-sm">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            Completado
                                        </span>
                                    </td>
                                    
                                    <!-- Botón Detalles -->
                                    <td class="px-6 py-6 text-right pr-8">
                                        <!-- El botón también funciona, pero ahora el click en TR también sirve -->
                                        <button @click.stop="showDetailModal = true" class="text-gray-400 hover:text-primary-600 dark:text-gray-500 dark:hover:text-primary-400 p-2 rounded-full hover:bg-white dark:hover:bg-gray-700 transition-all" title="Ver Resumen">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </button>

                                        <!-- MODAL DETALLE (CON EFECTO PREMIUM) -->
                                        <template x-teleport="body">
                                            <div x-show="showDetailModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full text-left transition-opacity duration-300">
                                                
                                                <div class="relative w-full max-w-lg h-auto" @click.away="showDetailModal = false">
                                                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden">
                                                        
                                                        <!-- Cabecera Modal -->
                                                        <div class="flex justify-between items-center p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-900/80">
                                                            <div>
                                                                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                                    <span class="p-1.5 bg-primary-100 text-primary-700 rounded-lg dark:bg-primary-900 dark:text-primary-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></span>
                                                                    Resumen de Nómina
                                                                </h3>
                                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Detalles del lote procesado.</p>
                                                            </div>
                                                            <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="p-8 space-y-6">
                                                            <!-- TARJETA BLANCA -->
                                                            <div class="grid grid-cols-2 gap-6 bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all duration-200 hover:shadow-md hover:border-primary-300 cursor-default group">
                                                                
                                                                <!-- Periodo -->
                                                                <div>
                                                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 group-hover:text-primary-600 transition-colors">Periodo</p>
                                                                    <p class="text-lg font-bold text-gray-900 dark:text-white capitalize">{{ \Carbon\Carbon::parse($history->pay_period_start)->translatedFormat('F Y') }}</p>
                                                                    <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($history->pay_period_start)->format('d/m') }} - {{ \Carbon\Carbon::parse($history->pay_period_end)->format('d/m') }}</p>
                                                                </div>
                                                                
                                                                <!-- Empleados -->
                                                                <div>
                                                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 group-hover:text-primary-600 transition-colors">Empleados</p>
                                                                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $history->total_employees }}</p>
                                                                    <p class="text-xs text-gray-400 mt-0.5">Pagados</p>
                                                                </div>
                                                                
                                                                <!-- Total (Linea divisoria) -->
                                                                <div class="col-span-2 pt-4 border-t border-gray-100 dark:border-gray-600 mt-1">
                                                                    <p class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Dispersado</p>
                                                                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($history->total_amount, 2) }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Notas -->
                                                            <div>
                                                                <p class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide flex items-center gap-2">
                                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                                                    Nota / Mensaje
                                                                </p>
                                                                <div class="p-5 border rounded-xl bg-gray-50 dark:bg-gray-700/30 border-gray-100 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-base leading-relaxed break-words shadow-sm transition-colors hover:border-gray-300">
                                                                    {{ $history->notes ?? 'Sin notas adicionales.' }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Footer -->
                                                        <div class="flex justify-end p-6 pt-0">
                                                            <button @click="showDetailModal = false" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shadow-sm w-full sm:w-auto dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                                                Cerrar Resumen
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-xl font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">No hay historial de pagos aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-10">{{ $payrollHistory->links() }}</div>
            </div>
        </div>
    </div>

    <!-- Script para Selects Dinámicos (Cargos) -->
    <script>
        document.getElementById('department_id').addEventListener('change', function() {
            var departmentId = this.value;
            var positionSelect = document.getElementById('position_id');
            positionSelect.innerHTML = '<option value="">Cargando...</option>';
            positionSelect.disabled = true;

            if (departmentId) {
                fetch('/api/departamentos/' + departmentId + '/cargos')
                    .then(response => response.json())
                    .then(data => {
                        positionSelect.innerHTML = '<option value="">-- Todos los Cargos --</option>';
                        if(data.length > 0){
                            data.forEach(position => {
                                var option = document.createElement('option');
                                option.value = position.id;
                                option.text = position.name;
                                positionSelect.appendChild(option);
                            });
                            positionSelect.disabled = false;
                        } else {
                            positionSelect.innerHTML = '<option value="">No hay cargos</option>';
                        }
                    })
                    .catch(error => { positionSelect.innerHTML = '<option value="">Error</option>'; });
            } else {
                positionSelect.innerHTML = '<option value="">-- Selecciona Dept primero --</option>';
                positionSelect.disabled = true;
            }
        });
    </script>
</x-app-layout>