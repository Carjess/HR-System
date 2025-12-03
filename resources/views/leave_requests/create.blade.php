<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Solicitar Ausencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                <!-- Cabecera de la Tarjeta -->
                <div class="p-6 bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Nueva Solicitud</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Registra tus vacaciones, permisos o reposos médicos.</p>
                    </div>
                    <!-- Icono Decorativo -->
                    <div class="p-3 bg-primary-50 dark:bg-primary-900/20 rounded-xl text-primary-600 dark:text-primary-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>

                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('ausencias.store', $empleado->id) }}">
                        @csrf 

                        <!-- SECCIÓN: Fechas -->
                        <div class="mb-8">
                            <h4 class="text-base font-bold text-primary-600 dark:text-primary-400 mb-6 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Duración
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Fecha Inicio -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Desde</label>
                                    <input type="date" name="start_date" 
                                           class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500"
                                           value="{{ old('start_date') }}"
                                           required>
                                    @error('start_date') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                                </div>

                                <!-- Fecha Fin -->
                                <div class="group">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Hasta</label>
                                    <input type="date" name="end_date" 
                                           class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500"
                                           value="{{ old('end_date') }}"
                                           required>
                                    @error('end_date') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-700 my-8"></div>

                        <!-- SECCIÓN: Detalles -->
                        <div class="mb-8">
                            <h4 class="text-base font-bold text-primary-600 dark:text-primary-400 mb-6 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Detalles
                            </h4>

                            <!-- Motivo -->
                            <div class="group">
                                <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-primary-600 transition-colors">Motivo <span class="text-gray-400 font-normal text-xs ml-1">(Opcional)</span></label>
                                <textarea name="reason" rows="4" 
                                          class="block w-full p-3.5 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-900 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 ease-in-out hover:border-primary-300 hover:shadow-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 resize-none"
                                          placeholder="Ej: Vacaciones familiares, Cita médica, Trámites personales...">{{ old('reason') }}</textarea>
                                @error('reason') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Footer Botones -->
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('ausencias.index') }}" class="px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all duration-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 flex items-center">
                                Cancelar
                            </a>
                            <button type="submit" class="px-8 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 shadow-lg shadow-primary-500/30 transform hover:scale-105 transition-all duration-200 dark:bg-primary-600 dark:hover:bg-primary-700">
                                Enviar Solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>