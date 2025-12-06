<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Recibos de Nómina') }}
        </h2>
        
        <style>
            .btn-anim { transition: all 250ms; }
            .btn-anim:hover, .btn-anim:focus { box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px; transform: translateY(-2px); }
            .btn-anim:active { box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px; transform: translateY(0); }

            .row-card { position: relative; transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; }
            .row-card:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: #ffffff; z-index: 10; }
            .dark .row-card:hover { background-color: #374151; }
        </style>
    </x-slot>

    <div class="">
        <div class="w-full">
            <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- TABLA DE RECIBOS -->
                    <div class="overflow-hidden rounded-2xl shadow-md border border-gray-200 dark:border-gray-700"> 
                        <table class="w-full text-left text-gray-500 dark:text-gray-400">
                            <!-- HEADER VERDE PETRÓLEO -->
                            <thead class="text-sm text-white uppercase font-bold tracking-wider bg-primary-600 dark:bg-primary-90">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Periodo</th>
                                    <th scope="col" class="px-6 py-4">Fecha Pago</th>
                                    <th scope="col" class="px-6 py-4 text-right">Monto Neto</th>
                                    <th scope="col" class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($payslips as $payslip)
                                    <!-- FILA CLICABLE: Toda la fila abre el modal -->
                                    <tr class="bg-white dark:bg-gray-800 row-card transition-colors cursor-pointer" 
                                        x-data="{ showDetailModal: false }"
                                        @click="showDetailModal = true">
                                        
                                        <!-- Columna: Periodo -->
                                        <td class="px-6 py-5 font-bold text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($payslip->pay_period_start)->format('d M') }} - {{ \Carbon\Carbon::parse($payslip->pay_period_end)->format('d M, Y') }}
                                        </td>

                                        <!-- Columna: Fecha Pago -->
                                        <td class="px-6 py-5 text-base text-gray-600 dark:text-gray-300">
                                            {{ $payslip->created_at->format('d/m/Y') }}
                                        </td>

                                        <!-- Columna: Monto -->
                                        <td class="px-6 py-5 text-right font-black text-emerald-600 dark:text-emerald-400 text-lg">
                                            ${{ number_format($payslip->net_pay, 2) }}
                                        </td>

                                        <!-- Columna: Acciones -->
                                        <td class="px-6 py-5 text-right">
                                            <div class="flex justify-end gap-2">
                                                <!-- Botón Ver Detalles (Icono Ojo) -->
                                                <button type="button" class="text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400 p-2 rounded-full hover:bg-blue-50 dark:hover:bg-gray-700 transition-all" title="Ver Detalles">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>

                                                <!-- Botón Descargar PDF (Directo) -->
                                                <!-- @click.stop evita que se abra el modal al descargar -->
                                                <a href="{{ route('payroll.download', $payslip->id) }}" target="_blank" @click.stop class="text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 p-2 rounded-full hover:bg-red-50 dark:hover:bg-gray-700 transition-all" title="Descargar PDF">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                </a>
                                            </div>
                                            
                                            <!-- MODAL DE DETALLE (Con Fade y Clic Fuera) -->
                                            <template x-teleport="body">
                                                <div x-show="showDetailModal" style="display: none;" x-cloak 
                                                     class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm p-4 md:inset-0 h-full" 
                                                     @click.stop="showDetailModal = false"
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0"
                                                     x-transition:enter-end="opacity-100"
                                                     x-transition:leave="transition ease-in duration-200"
                                                     x-transition:leave-start="opacity-100"
                                                     x-transition:leave-end="opacity-0">
                                                    
                                                    <div class="relative w-full max-w-md h-auto" @click.stop
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave="transition ease-in duration-200"
                                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                                        
                                                        <div class="relative bg-white rounded-2xl shadow-2xl dark:bg-gray-800 p-6 space-y-6 border border-gray-200 dark:border-gray-700">
                                                            <div class="text-center border-b border-gray-100 dark:border-gray-700 pb-4">
                                                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Resumen de Pago</h3>
                                                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($payslip->pay_period_start)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payslip->pay_period_end)->format('d/m/Y') }}</p>
                                                            </div>

                                                            <div class="space-y-3 text-sm">
                                                                <div class="flex justify-between"><span class="text-gray-500 font-medium">Salario Base</span><span class="font-bold text-gray-900 dark:text-white">${{ number_format($payslip->base_salary, 2) }}</span></div>
                                                                <div class="flex justify-between"><span class="text-gray-500 font-medium">Horas Trabajadas</span><span class="font-bold text-gray-900 dark:text-white">{{ $payslip->total_hours }}</span></div>
                                                                <div class="flex justify-between text-emerald-600"><span class="font-medium">Bonificaciones</span><span class="font-bold">+ ${{ number_format($payslip->bonuses, 2) }}</span></div>
                                                                <div class="flex justify-between text-red-500"><span class="font-medium">Deducciones</span><span class="font-bold">- ${{ number_format($payslip->deductions, 2) }}</span></div>
                                                                <div class="flex justify-between pt-4 border-t border-gray-100 dark:border-gray-700 text-lg font-black text-gray-900 dark:text-white"><span>Neto a Pagar</span><span>${{ number_format($payslip->net_pay, 2) }}</span></div>
                                                            </div>

                                                            @if($payslip->notes) 
                                                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl text-sm text-blue-800 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                                                    <strong>Nota:</strong> {{ $payslip->notes }}
                                                                </div> 
                                                            @endif
                                                            
                                                            <div class="flex flex-col gap-3 mt-4">
                                                                <button @click="showDetailModal = false" class="w-full bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-bold py-3 px-4 rounded-xl transition-colors">Cerrar</button>
                                                                
                                                                <a href="{{ route('payroll.download', $payslip->id) }}" target="_blank" class="w-full flex justify-center items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition-colors transform hover:scale-[1.02]">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                                    Descargar PDF Oficial
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-lg font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800">
                                            No se encontraron recibos de nómina.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $payslips->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>