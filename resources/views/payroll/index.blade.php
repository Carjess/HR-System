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
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
                    <span class="font-medium">¡Éxito!</span> {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800" role="alert">
                    <span class="font-medium">Atención:</span> {{ session('error') }}
                </div>
            @endif

            <!-- 1. TARJETA DE GENERACIÓN (Diseño Mejorado) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <!-- Columna Izquierda: Formulario -->
                        <div class="md:col-span-2">
                            <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Generar Nueva Nómina
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm">
                                Selecciona el período para procesar los pagos. Esto calculará automáticamente los salarios base y las horas registradas de todos los empleados activos.
                            </p>

                            <form method="POST" action="{{ route('payroll.generate') }}" class="space-y-5">
                                @csrf
                                <div class="grid grid-cols-2 gap-5">
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
                                    <div>
                                        <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Año</label>
                                        <select name="year" id="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                            @for ($i = date('Y'); $i >= date('Y') - 2; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full md:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors flex items-center justify-center gap-2" onclick="return confirm('¿Estás seguro? Esto generará (o regenerará) la nómina para todos los empleados en este período.')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Procesar Nómina
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Columna Derecha: Información / Checklist -->
                        <div class="md:col-span-1 border-l border-gray-200 dark:border-gray-700 pl-0 md:pl-8 mt-6 md:mt-0">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm uppercase tracking-wide">Antes de procesar:</h4>
                            <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Verifica que todos los <strong>nuevos empleados</strong> tengan contrato.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Asegúrate de que las <strong>horas extra</strong> estén registradas.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Revisa las <strong>ausencias</strong> aprobadas del mes.</span>
                                </li>
                            </ul>
                            
                            <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-100 dark:border-yellow-900/50">
                                <p class="text-xs text-yellow-800 dark:text-yellow-200 flex gap-2">
                                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Si vuelves a generar un mes existente, los datos anteriores se sobrescribirán.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. HISTORIAL DE NÓMINAS (Lista Moderna) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-6">Historial de Pagos</h3>

                    <div class="flow-root">
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($payrollHistory as $history)
                                <div class="flex flex-wrap items-center gap-y-4 py-6">
                                    
                                    <!-- Periodo (Icono + Texto) -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1 flex items-start gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300">
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

                                    <!-- Total Empleados -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleados Pagados</dt>
                                        <dd class="mt-1.5">
                                            <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                {{ $history->total_employees }}
                                            </span>
                                        </dd>
                                    </dl>

                                    <!-- Total Dinero -->
                                    <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Neto</dt>
                                        <dd class="mt-1.5 text-lg font-bold text-green-600 dark:text-green-400">
                                            ${{ number_format($history->total_amount, 2) }}
                                        </dd>
                                    </dl>

                                    <!-- Estado (Siempre "Generado" por ahora) -->
                                    <dl class="w-1/2 sm:w-auto lg:flex-none mr-6">
                                        <dt class="sr-only">Estado</dt>
                                        <dd class="mt-1.5">
                                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Completado
                                            </span>
                                        </dd>
                                    </dl>

                                    <!-- Acciones (Opcional, por ahora vacío o botón de ver) -->
                                    {{-- 
                                    <div class="w-full sm:w-auto flex items-center justify-end gap-2">
                                        <button class="text-gray-600 hover:text-blue-600 font-medium text-sm">Ver Detalle</button>
                                    </div> 
                                    --}}
                                </div>
                            @empty
                                <div class="py-10 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aún no hay historial</h3>
                                    <p class="mt-1 text-gray-500 dark:text-gray-400">Genera tu primera nómina usando el formulario de arriba.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-6">
                        {{ $payrollHistory->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>