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
    
    /* Animación de pulso para el widget de reloj */
    @keyframes pulse-ring {
        0% { transform: scale(0.8); opacity: 0.5; }
        100% { transform: scale(2); opacity: 0; }
    }
    .pulse-dot::before {
        content: '';
        position: absolute;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: inherit;
        border-radius: 50%;
        z-index: -1;
        animation: pulse-ring 2s infinite;
    }
</style>

<main class="relative isolate overflow-hidden bg-purple-950">

    <!-- 1. HERO GIGANTE CON "AROS DE LUZ" (POLYGON) - TEMA PÚRPURA -->
    <div class="relative isolate pt-14 pb-48 sm:pb-64 lg:pb-80 overflow-hidden">
        
        <!-- Fondo base oscuro -->
        <div class="absolute inset-0 -z-20 bg-gray-900"></div>

        <!-- Aros de Luz / Degradado Poligonal (Tema Purple/Fuchsia) -->
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-purple-400 to-fuchsia-400 opacity-40 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        
        <!-- Segunda capa de luz inferior -->
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-fuchsia-400 to-purple-400 opacity-40 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>

        <!-- Contenido Héroe -->
        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                
                <!-- Texto (Izquierda) -->
                <div class="lg:w-1/2 text-center lg:text-left reveal">
                    
                    <h1 class="text-6xl font-black tracking-tight text-white sm:text-8xl mb-10 leading-[1.1]">
                        Cada minuto<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-fuchsia-300">Cuenta.</span>
                    </h1>
                    <p class="mt-8 text-xl leading-8 text-purple-100">
                        Registra la asistencia y las horas trabajadas con precisión milimétrica. Ideal para trabajo remoto, oficinas híbridas y control de proyectos.
                    </p>
                    <div class="mt-12 flex items-center justify-center lg:justify-start gap-x-8">
                        <a href="{{ route('login') }}" class="rounded-2xl bg-purple-600 px-10 py-5 text-xl font-bold text-white shadow-xl shadow-purple-500/30 hover:bg-purple-500 hover:scale-105 transition-all duration-300">
                            Empezar Ahora
                        </a>
                    </div>
                </div>

                <!-- Imagen (Derecha) -->
                <div class="lg:w-1/2 relative reveal delay-200 w-full">
                    <div class="relative rounded-3xl bg-gradient-to-br from-white/10 to-white/5 p-3 ring-1 ring-white/20 backdrop-blur-sm transform hover:rotate-1 transition-transform duration-700">
                        <div class="rounded-2xl overflow-hidden shadow-2xl aspect-[16/10] bg-gray-900 group relative" x-data="{ active: 0, slides: [
                                { img: '{{ asset('img/timesheets-1.png') }}', caption: 'Calendario de horas' },
                                { img: '{{ asset('img/timesheets-2.png') }}', caption: 'Reporte de asistencia' }
                             ] }">
                            
                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="active === index" 
                                     x-transition:enter="transition ease-out duration-700" 
                                     x-transition:enter-start="opacity-0 scale-110" 
                                     x-transition:enter-end="opacity-100 scale-100" 
                                     class="absolute inset-0 w-full h-full">
                                    <img :src="slide.img" :alt="slide.caption" class="w-full h-full object-cover opacity-90" 
                                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-purple-400 bg-gray-800 flex-col\'><svg class=\'w-32 h-32 mb-6 opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z\'/></svg><span class=\'text-2xl font-bold\'>Sube tu captura: timesheets-' + (index+1) + '.png</span></div>'">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-8 left-8">
                                        <p class="text-lg font-bold text-purple-200" x-text="slide.caption"></p>
                                    </div>
                                </div>
                            </template>

                            <!-- Controles Carrusel -->
                            <div class="absolute bottom-8 right-8 flex gap-3">
                                <template x-for="(slide, index) in slides">
                                    <button @click="active = index" class="h-2 rounded-full transition-all duration-300" :class="active === index ? 'w-10 bg-purple-500' : 'w-3 bg-white/30 hover:bg-white/50'"></button>
                                </template>
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
                <h2 class="text-lg font-bold leading-7 text-purple-600 uppercase tracking-widest">Sin Fricción</h2>
                <p class="mt-6 text-5xl font-black tracking-tight text-gray-900 sm:text-7xl">Registro Simplificado</p>
            </div>

            <!-- GRID DE TARJETAS (Aumentado de tamaño) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-32 reveal delay-200">
                
                <!-- Widget Visual: Cronómetro Abstracto (Gigante) -->
                <div class="relative">
                    <div class="absolute -inset-10 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full blur-3xl opacity-70"></div>
                    
                    <!-- Tarjeta Widget -->
                    <div class="relative bg-white rounded-[2.5rem] p-10 shadow-2xl border border-gray-100">
                        <div class="flex justify-between items-center mb-10">
                            <div>
                                <div class="text-sm text-gray-400 font-bold uppercase tracking-wider">Hoy, {{ now()->format('d M') }}</div>
                                <div class="text-3xl font-black text-gray-900">Registro de Tiempo</div>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center pulse-dot relative bg-green-500">
                                <div class="h-4 w-4 bg-white rounded-full"></div>
                            </div>
                        </div>

                        <div class="flex justify-center my-10">
                            <div class="relative h-64 w-64 rounded-full border-[12px] border-gray-50 flex items-center justify-center shadow-inner">
                                <svg class="absolute top-0 left-0 w-full h-full text-purple-500 transform -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="46" fill="none" stroke="#f3f4f6" stroke-width="8" />
                                    <circle cx="50" cy="50" r="46" fill="none" stroke="currentColor" stroke-width="8" stroke-dasharray="289" stroke-dashoffset="70" stroke-linecap="round" />
                                </svg>
                                <div class="text-center">
                                    <div class="text-6xl font-black text-gray-900 tracking-tighter">06:45</div>
                                    <div class="text-sm text-gray-400 font-bold uppercase tracking-[0.2em] mt-2">Horas</div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <button class="w-full py-4 rounded-2xl bg-gray-100 text-gray-400 font-bold text-lg cursor-not-allowed">Entrada</button>
                            <button class="w-full py-4 rounded-2xl bg-red-50 text-red-500 font-bold text-lg hover:bg-red-100 transition-colors">Salida</button>
                        </div>
                    </div>
                </div>

                <!-- Texto Explicativo (Derecha) -->
                <div class="lg:pl-12">
                    <h3 class="text-4xl font-black text-gray-900 mb-8 leading-tight">Autonomía para tu equipo,<br>control para ti.</h3>
                    <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                        Los empleados pueden registrar sus entradas y salidas desde cualquier dispositivo. El sistema calcula automáticamente las horas trabajadas, descansos y horas extra.
                    </p>
                    
                    <ul class="space-y-8">
                        <li class="flex items-start gap-6">
                            <div class="flex-none h-12 w-12 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 mt-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Multi-dispositivo</h4>
                                <p class="text-lg text-gray-500">Accesible desde móvil, tablet o escritorio sin instalaciones complejas.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-6">
                            <div class="flex-none h-12 w-12 rounded-2xl bg-pink-100 flex items-center justify-center text-pink-600 mt-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Aprobación Simple</h4>
                                <p class="text-lg text-gray-500">Los supervisores revisan y aprueban hojas de tiempo con un clic.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CARDS SECUNDARIAS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 reveal">
                
                <!-- Card 1 -->
                <div class="bg-purple-50 rounded-[2.5rem] p-10 hover:bg-white hover:shadow-xl transition-all duration-300 border border-purple-100 group">
                    <div class="h-16 w-16 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-4">Integración Total</h4>
                    <p class="text-gray-600 text-lg leading-relaxed">Las horas aprobadas viajan directo a la nómina. Sin exportar Excels.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-[2.5rem] p-10 shadow-lg border border-gray-100 group hover:-translate-y-1 transition-transform duration-300">
                    <div class="h-16 w-16 bg-pink-100 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-4">Reportes Visuales</h4>
                    <p class="text-gray-600 text-lg leading-relaxed">Analiza puntualidad, horas extra y ausentismo con gráficos claros.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-gray-50 rounded-[2.5rem] p-10 hover:bg-white hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                    <div class="h-16 w-16 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold text-gray-900 mb-4">Histórico</h4>
                    <p class="text-gray-600 text-lg leading-relaxed">Guarda un registro auditable de cada jornada laboral por años.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. CTA FINAL GIGANTE -->
    <div class="relative isolate px-6 py-40 sm:py-56 lg:px-8">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-purple-900 to-black"></div>
        
        <div class="mx-auto max-w-3xl text-center reveal">
            <h2 class="text-5xl font-black tracking-tight text-white sm:text-7xl mb-8">
                El tiempo es dinero.<br>No lo pierdas gestionándolo.
            </h2>
            <p class="mx-auto mt-8 max-w-xl text-xl leading-8 text-purple-200">
                Únete a las empresas que ya automatizaron su control de asistencia con HR-System.
            </p>
            <div class="mt-12 flex items-center justify-center gap-x-8">
                <a href="{{ route('login') }}" class="rounded-2xl bg-white px-12 py-5 text-xl font-bold text-purple-900 shadow-2xl hover:bg-purple-50 transition-colors hover:scale-105 duration-300">
                    Empezar Ahora
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