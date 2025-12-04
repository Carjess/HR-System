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

<main class="relative isolate overflow-hidden bg-emerald-950">

    <!-- 1. HERO GIGANTE CON "AROS DE LUZ" (POLYGON) - TEMA ESMERALDA -->
    <div class="relative isolate pt-14 pb-48 sm:pb-64 lg:pb-80 overflow-hidden">
        
        <!-- Fondo base oscuro -->
        <div class="absolute inset-0 -z-20 bg-gray-900"></div>

        <!-- Aros de Luz / Degradado Poligonal (Tema Emerald/Teal) -->
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-emerald-400 to-teal-400 opacity-40 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        
        <!-- Segunda capa de luz inferior -->
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-teal-400 to-emerald-400 opacity-40 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>

        <!-- Contenido Héroe -->
        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                
                <!-- Texto (Izquierda) -->
                <div class="lg:w-1/2 text-center lg:text-left reveal">
                    
                    <h1 class="text-6xl font-black tracking-tight text-white sm:text-8xl mb-10 leading-[1.1]">
                        Control<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-300">Total.</span>
                    </h1>
                    <p class="mt-8 text-xl leading-8 text-emerald-100">
                        Olvídate de los archivadores físicos y las fechas de vencimiento perdidas. Gestiona el ciclo de vida completo de los contratos laborales en una plataforma digital blindada.
                    </p>
                    <div class="mt-12 flex items-center justify-center lg:justify-start gap-x-8">
                        <a href="{{ route('login') }}" class="rounded-2xl bg-emerald-600 px-10 py-5 text-xl font-bold text-white shadow-xl shadow-emerald-500/30 hover:bg-emerald-500 hover:scale-105 transition-all duration-300">
                            Administrar Ahora
                        </a>
                    </div>
                </div>

                <!-- Imagen (Derecha) -->
                <div class="lg:w-1/2 relative reveal delay-200 w-full">
                    <div class="relative rounded-3xl bg-gradient-to-br from-white/10 to-white/5 p-3 ring-1 ring-white/20 backdrop-blur-sm transform hover:rotate-1 transition-transform duration-700">
                        <div class="rounded-2xl overflow-hidden shadow-2xl aspect-[16/10] bg-slate-900 relative">
                            <img src="{{ asset('img/contracts-1.png') }}" alt="Dashboard de Contratos" class="w-full h-full object-cover" 
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex flex-col items-center justify-center text-emerald-400 bg-slate-900\'><svg class=\'w-32 h-32 mb-6 opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\'/></svg><span class=\'text-2xl font-bold\'>Sube tu captura: contracts-1.png</span></div>'">
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CARACTERÍSTICAS "OVERSIZED" (BENTO GRID GIGANTE) CON CURVATURA -->
    <div class="relative bg-white pt-32 pb-40 rounded-t-[4rem] -mt-24 shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.3)] z-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            
            <!-- Introducción -->
            <div class="mx-auto max-w-3xl text-center mb-24 reveal">
                <h2 class="text-lg font-bold leading-7 text-emerald-600 uppercase tracking-widest">Flexibilidad Total</h2>
                <p class="mt-6 text-5xl font-black tracking-tight text-gray-900 sm:text-7xl">Adapta cada acuerdo</p>
                <p class="mt-8 text-xl leading-8 text-gray-600 max-w-2xl mx-auto">
                    Ya sea un contrato indefinido, temporal, de prácticas o por obra determinada. Configura plantillas reutilizables y asigna condiciones salariales específicas en segundos.
                </p>
            </div>

            <!-- GRID DE TARJETAS (Aumentado de tamaño) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 auto-rows-[400px]">
                
                <!-- Card 1: Alertas (Vertical Izquierda) -->
                <div class="md:col-span-1 relative overflow-hidden rounded-[2.5rem] bg-emerald-50 border border-emerald-100 p-10 group hover:shadow-2xl transition-all duration-500 reveal delay-100">
                    <div class="h-full flex flex-col justify-between">
                        <div>
                            <div class="h-16 w-16 bg-emerald-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-emerald-500/30">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">Alertas de Vencimiento</h3>
                            <p class="text-gray-600 text-lg leading-relaxed">
                                El sistema monitorea las fechas de fin de contrato y te notifica con antelación. Toma decisiones de renovación o baja sin prisas.
                            </p>
                        </div>
                        <!-- Decoración abstracta -->
                        <div class="w-full h-2 bg-emerald-200 rounded-full mt-4 overflow-hidden">
                            <div class="h-full bg-emerald-500 w-2/3 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Historial (Grande Derecha) -->
                <div class="md:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-white border border-gray-200 p-12 group hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 reveal delay-200">
                    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-teal-50 rounded-full blur-3xl opacity-50 group-hover:opacity-80 transition-opacity"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-start gap-10 h-full">
                        <div class="flex-1">
                            <div class="h-16 w-16 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="text-4xl font-bold text-gray-900 mb-4">Historial Inalterable</h3>
                            <p class="text-xl text-gray-600 leading-relaxed">
                                Cada cambio contractual se guarda como una nueva versión. Mantén un registro histórico perfecto de la evolución de cada empleado.
                            </p>
                        </div>
                        
                        <!-- Widget Visual (Timeline) -->
                        <div class="w-full md:w-1/3 bg-gray-50 rounded-2xl p-6 border border-gray-100 space-y-6 self-center">
                            <div class="flex gap-4 opacity-50">
                                <div class="flex flex-col items-center">
                                    <div class="w-3 h-3 rounded-full bg-gray-300"></div>
                                    <div class="w-0.5 h-10 bg-gray-200"></div>
                                </div>
                                <div>
                                    <div class="h-2 w-16 bg-gray-200 rounded mb-1"></div>
                                    <div class="h-2 w-24 bg-gray-100 rounded"></div>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-4 h-4 rounded-full border-2 border-teal-500 bg-white"></div>
                                </div>
                                <div>
                                    <div class="h-3 w-20 bg-teal-600 rounded mb-1"></div>
                                    <div class="h-2 w-28 bg-teal-100 rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Nómina (Horizontal Inferior) -->
                <div class="md:col-span-3 relative overflow-hidden rounded-[2.5rem] bg-gray-900 p-12 group hover:shadow-2xl transition-all duration-500 reveal delay-300">
                    <div class="absolute inset-0 overflow-hidden">
                         <div class="absolute -left-20 -bottom-20 w-96 h-96 bg-emerald-600/20 rounded-full blur-[100px]"></div>
                         <div class="absolute top-0 right-0 w-[40rem] h-[40rem] bg-gradient-to-b from-gray-800 to-transparent opacity-30"></div>
                    </div>

                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-12">
                        <div class="flex-1">
                            <div class="h-16 w-16 bg-emerald-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-emerald-500/20">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-3xl font-bold text-white mb-4">Integración con Nómina</h3>
                            <p class="text-lg text-gray-400 leading-relaxed max-w-2xl">
                                El salario definido en el contrato alimenta automáticamente el módulo de pagos. Cambia el contrato y la próxima nómina se ajustará sola, calculando prorrateos si el cambio ocurre a mitad de mes.
                            </p>
                        </div>
                        <div class="hidden md:flex gap-4 items-center">
                            <div class="px-6 py-3 rounded-full bg-white/10 border border-white/20 text-emerald-400 font-bold backdrop-blur-sm">
                                Contrato Activo
                            </div>
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            <div class="px-6 py-3 rounded-full bg-emerald-500 text-white font-bold shadow-lg shadow-emerald-500/20">
                                Nómina Lista
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 3. CTA FINAL GIGANTE -->
    <div class="relative isolate px-6 py-40 sm:py-56 lg:px-8">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-emerald-900 to-black"></div>
        
        <div class="mx-auto max-w-3xl text-center reveal">
            <h2 class="text-5xl font-black tracking-tight text-white sm:text-7xl mb-8">
                Pon orden en tu<br>documentación legal.
            </h2>
            <p class="mx-auto mt-8 max-w-xl text-xl leading-8 text-emerald-100">
                Deja de usar carpetas compartidas y Excels desactualizados. Pásate a la gestión profesional hoy mismo.
            </p>
            <div class="mt-12 flex items-center justify-center gap-x-8">
                <a href="{{ route('login') }}" class="rounded-2xl bg-white px-12 py-5 text-xl font-bold text-emerald-900 shadow-2xl hover:bg-emerald-50 transition-all hover:scale-105 duration-300">
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