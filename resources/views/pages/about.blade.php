@extends('layouts.public')

@section('content')

<!-- Estilos Scroll Reveal -->
<style>
    .reveal {
        opacity: 0;
        transform: translateY(30px);
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

<main class="relative isolate overflow-hidden bg-slate-900"> <!-- Fondo base oscuro -->

    <!-- 1. HERO GIGANTE E INMERSIVO (Tono Slate/Gris Azulado) -->
    <div class="relative isolate pt-14 pb-40 sm:pb-48 lg:pb-56 overflow-hidden">
        
        <!-- Fondo con degradado Slate/Blue -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-gray-900 via-slate-900 to-blue-950"></div>
        
        <!-- Decoración de fondo -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute top-0 left-1/4 -translate-x-1/2 w-[80rem] h-[50rem] bg-blue-500/10 opacity-40 blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 w-[60rem] h-[60rem] bg-slate-500/10 rounded-full blur-[100px]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-20">
                
                <!-- Texto Hero (Izquierda) -->
                <div class="lg:w-1/2 text-center lg:text-left reveal">
                    <div class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-bold text-blue-200 ring-1 ring-inset ring-blue-400/20 bg-blue-400/10 mb-8">
                        Nuestra Misión 🚀
                    </div>
                    <h1 class="text-5xl font-black tracking-tight text-white sm:text-7xl mb-8 leading-tight">
                        Humanizando <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-slate-200">la Tecnología.</span>
                    </h1>
                    <p class="mt-6 text-xl leading-8 text-slate-300">
                        Creemos en un futuro donde la gestión de recursos humanos no sea un obstáculo administrativo, sino el motor que impulsa el potencial de cada persona.
                    </p>
                </div>
                
                <!-- Imagen Hero (Derecha - Grande y Flotante) -->
                <div class="lg:w-1/2 relative reveal delay-200 w-full">
                    <div class="relative rounded-3xl bg-white/5 p-3 ring-1 ring-white/10 backdrop-blur-sm transform hover:rotate-1 transition-transform duration-700">
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl bg-slate-800 relative group">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80" 
                                 alt="Equipo HR-System" 
                                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        </div>
                        
                        <!-- Decoración Flotante (Estadística) -->
                        <div class="absolute -bottom-8 -left-8 bg-white p-6 rounded-2xl shadow-xl border border-slate-100 hidden lg:block animate-bounce duration-[4000ms]">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Impactando vidas desde</p>
                            <p class="text-4xl font-black text-slate-900">2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. NUESTRA ESENCIA (Diseño Ancho con Curvatura) -->
    <div class="relative bg-white pt-24 pb-32 sm:pt-32 rounded-t-[3rem] -mt-12 shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.5)] z-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            
            <div class="flex flex-col lg:flex-row gap-20 items-center mb-32">
                <!-- Imagen Izquierda -->
                <div class="lg:w-1/2 order-2 lg:order-1 reveal w-full">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200 group aspect-[16/10]">
                        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80" 
                             alt="Oficina Moderna" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                         <!-- Overlay sutil -->
                         <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors"></div>
                    </div>
                </div>
                
                <!-- Texto Derecha (Grande) -->
                <div class="lg:w-1/2 order-1 lg:order-2 reveal delay-200">
                    <h2 class="text-base font-bold leading-7 text-blue-600 uppercase tracking-wide mb-4">Manifiesto</h2>
                    <h3 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-6xl mb-8">Más que Software, somos aliados.</h3>
                    <p class="text-xl text-slate-600 leading-relaxed mb-10">
                        HR-System nació de una frustración real: vimos empresas brillantes ahogadas en papeles y procesos burocráticos. Decidimos construir la herramienta que nos hubiera gustado tener.
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="pl-6 border-l-4 border-blue-500">
                            <h4 class="font-bold text-slate-900 text-xl mb-2">Innovación</h4>
                            <p class="text-base text-slate-500">Usamos tecnología moderna (Laravel 10, Cloud) para garantizar velocidad y seguridad.</p>
                        </div>
                        <div class="pl-6 border-l-4 border-emerald-500">
                            <h4 class="font-bold text-slate-900 text-xl mb-2">Transparencia</h4>
                            <p class="text-base text-slate-500">Sin letras pequeñas ni costos ocultos. Claridad total para ti y tu equipo.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. VALORES (TARJETAS GRANDES Y EXPANDIDAS) -->
            <div class="max-w-3xl mb-16 reveal">
                <h2 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">Lo que nos mueve</h2>
                <p class="mt-6 text-xl text-slate-600">Nuestros principios no son negociables. Diseñamos cada píxel pensando en esto.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Card 1 -->
                <div class="bg-slate-50 p-10 rounded-[2.5rem] border border-slate-100 hover:shadow-xl hover:bg-white transition-all duration-500 hover:-translate-y-2 reveal delay-100 group">
                    <div class="h-16 w-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Simplicidad Radical</h3>
                    <p class="text-slate-600 text-lg leading-relaxed">
                        La complejidad es el enemigo. Diseñamos interfaces tan intuitivas que no necesitarás manuales de capacitación.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl hover:shadow-slate-500/50 transition-all duration-500 hover:-translate-y-2 reveal delay-200 relative overflow-hidden group">
                    <!-- Decoración de fondo card oscura -->
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-blue-500 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                    
                    <div class="relative z-10">
                        <div class="h-16 w-16 bg-white/10 backdrop-blur rounded-2xl flex items-center justify-center text-white mb-8 border border-white/10 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Seguridad Total</h3>
                        <p class="text-slate-300 text-lg leading-relaxed">
                            Tratamos la información de tu empresa como si fuera nuestra. Encriptación de nivel bancario en cada byte.
                        </p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-slate-50 p-10 rounded-[2.5rem] border border-slate-100 hover:shadow-xl hover:bg-white transition-all duration-500 hover:-translate-y-2 reveal delay-300 group">
                    <div class="h-16 w-16 bg-emerald-500 rounded-2xl flex items-center justify-center mb-8 shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Centrados en Ti</h3>
                    <p class="text-slate-600 text-lg leading-relaxed">
                        Creamos herramientas que empoderan a las personas, no que las controlan. Tu feedback define nuestro roadmap.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. CTA FINAL (Estilo Slate Oscuro) -->
    <div class="relative isolate px-6 py-32 sm:mt-12 sm:py-40 lg:px-8">
        <div class="absolute inset-0 -z-10 bg-slate-900"></div>
        
        <!-- Decoración fondo CTA -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,rgba(59,130,246,0.1),transparent_70%)]"></div>

        <div class="mx-auto max-w-3xl text-center reveal">
            <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl mb-8">¿Listo para unirte a la<br>nueva era de RRHH?</h2>
            <a href="{{ route('login') }}" class="inline-block rounded-full bg-white px-12 py-5 text-xl font-bold text-slate-900 shadow-xl hover:bg-blue-50 transition-transform hover:-translate-y-1">
                Empezar Ahora
            </a>
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