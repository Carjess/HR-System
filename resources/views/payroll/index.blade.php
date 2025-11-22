<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Centro de Nómina') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensajes de Estado -->
            @if (session('status'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                    <span class="font-medium">¡Éxito!</span> {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                    <span class="font-medium">Atención:</span> {{ session('error') }}
                </div>
            @endif

            <!-- 1. TARJETA DE GENERACIÓN -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <!-- Columna Izquierda: Formulario -->
                        <div class="md:col-span-2">
                            <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Pago de Nómina
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm">
                                Selecciona el grupo y el período. Puedes filtrar por departamento y cargo específico.
                            </p>

                            <form method="POST" action="{{ route('payroll.generate') }}" class="space-y-5">
                                @csrf
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <!-- Departamento -->
                                    <div>
                                        <label for="department_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departamento</label>
                                        <!-- Añadimos el ID para el script -->
                                        <select name="department_id" id="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option value="">-- Todos --</option>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Cargo (Dinámico) -->
                                    <div>
                                        <label for="position_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo (Opcional)</label>
                                        <!-- Este select se llena con JS -->
                                        <select name="position_id" id="position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                                            <option value="">-- Selecciona Dept primero --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-5">
                                    <!-- Mes -->
                                    <div>
                                        <label for="month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mes</label>
                                        <select name="month" id="month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <!-- Año -->
                                    <div>
                                        <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Año</label>
                                        <select name="year" id="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            @for ($i = date('Y'); $i >= date('Y') - 2; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <!-- NUEVO CAMPO: NOTA/MENSAJE -->
                                <div>
                                    <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nota / Mensaje para el Recibo (Opcional)</label>
                                    <textarea name="notes" id="notes" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej. Bono trimestral incluido..."></textarea>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full md:w-auto text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-3 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 transition-colors flex items-center justify-center gap-2" onclick="return confirm('¿Estás seguro de procesar estos pagos? Esta acción es definitiva.')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Procesar Pagos
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Columna Derecha: Información -->
                        <div class="md:col-span-1 border-l border-gray-200 dark:border-gray-700 pl-0 md:pl-8 mt-6 md:mt-0">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm uppercase tracking-wide">Protocolo de Pago:</h4>
                            <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Verifica que los <strong>contratos</strong> estén activos.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Las <strong>horas extra</strong> se calculan automáticamente.</span>
                                </li>
                            </ul>
                            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-900/50">
                                <p class="text-xs text-blue-800 dark:text-blue-200 flex gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>El sistema impedirá duplicados para el mismo grupo en el mismo mes.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. HISTORIAL DE NÓMINAS -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-6">Historial de Lotes de Pago</h3>
                    <div class="flow-root">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($payrollHistory as $history)
                                <div x-data="{ showDetailModal: false }" class="flex flex-wrap items-center gap-y-4 py-6">
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1 flex items-start gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <dt class="sr-only">Periodo</dt>
                                            <dd class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($history->pay_period_start)->translatedFormat('F Y') }}
                                            </dd>
                                            <dd class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                {{ \Carbon\Carbon::parse($history->pay_period_start)->format('d/m') }} - {{ \Carbon\Carbon::parse($history->pay_period_end)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleados</dt>
                                        <dd class="mt-1.5"><span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ $history->total_employees }}</span></dd>
                                    </dl>
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Neto</dt>
                                        <dd class="mt-1.5 text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($history->total_amount, 2) }}</dd>
                                    </dl>
                                    
                                    <!-- Botón Ver Detalles -->
                                    <div class="w-1/2 sm:w-auto flex items-center justify-end gap-2">
                                        <button @click="showDetailModal = true" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 font-bold text-sm">
                                            Ver Detalles
                                        </button>
                                    </div>

                                    <!-- MODAL DE DETALLES -->
                                    <div x-show="showDetailModal" style="display: none;" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full">
                                        <div class="relative w-full max-w-lg h-auto" @click.away="showDetailModal = false">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-6 space-y-4">
                                                <div class="flex justify-between items-start">
                                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Resumen de Nómina</h3>
                                                    <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-900"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                                                </div>
                                                
                                                <div class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                                    <div><p class="text-sm text-gray-500">Periodo</p><p class="font-semibold dark:text-white">{{ \Carbon\Carbon::parse($history->pay_period_start)->translatedFormat('F Y') }}</p></div>
                                                    <div><p class="text-sm text-gray-500">Empleados Pagados</p><p class="font-semibold dark:text-white">{{ $history->total_employees }}</p></div>
                                                    <div class="col-span-2"><p class="text-sm text-gray-500">Monto Total Dispersado</p><p class="text-2xl font-bold text-green-600">${{ number_format($history->total_amount, 2) }}</p></div>
                                                </div>

                                                <div>
                                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Nota / Mensaje del Admin</p>
                                                    <div class="p-4 border rounded-lg bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-gray-900 dark:text-white text-sm leading-relaxed break-words">
                                                        {{ $history->notes ?? 'Sin notas adicionales para este lote de pago.' }}
                                                    </div>
                                                </div>

                                                <div class="flex justify-end pt-2">
                                                    <button @click="showDetailModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-10 text-center text-gray-500 dark:text-gray-400">No hay historial aún.</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="mt-6">{{ $payrollHistory->links() }}</div>
                </div>
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
                    .catch(error => {
                        positionSelect.innerHTML = '<option value="">Error al cargar</option>';
                    });
            } else {
                positionSelect.innerHTML = '<option value="">-- Selecciona Dept primero --</option>';
                positionSelect.disabled = true;
            }
        });
    </script>
</x-app-layout>