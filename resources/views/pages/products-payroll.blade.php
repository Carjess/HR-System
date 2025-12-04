@extends('layouts.public')

@section('content')

<!-- Estilos Scroll Reveal -->
<style>
    .reveal {
        opacity: 0;
        transform: translateY(50px);
        transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    .delay-100 { transition-delay: 0.1s; }
    .delay-200 { transition-delay: 0.2s; }
    .delay-300 { transition-delay: 0.3s; }
</style>

<main class="relative isolate overflow-hidden bg-indigo-950">

    <!-- 1. HERO GIGANTE CON "AROS DE LUZ" (POLYGON) - TEMA ÍNDIGO -->
    <div class="relative isolate pt-14 pb-48 sm:pb-64 lg:pb-80 overflow-hidden">
        
        <!-- Fondo base oscuro -->
        <div class="absolute inset-0 -z-20 bg-gray-900"></div>

        <!-- Aros de Luz / Degradado Poligonal (Tema Índigo/Púrpura) -->
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-indigo-500 to-purple-400 opacity-40 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        
        <!-- Segunda capa de luz inferior -->
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-purple-500 to-indigo-500 opacity-40 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>

        <!-- Contenido Héroe -->
        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                
                <!-- Texto (Izquierda) -->
                <div class="lg:w-1/2 text-center lg:text-left reveal">
                    <div class="inline-flex items-center rounded-full px-6 py-2 text-sm font-bold text-indigo-300 ring-1 ring-inset ring-indigo-400/30 bg-indigo-400/10 mb-8">
                        Precisión Financiera 💸
                    </div>
                    <h1 class="text-6xl font-black tracking-tight text-white sm:text-8xl mb-10 leading-[1.1]">
                        Nómina,<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-300">Automatizada.</span>
                    </h1>
                    <p class="mt-8 text-xl leading-8 text-indigo-100">
                        Transforma días de cálculo manual en segundos. Integra contratos, horas y deducciones para generar pagos exactos al instante y sin errores humanos.
                    </p>
                    <div class="mt-12 flex items-center justify-center lg:justify-start gap-x-8">
                        <a href="{{ route('login') }}" class="rounded-2xl bg-indigo-600 px-10 py-5 text-xl font-bold text-white shadow-xl shadow-indigo-500/30 hover:bg-indigo-500 hover:scale-105 transition-all duration-300">
                            Probar Motor
                        </a>
                    </div>
                </div>

                <!-- Imagen (Derecha) -->
                <div class="lg:w-1/2 relative reveal delay-200 w-full">
                    <div class="relative rounded-3xl bg-gradient-to-br from-white/10 to-white/5 p-3 ring-1 ring-white/20 backdrop-blur-sm transform hover:-rotate-1 transition-transform duration-700">
                        <div class="rounded-2xl overflow-hidden shadow-2xl aspect-[16/10] bg-slate-900 relative">
                            <img src="{{ asset('img/payroll-1.png') }}" alt="Dashboard de Nómina" class="w-full h-full object-cover" 
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex flex-col items-center justify-center text-indigo-400 bg-slate-900\'><svg class=\'w-32 h-32 mb-6 opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg><span class=\'text-2xl font-bold\'>Sube tu captura: payroll-1.png</span></div>'">
                            
                            <!-- Tarjeta Flotante Decorativa (Grande) -->
                            <div class="absolute -bottom-8 -right-8 bg-white rounded-2xl p-6 shadow-2xl border border-gray-100 hidden lg:block animate-bounce duration-[4000ms]">
                                <div class="flex items-center gap-4">
                                    <div class="h-14 w-14 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Estado</p>
                                        <p class="text-xl font-black text-gray-900">Pago Exitoso</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CARACTERÍSTICAS "OVERSIZED" (BENTO GRID GIGANTE) CON CURVATURA -->
    <div class="relative bg-white pt-32 pb-40 rounded-t-[4rem] -mt-24 shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.3)] z-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            
            <div class="mx-auto max-w-3xl text-center mb-24 reveal">
                <h2 class="text-lg font-bold leading-7 text-indigo-600 uppercase tracking-widest">Cálculo Inteligente</h2>
                <p class="mt-6 text-5xl font-black tracking-tight text-gray-900 sm:text-7xl">Finanzas sin fricción</p>
            </div>

            <!-- GRID DE TARJETAS (Aumentado de tamaño) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 auto-rows-[400px]">
                
                <!-- Tarjeta Vertical (Izquierda) -->
                <div class="md:col-span-1 relative overflow-hidden rounded-[2.5rem] bg-white border border-gray-200 p-10 group hover:shadow-2xl transition-all duration-500 reveal">
                    <div class="h-full flex flex-col justify-between">
                        <div>
                            <div class="h-16 w-16 bg-violet-100 text-violet-600 rounded-2xl flex items-center justify-center mb-8">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">Recibos PDF</h3>
                            <p class="text-gray-600 text-lg leading-relaxed">Generación y envío automático de comprobantes fiscales detallados.</p>
                        </div>
                        
                        <!-- Widget Abstracto PDF -->
                        <div class="mt-8 relative h-40 bg-gray-50 rounded-2xl border border-gray-100 p-6 flex flex-col gap-3 group-hover:scale-105 transition-transform origin-bottom shadow-inner">
                            <div class="w-1/3 h-3 bg-gray-200 rounded-full"></div>
                            <div class="w-2/3 h-3 bg-gray-200 rounded-full"></div>
                            <hr class="border-gray-200 my-2">
                            <div class="flex justify-between items-center">
                                <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                                <div class="w-1/2 h-3 bg-gray-200 rounded-full"></div>
                            </div>
                            <div class="absolute bottom-6 right-6 bg-red-100 text-red-600 text-xs font-bold px-3 py-1.5 rounded-lg">PDF</div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Grande (Derecha Superior - 2 Columnas) -->
                <div class="md:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-indigo-600 text-white p-12 group hover:shadow-2xl transition-all duration-500 reveal delay-100">
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-white opacity-10 rounded-full blur-[80px] group-hover:opacity-20 transition-opacity"></div>
                    
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-4xl font-bold">Cálculo Automático</h3>
                                <svg class="h-10 w-10 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <p class="text-xl text-indigo-100 max-w-xl leading-relaxed">
                                El sistema detecta salarios base, horas extra aprobadas y bonificaciones para calcular el neto a pagar sin intervención manual.
                            </p>
                        </div>

                        <!-- Widget Gráfico -->
                        <div class="mt-10 flex items-end gap-4 h-40 w-full px-6">
                            <div class="w-full bg-indigo-500/50 rounded-t-xl h-[40%] group-hover:h-[50%] transition-all duration-700"></div>
                            <div class="w-full bg-indigo-500/50 rounded-t-xl h-[60%] group-hover:h-[75%] transition-all duration-700 delay-75"></div>
                            <div class="w-full bg-white rounded-t-xl h-[80%] group-hover:h-[90%] transition-all duration-700 delay-150 relative shadow-lg">
                                <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white text-indigo-600 text-sm font-bold px-3 py-1.5 rounded-lg shadow-md">Hoy</div>
                            </div>
                            <div class="w-full bg-indigo-500/50 rounded-t-xl h-[50%] group-hover:h-[55%] transition-all duration-700 delay-200"></div>
                            <div class="w-full bg-indigo-500/50 rounded-t-xl h-[70%] group-hover:h-[65%] transition-all duration-700 delay-300"></div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Horizontal (Izquierda Inferior - 2 Columnas) -->
                <div class="md:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-gray-50 border border-gray-200 p-12 group hover:shadow-2xl transition-all duration-500 reveal delay-200">
                     <div class="flex flex-col md:flex-row gap-12 h-full items-center">
                        <div class="flex-1">
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">Procesamiento por Lotes</h3>
                            <p class="text-gray-600 text-lg mb-8 leading-relaxed">Paga a todo tu equipo con un solo clic. Revisa, ajusta y confirma la nómina de toda la empresa en minutos.</p>
                            <div class="inline-flex items-center gap-2 text-indigo-600 font-bold text-lg group-hover:translate-x-2 transition-transform">
                                <span>Ver demostración</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                        </div>
                        <!-- Widget Lista -->
                        <div class="w-full md:w-1/2 bg-white rounded-2xl shadow-lg border border-gray-100 p-6 space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-gray-50">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                                    <div class="w-24 h-3 bg-gray-200 rounded-full"></div>
                                </div>
                                <div class="w-16 h-3 bg-green-200 rounded-full"></div>
                            </div>
                            <div class="flex items-center justify-between pb-3 border-b border-gray-50">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                                    <div class="w-32 h-3 bg-gray-200 rounded-full"></div>
                                </div>
                                <div class="w-16 h-3 bg-green-200 rounded-full"></div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                                    <div class="w-20 h-3 bg-gray-200 rounded-full"></div>
                                </div>
                                <div class="w-16 h-3 bg-green-200 rounded-full"></div>
                            </div>
                        </div>
                     </div>
                </div>

                <!-- Tarjeta Pequeña (Derecha Inferior - 1 Columna) -->
                <div class="md:col-span-1 relative overflow-hidden rounded-[2.5rem] bg-white border border-gray-200 p-10 group hover:shadow-2xl transition-all duration-500 reveal delay-300">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Deducciones</h3>
                    <!-- Widget Circular -->
                    <div class="relative flex items-center justify-center h-48">
                        <svg class="transform -rotate-90 w-40 h-40">
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-100" />
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="12" fill="transparent" stroke-dasharray="440" stroke-dashoffset="110" class="text-indigo-500 transition-all duration-1000 group-hover:stroke-dashoffset-75" />
                        </svg>
                        <div class="absolute flex flex-col items-center">
                            <span class="text-4xl font-black text-gray-900">-15%</span>
                            <span class="text-sm text-gray-500 font-bold uppercase mt-1">ISR</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 3. CTA FINAL GIGANTE -->
    <div class="relative isolate px-6 py-40 sm:py-56 lg:px-8">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-indigo-900 to-black"></div>
        
        <div class="mx-auto max-w-3xl text-center reveal">
            <h2 class="text-5xl font-black tracking-tight text-white sm:text-7xl mb-8">
                Paga a tiempo,<br>siempre.
            </h2>
            <p class="mx-auto mt-8 max-w-xl text-xl leading-8 text-indigo-200">
                Mantén a tu equipo feliz y tu contabilidad en orden. Descubre la tranquilidad de una nómina sin errores.
            </p>
            <div class="mt-12 flex items-center justify-center gap-x-8">
                <a href="{{ route('login') }}" class="rounded-2xl bg-white px-12 py-5 text-xl font-bold text-indigo-900 shadow-2xl hover:bg-indigo-50 transition-all hover:scale-105 duration-300">
                    Comenzar Ahora
                </a>
            </div>
        </div>
    </div>

</main>

<!-- SCRIPT SCROLL REVEAL -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reveals = document.querySelectorAll('.reveal');
        function checkReveal() {
            const triggerBottom = window.innerHeight / 5 * 4;
            reveals.forEach(box => {
                const boxTop = box.getBoundingClientRect().top;
                if(boxTop < triggerBottom) {
                    box.classList.add('active');
                }
            });
        }
        window.addEventListener('scroll', checkReveal);
        checkReveal();
    });
</script>

@endsection