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

<main class="relative isolate overflow-hidden bg-blue-950">

    <!-- 1. HERO GIGANTE CON "AROS DE LUZ" (POLYGON) - TEMA AZUL -->
    <div class="relative isolate pt-14 pb-48 sm:pb-64 lg:pb-80 overflow-hidden">
        
        <!-- Fondo base oscuro -->
        <div class="absolute inset-0 -z-20 bg-gray-900"></div>

        <!-- Aros de Luz / Degradado Poligonal (Tema Azul/Cian) -->
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-blue-400 to-cyan-400 opacity-40 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        
        <!-- Segunda capa de luz inferior -->
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-cyan-400 to-blue-400 opacity-40 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>

        <!-- Contenido Héroe -->
        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                
                <!-- Texto (Izquierda) -->
                <div class="lg:w-1/2 text-center lg:text-left reveal">
                    
                    <h1 class="text-6xl font-black tracking-tight text-white sm:text-8xl mb-10 leading-[1.1]">
                        Tu equipo,<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Sincronizado.</span>
                    </h1>
                    <p class="mt-8 text-xl leading-8 text-blue-100">
                        Deja de perseguir papeles. Centraliza cada detalle de tus colaboradores en un expediente digital vivo, seguro y accesible desde cualquier lugar.
                    </p>
                    <div class="mt-12 flex items-center justify-center lg:justify-start gap-x-8">
                        <a href="{{ route('login') }}" class="rounded-2xl bg-cyan-600 px-10 py-5 text-xl font-bold text-white shadow-xl shadow-cyan-500/30 hover:bg-cyan-500 hover:scale-105 transition-all duration-300">
                            Crear Expediente
                        </a>
                    </div>
                </div>

                <!-- Imagen (Derecha) -->
                <div class="lg:w-1/2 relative reveal delay-200 w-full">
                    <div class="relative rounded-3xl bg-gradient-to-br from-white/10 to-white/5 p-3 ring-1 ring-white/20 backdrop-blur-sm transform hover:rotate-1 transition-transform duration-700">
                        <div class="rounded-2xl overflow-hidden shadow-5xl aspect-[16/10] bg-slate-900 relative">
                            <img src="{{ asset('img/personnel-1.png') }}" alt="Dashboard de Personal" class="w-full h-full object-cover" 
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex flex-col items-center justify-center text-blue-400 bg-slate-900\'><svg class=\'w-32 h-32 mb-6 opacity-50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z\'/></svg><span class=\'text-2xl font-bold\'>Sube tu captura: personnel-1.png</span></div>'">
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CARACTERÍSTICAS PRINCIPALES (BENTO GRID GIGANTE) CON CURVATURA -->
    <div class="relative bg-white pt-32 pb-40 rounded-t-[4rem] -mt-24 shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.3)] z-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            
            <!-- Introducción -->
            <div class="mx-auto max-w-3xl text-center mb-24 reveal">
                <h2 class="text-lg font-bold leading-7 text-blue-600 uppercase tracking-widest">Poder Total</h2>
                <p class="mt-6 text-5xl font-black tracking-tight text-gray-900 sm:text-7xl">Organización sin fricción</p>
            </div>

            <!-- GRID ASIMÉTRICO (Aumentado de tamaño) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 auto-rows-[400px]">
                
                <!-- Tarjeta Grande (Ocupa 2 columnas) -->
                <div class="md:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-gray-50 border border-gray-200 p-12 group hover:shadow-2xl transition-all duration-500 reveal">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-blue-500 rounded-full blur-3xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
                    
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="h-16 w-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-blue-500/30">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">Lista de empleados</h3>
                            <p class="text-xl text-gray-600 max-w-xl leading-relaxed">Toda la vida del empleado en una sola pantalla. Datos personales, contacto, historial de direcciones y documentos.</p>
                        </div>
                        <!-- Mockup interno -->
                        <div class="mt-10 w-full bg-white rounded-t-2xl shadow-sm border border-gray-100 h-40 overflow-hidden relative px-6">
                            <div class="absolute top-4 left-6 flex gap-3">
                                <div class="h-3 w-3 rounded-full bg-red-400"></div>
                                <div class="h-3 w-3 rounded-full bg-yellow-400"></div>
                                <div class="h-3 w-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="mt-10 space-y-3">
                                <div class="h-3 bg-gray-100 rounded-full w-3/4"></div>
                                <div class="h-3 bg-gray-100 rounded-full w-1/2"></div>
                                <div class="h-3 bg-gray-100 rounded-full w-full"></div>
                                <div class="h-3 bg-gray-100 rounded-full w-5/6"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Vertical -->
                <div class="md:col-span-1 relative overflow-hidden rounded-[2.5rem] bg-gray-900 text-white p-10 group hover:shadow-2xl transition-all duration-500 reveal delay-200">
                    <div class="absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-blue-900 to-transparent opacity-50"></div>
                    <div class="relative z-10 h-full flex flex-col">
                        <div class="h-16 w-16 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center mb-8 text-cyan-400 border border-white/10">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Organigrama</h3>
                        <p class="text-gray-400 text-lg leading-relaxed">Visualiza la estructura jerárquica y asigna cargos correctamente.</p>
                    </div>
                </div>

                <!-- Tarjeta Horizontal Baja -->
                <div class="md:col-span-1 relative overflow-hidden rounded-[2.5rem] bg-white border border-gray-200 p-10 group hover:shadow-2xl transition-all duration-500 reveal">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Historial</h3>
                    <p class="text-xl text-gray-600 leading-relaxed">Auditoría completa de cambios de puesto y salario.</p>
                    <div class="mt-auto flex items-center gap-4 opacity-50 group-hover:opacity-100 transition-opacity pt-8">
                        <div class="h-12 w-1.5 bg-gray-200 rounded-full"></div>
                        <div class="space-y-2">
                            <div class="h-3 w-32 bg-gray-200 rounded-full"></div>
                            <div class="h-3 w-20 bg-gray-100 rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Imagen/Carrusel Pequeño -->
                <div class="md:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-blue-50 p-2 ring-1 ring-blue-100 reveal delay-200">
                    <div class="w-full h-full rounded-[2rem] overflow-hidden relative group cursor-pointer">
                        <img src="{{ asset('img/personnel-2.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Detalle Empleado" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold\'>Sube: personnel-2.png</div>'">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-12">
                            <div class="text-white">
                                <h3 class="text-3xl font-bold">Edición Ultra-Rápida</h3>
                                <p class="text-blue-100 text-lg mt-2">Actualiza datos sin recargar la página.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 3. CTA FINAL GIGANTE -->
    <div class="relative isolate px-6 py-40 sm:py-56 lg:px-8">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-blue-900 to-black"></div>
        
        <div class="mx-auto max-w-3xl text-center reveal">
            <h2 class="text-5xl font-black tracking-tight text-white sm:text-7xl mb-8">
                Tu gente es tu mayor activo.<br>Cuídala.
            </h2>
            <p class="mx-auto mt-8 max-w-xl text-xl leading-8 text-gray-400">
                Empieza hoy mismo a profesionalizar tu gestión de talento con herramientas diseñadas para equipos modernos.
            </p>
            <div class="mt-12 flex items-center justify-center gap-x-8">
                <a href="{{ route('login') }}" class="rounded-2xl bg-white px-12 py-5 text-xl font-bold text-blue-900 shadow-2xl hover:bg-gray-100 transition-colors hover:scale-105 duration-300">
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
        checkReveal(); // Ejecutar al inicio por si ya hay elementos visibles
    });
</script>

@endsection