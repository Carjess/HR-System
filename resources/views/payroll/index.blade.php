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
            <div class="p-4 mb-4 text-base text-green-800 rounded-xl bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800 shadow-sm">
                <span class="font-bold">¡Éxito!</span> {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-base text-red-800 rounded-xl bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800 shadow-sm">
                <span class="font-bold">Atención:</span> {{ session('error') }}
            </div>
        @endif

        <!-- 1. TARJETA DE GENERACIÓN (Diseño Limpio) -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-2xl border border-gray-200 dark:border-gray-700">
            <div class="p-8 text-gray-900 dark:text-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    
                    <!-- Columna Izquierda: Formulario -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg text-blue-600 dark:text-blue-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Pago de Nómina</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Procesa pagos masivos filtrando por grupo y período.</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('payroll.generate') }}" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Departamento -->
                                <div>
                                    <label for="department_id" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Departamento</label>
                                    <select name="department_id" id="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm transition-shadow hover:shadow-md">
                                        <option value="">-- Todos --</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Cargo (Dinámico) -->
                                <div>
                                    <label for="position_id" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Cargo (Opcional)</label>
                                    <select name="position_id" id="position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm transition-shadow hover:shadow-md" disabled>
                                        <option value="">-- Selecciona Dept primero --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <!-- Mes -->
                                <div>
                                    <label for="month" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Mes</label>
                                    <select name="month" id="month" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm transition-shadow hover:shadow-md" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <!-- Año -->
                                <div>
                                    <label for="year" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Año</label>
                                    <select name="year" id="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm transition-shadow hover:shadow-md" required>
                                        @for ($i = date('Y'); $i >= date('Y') - 2; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Nota -->
                            <div>
                                <label for="notes" class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nota / Mensaje (Opcional)</label>
                                <textarea name="notes" id="notes" rows="2" class="block p-3 w-full text-base text-gray-900 bg-gray-50 rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white shadow-sm transition-shadow hover:shadow-md" placeholder="Ej. Bono trimestral incluido..."></textarea>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="btn-anim w-full md:w-auto text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-bold rounded-xl text-lg px-8 py-3.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800 flex items-center justify-center gap-3 shadow-lg" onclick="return confirm('¿Estás seguro de procesar estos pagos? Esta acción es definitiva.')">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Procesar Pagos
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Columna Derecha: Información / Checklist -->
                    <div class="lg:col-span-1 border-l border-gray-200 dark:border-gray-700 pl-0 lg:pl-10 mt-8 lg:mt-0 flex flex-col justify-center">
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-2xl p-6 border border-gray-100 dark:border-gray-600">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-4 text-lg uppercase tracking-wide flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                Protocolo de Pago
                            </h4>
                            <ul class="space-y-4 text-base text-gray-600 dark:text-gray-300">
                                <li class="flex items-start gap-3">
                                    <div class="mt-1 rounded-full bg-green-100 p-1 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Verifica que los <strong>contratos</strong> de nuevos ingresos estén activos.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-1 rounded-full bg-green-100 p-1 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Las <strong>horas extra</strong> registradas se calculan automáticamente.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-1 rounded-full bg-green-100 p-1 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span>Revisa y aprueba las <strong>ausencias</strong> pendientes.</span>
                                </li>
                            </ul>
                            
                            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                                <p class="text-sm text-blue-800 dark:text-blue-300 flex gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>El sistema impedirá automáticamente pagos duplicados para el mismo grupo y mes.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. HISTORIAL DE NÓMINAS (Lista Fluida) -->
        <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
            <div class="py-6">
                <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 px-2">Historial de Lotes de Pago</h3>

                <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700">
                    <table class="w-full text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-sm text-gray-700 uppercase font-bold tracking-wider bg-gray-100 dark:bg-gray-700/50">
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
                                <tr class="bg-white dark:bg-gray-800 row-card transition-colors" x-data="{ showDetailModal: false }">
                                    
                                    <!-- Periodo -->
                                    <td class="px-6 py-6 pl-8 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-lg font-bold text-gray-900 dark:text-white block leading-tight">
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
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                            {{ $history->total_employees }} Pagados
                                        </span>
                                    </td>

                                    <!-- Total -->
                                    <td class="px-6 py-6">
                                        <div class="text-xl font-bold text-green-600 dark:text-green-400">
                                            ${{ number_format($history->total_amount, 2) }}
                                        </div>
                                    </td>

                                    <!-- Estado -->
                                    <td class="px-6 py-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-50 text-green-700 border border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            Completado
                                        </span>
                                    </td>
                                    
                                    <!-- Botón Detalles -->
                                    <td class="px-6 py-6 text-right pr-8">
                                        <button @click="showDetailModal = true" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 hover:underline font-bold text-sm transition-colors">
                                            Ver Resumen
                                        </button>

                                        <!-- MODAL DETALLE (Teleport) -->
                                        <template x-teleport="body">
                                            <div x-show="showDetailModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full text-left">
                                                <div class="relative w-full max-w-lg h-auto" @click.away="showDetailModal = false">
                                                    <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                                        
                                                        <div class="flex justify-between p-6 border-b rounded-t-2xl dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Resumen de Nómina</h3>
                                                            <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-900 dark:hover:text-white p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="p-8 space-y-6">
                                                            <div class="grid grid-cols-2 gap-6 bg-gray-50 dark:bg-gray-700/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Periodo</p>
                                                                    <p class="text-lg font-bold dark:text-white">{{ \Carbon\Carbon::parse($history->pay_period_start)->translatedFormat('F Y') }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleados</p>
                                                                    <p class="text-lg font-bold dark:text-white">{{ $history->total_employees }}</p>
                                                                </div>
                                                                <div class="col-span-2 pt-4 border-t border-gray-200 dark:border-gray-600">
                                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Dispersado</p>
                                                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">${{ number_format($history->total_amount, 2) }}</p>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <p class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">Nota / Mensaje del Admin</p>
                                                                <div class="p-5 border rounded-xl bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800 text-gray-800 dark:text-blue-100 text-base leading-relaxed break-words">
                                                                    {{ $history->notes ?? 'Sin notas adicionales para este lote de pago.' }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end p-6 pt-0">
                                                            <button @click="showDetailModal = false" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-xl transition-colors dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 w-full sm:w-auto">Cerrar Resumen</button>
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