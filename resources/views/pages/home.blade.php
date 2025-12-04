@extends('layouts.public')

@section('content')

<!-- Estilos Scroll Reveal -->
<style>
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 1s cubic-bezier(0.5, 0, 0, 1);
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    .delay-100 { transition-delay: 0.1s; }
    .delay-200 { transition-delay: 0.2s; }
    .delay-300 { transition-delay: 0.3s; }
</style>

<main class="relative isolate overflow-hidden bg-primary-950"> <!-- Fondo base oscuro ajustado a la marca -->

    <!-- 1. HERO GIGANTE CON DEGRADADO Y CURVATURA -->
    <div class="relative isolate pt-14 pb-40 sm:pb-48 lg:pb-56 overflow-hidden">
        
        <!-- Fondo con degradado Verde Petróleo -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-gray-900 via-primary-900 to-emerald-900"></div>
        
        <!-- Decoración de fondo (Manchas de luz) -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[100rem] h-[50rem] bg-primary-500/20 opacity-30 blur-[100px]"></div>
            <div class="absolute bottom-0 right-0 w-[60rem] h-[60rem] bg-emerald-500/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40 relative z-10">
            <div class="mx-auto max-w-4xl text-center reveal">
                
                <!-- Badge Superior (Verde) -->
                <!-- <div class="mb-10 flex justify-center">
                    <div class="relative rounded-full px-6 py-2 text-sm leading-6 text-primary-200 ring-1 ring-primary-500/30 hover:ring-primary-500/50 bg-primary-500/10 backdrop-blur-md shadow-sm transition-all hover:scale-105 cursor-default font-medium">
                         <span class="font-bold text-primary-400"></span> 
                    </div>
                   
                </div> --> 

                <!-- Título Principal Gigante -->
                <h1 class="text-5xl font-black tracking-tight text-white sm:text-7xl lg:text-8xl mb-10 leading-tight">
                    Gestiona tu Capital Humano <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 via-emerald-300 to-teal-200">Sin Complicaciones</span>
                </h1>
                
                <!-- Subtítulo -->
                <p class="mt-6 text-xl font-medium leading-8 text-primary-100 max-w-3xl mx-auto">
                    La plataforma todo en uno que centraliza empleados, nómina, contratos y comunicación. Diseñada para eliminar el caos administrativo y devolverte el control.
                </p>
                
                <!-- Botones de Acción (VERDE PETRÓLEO) -->
                <div class="mt-12 flex items-center justify-center gap-x-8">
                    <a href="{{ route('login') }}" class="rounded-2xl bg-orange-600 px-10 py-5 text-lg font-bold text-white shadow-xl shadow-primary-500/30 hover:bg-orange-600 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                        Empezar Ahora
                    </a>
                    <a href="#features" class="text-lg font-semibold leading-6 text-white flex items-center gap-2 hover:text-primary-300 transition-colors group">
                        Ver funciones <span aria-hidden="true" class="group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>
            
            <!-- IMAGEN DEL DASHBOARD (FLOTANTE) -->
            <div class="mt-20 flow-root sm:mt-32 reveal delay-200">
                <div class="-m-2 rounded-3xl bg-white/5 p-3 ring-1 ring-inset ring-white/10 lg:-m-4 lg:rounded-[2.5rem] lg:p-6 backdrop-blur-xl transform hover:scale-[1.01] transition-transform duration-700">
                    <div class="rounded-2xl shadow-2xl overflow-hidden bg-white border border-gray-800">
                        <!-- Imagen Placeholder -->
                        <img src="{{ asset('img/dashboard-preview.png') }}" 
                             alt="Dashboard Preview" 
                             class="w-full h-auto object-cover"
                             onerror="this.parentElement.innerHTML='<div class=\'aspect-[16/9] bg-gradient-to-br from-gray-900 to-gray-800 flex flex-col items-center justify-center text-gray-500\'><svg class=\'w-32 h-32 mb-6 text-gray-700\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg><span class=\'text-2xl font-bold\'>Sube tu captura: dashboard-preview.png</span></div>'">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. SECCIÓN CARACTERÍSTICAS (GRID BENTO GRANDE) CON CURVATURA -->
    <!-- Solapamiento con rounded-t-[3rem] y margen negativo -->
    <div id="features" class="relative bg-white pt-24 pb-32 sm:pt-32 rounded-t-[3rem] -mt-20 shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.3)] z-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center mb-24 reveal">
                <h2 class="text-base font-bold leading-7 text-primary-600 uppercase tracking-wide">Potencia tu empresa</h2>
                <p class="mt-4 text-4xl font-black tracking-tight text-gray-900 sm:text-6xl">Todas las herramientas<br>que necesitas</p>
                <p class="mt-6 text-xl leading-8 text-gray-600">
                    HR-System cubre cada etapa del ciclo de vida del empleado con módulos integrados que se comunican entre sí.
                </p>
            </div>
            
            <!-- Grid de 3 columnas con tarjetas grandes -->
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 lg:max-w-none lg:grid-cols-3">
                
                <!-- Card 1: Expedientes -->
                <div class="flex flex-col justify-between rounded-[2rem] bg-white p-10 shadow-lg ring-1 ring-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 reveal delay-100 group">
                    <div>
                        <div class="h-16 w-16 flex items-center justify-center rounded-2xl bg-blue-100 text-blue-600 mb-8 group-hover:scale-110 transition-transform">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Lista de empleados</h3>
                        <p class="text-lg leading-relaxed text-gray-600">
                            Información personal, laboral y documentos en un solo lugar. Accede al historial completo al instante.
                        </p>
                    </div>
                </div>

                <!-- Card 2: Nómina -->
                <div class="flex flex-col justify-between rounded-[2rem] bg-white p-10 shadow-lg ring-1 ring-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 reveal delay-200 group">
                    <div>
                        <div class="h-16 w-16 flex items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 mb-8 group-hover:scale-110 transition-transform">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Nómina Automática</h3>
                        <p class="text-lg leading-relaxed text-gray-600">
                            Cálculos de salarios, bonos y deducciones en segundos. Emite recibos claros sin errores manuales.
                        </p>
                    </div>
                </div>

                <!-- Card 3: Chat -->
                <div class="flex flex-col justify-between rounded-[2rem] bg-white p-10 shadow-lg ring-1 ring-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 reveal delay-300 group">
                    <div>
                        <div class="h-16 w-16 flex items-center justify-center rounded-2xl bg-sky-100 text-sky-600 mb-8 group-hover:scale-110 transition-transform">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Chat Corporativo</h3>
                        <p class="text-lg leading-relaxed text-gray-600">
                            Comunicación directa y profesional. Elimina el WhatsApp y mantén las conversaciones de trabajo en un canal seguro.
                        </p>
                    </div>
                </div>

                <!-- Card 4: Ausencias -->
                <div class="flex flex-col justify-between rounded-[2rem] bg-white p-10 shadow-lg ring-1 ring-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 reveal group">
                    <div>
                        <div class="h-16 w-16 flex items-center justify-center rounded-2xl bg-orange-100 text-orange-600 mb-8 group-hover:scale-110 transition-transform">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Control de Ausencias</h3>
                        <p class="text-lg leading-relaxed text-gray-600">
                            Gestión de vacaciones y permisos médicos. Flujo de aprobación simple y transparente para todos.
                        </p>
                    </div>
                </div>

                <!-- Card 5: Contratos -->
                <div class="flex flex-col justify-between rounded-[2rem] bg-white p-10 shadow-lg ring-1 ring-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 reveal delay-100 group">
                    <div>
                        <div class="h-16 w-16 flex items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 mb-8 group-hover:scale-110 transition-transform">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Gestión Legal</h3>
                        <p class="text-lg leading-relaxed text-gray-600">
                            Administra contratos, renovaciones y vencimientos. Recibe alertas automáticas antes de que un contrato expire.
                        </p>
                    </div>
                </div>

                <!-- Card 6: Horas -->
                <div class="flex flex-col justify-between rounded-[2rem] bg-white p-10 shadow-lg ring-1 ring-gray-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 reveal delay-200 group">
                    <div>
                        <div class="h-16 w-16 flex items-center justify-center rounded-2xl bg-purple-100 text-purple-600 mb-8 group-hover:scale-110 transition-transform">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Control de Horarios</h3>
                        <p class="text-lg leading-relaxed text-gray-600">
                            Timesheets integrados para el registro diario de horas trabajadas. Fundamental para calcular pagos por hora y horas extra.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 3. CTA FINAL (VERDE PETRÓLEO) -->
    <div class="relative isolate px-6 py-32 sm:mt-12 sm:py-40 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-primary-900 to-gray-900"></div>
        <!-- Efectos de fondo -->
        <div class="absolute inset-y-0 left-0 -z-10 w-full overflow-hidden ring-1 ring-white/10">
            <div class="absolute -left-10 top-0 -z-10 w-[50rem] h-[50rem] bg-primary-500/20 blur-[100px] rounded-full"></div>
        </div>
        
        <div class="mx-auto max-w-2xl text-center reveal">
            <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Pon orden en tu<br>empresa hoy mismo.</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-primary-100">
                Únete a las empresas que ya han digitalizado su departamento de recursos humanos con HR-System.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="{{ route('login') }}" class="rounded-2xl bg-white px-8 py-4 text-lg font-bold text-primary-900 shadow-sm hover:bg-primary-50 hover:scale-105 transition-all duration-300">
                    Crear mi cuenta
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
        checkReveal(); // Ejecutar al inicio
    });
</script>

@endsection