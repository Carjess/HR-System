<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HR-System - Gestión Inteligente de Personal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts y Estilos -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 h-full selection:bg-orange-100 selection:text-orange-600 flex flex-col">
        
        <!-- 1. BARRA DE NAVEGACIÓN DINÁMICA -->
        <header class="fixed inset-x-0 top-0 z-50 flex justify-center pt-6 transition-all duration-500" 
                x-data="{ scrolled: false, mobileOpen: false }" 
                @scroll.window="scrolled = (window.pageYOffset > 20)">
            
            <!-- 
                LÓGICA DE ESTILOS:
                - Si scrolled es true: Fondo blanco, sombra, texto oscuro (estilo isla).
                - Si scrolled es false: Fondo transparente, sin sombra, texto blanco (estilo inmersivo).
            -->
            <nav class="flex items-center justify-between px-6 lg:px-8 w-11/12 max-w-7xl rounded-full transition-all duration-500 ease-in-out" 
                 :class="scrolled ? 'bg-white/90 shadow-2xl ring-1 ring-gray-900/5 backdrop-blur-md py-3' : 'bg-transparent shadow-none py-5'"
                 aria-label="Global">
                
                <!-- Logo -->
                <div class="flex lg:flex-1">
                    <a href="{{ route('home') }}" class="-m-1.5 p-1.5 flex items-center group">
        
                        <div class="flex-shrink-0 -mr-5">
                            <img src="{{ asset('img/rh_green.png') }}" 
                                alt="HR System" 
                                class="h-12 w-auto"
                                x-show="scrolled"
                                style="display: none;"> 

                            <img src="{{ asset('img/rh_white.jpg') }}" 
                                alt="HR System" 
                                class="h-12 w-auto"
                                x-show="!scrolled">
                        </div>

                        <span class="text-3xl font-bold tracking-tight transition-colors duration-500 z-10"
                            :class="scrolled ? 'text-gray-900' : 'text-white'">
                            <span :class="scrolled ? 'text-teal-900' : 'text-white-200'">- System</span>
                        </span>
                    </a>
                </div>

                <!-- Botón Menú Móvil -->
                <div class="flex lg:hidden">
                    <button type="button" @click="mobileOpen = true" 
                            class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 transition-colors duration-500"
                            :class="scrolled ? 'text-gray-700 hover:text-primary-600' : 'text-white hover:text-primary-200'">
                        <span class="sr-only">Abrir menú</span>
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

                <!-- Enlaces Escritorio -->
                <div class="hidden lg:flex lg:gap-x-10">
                    <a href="{{ route('home') }}" 
                       class="text-sm font-semibold leading-6 transition-colors duration-500"
                       :class="scrolled ? 'text-gray-900 hover:text-primary-600' : 'text-white hover:text-primary-200'">
                       Inicio
                    </a>
                    
                    <!-- Dropdown Soluciones -->
                    <div class="relative group" x-data="{ productsOpen: false }" @click.outside="productsOpen = false">
                        <button type="button" @click="productsOpen = ! productsOpen" 
                                class="flex items-center gap-x-1 text-sm font-semibold leading-6 outline-none transition-colors duration-500"
                                :class="scrolled ? 'text-gray-900 hover:text-primary-600' : 'text-white hover:text-primary-200'">
                            Soluciones
                            <svg class="h-4 w-4 flex-none transition-colors duration-500" 
                                 :class="scrolled ? 'text-gray-400 group-hover:text-primary-600' : 'text-white/70 group-hover:text-white'"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <!-- Panel Dropdown (Siempre blanco por legibilidad) -->
                        <div x-show="productsOpen" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 translate-y-1" 
                             x-transition:enter-end="opacity-100 translate-y-0" 
                             class="absolute -left-8 top-full z-20 mt-3 w-screen max-w-sm overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-gray-900/5"
                             style="display: none;">
                            <div class="p-2">
                                <a href="{{ route('products.personnel') }}" class="group relative flex items-center gap-x-4 rounded-xl p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-primary-50 group-hover:bg-primary-100 transition-colors">
                                        <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div><div class="font-semibold text-gray-900">Personal</div><p class="text-xs text-gray-500">Lista de empleados y perfiles</p></div>
                                </a>
                                <a href="{{ route('products.contracts') }}" class="group relative flex items-center gap-x-4 rounded-xl p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-emerald-50 group-hover:bg-emerald-100 transition-colors">
                                        <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div><div class="font-semibold text-gray-900">Contratos</div><p class="text-xs text-gray-500">Gestión de documentos legales</p></div>
                                </a>
                                <a href="{{ route('products.payroll') }}" class="group relative flex items-center gap-x-4 rounded-xl p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-blue-50 group-hover:bg-blue-100 transition-colors">
                                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div><div class="font-semibold text-gray-900">Nómina</div><p class="text-xs text-gray-500">Cálculo de pagos automático</p></div>
                                </a>
                                <a href="{{ route('products.timesheets') }}" class="group relative flex items-center gap-x-4 rounded-xl p-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-purple-50 group-hover:bg-purple-100 transition-colors">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0 1 18 0z" /></svg>
                                    </div>
                                    <div><div class="font-semibold text-gray-900">Horas</div><p class="text-xs text-gray-500">Control de asistencia y tiempo</p></div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('about') }}" 
                       class="text-sm font-semibold leading-6 transition-colors duration-500"
                       :class="scrolled ? 'text-gray-900 hover:text-primary-600' : 'text-white hover:text-primary-200'">
                       Sobre Nosotros
                    </a>
                </div>

                <!-- Botones Acción -->
                <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                               class="text-sm font-bold leading-6 transition-colors flex items-center gap-1"
                               :class="scrolled ? 'text-primary-700 hover:text-primary-900' : 'text-white hover:text-primary-200'">
                                Ir al Dashboard <span aria-hidden="true"></span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="rounded-full px-5 py-2.5 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5"
                               :class="scrolled ? 'bg-primary-600 shadow-primary-600/30 hover:bg-primary-700' : 'bg-white/20 backdrop-blur-md border border-white/30 hover:bg-white/30'">
                                Iniciar Sesión
                            </a>
                        @endauth
                    @endif
                </div>
            </nav>

            <!-- Menú Móvil (Slide Over) -->
            <div x-show="mobileOpen" class="lg:hidden" style="display: none;">
                <div class="fixed inset-0 z-50 bg-gray-900/60 backdrop-blur-sm" @click="mobileOpen = false" x-transition.opacity></div>
                <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm shadow-2xl" 
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full">
                    
                    <div class="flex items-center justify-between">
                        <a href="#" class="-m-1.5 p-1.5 flex items-center gap-2">
                            <div class="bg-primary-600 text-white p-1 rounded-lg">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <span class="text-xl font-bold text-gray-900">HR-System</span>
                        </a>
                        <button type="button" @click="mobileOpen = false" class="-m-2.5 rounded-md p-2.5 text-gray-700 hover:bg-gray-100">
                            <span class="sr-only">Cerrar menú</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-100">
                            <div class="space-y-2 py-6">
                                <a href="{{ route('home') }}" class="-mx-3 block rounded-xl px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50 hover:text-primary-600">Inicio</a>
                                <div class="py-2">
                                    <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Soluciones</p>
                                    <a href="{{ route('products.personnel') }}" class="-mx-3 block rounded-xl px-3 py-2 text-base font-medium leading-7 text-gray-600 hover:bg-blue-50 hover:text-blue-600">Gestión de Personal</a>
                                    <a href="{{ route('products.contracts') }}" class="-mx-3 block rounded-xl px-3 py-2 text-base font-medium leading-7 text-gray-600 hover:bg-emerald-50 hover:text-emerald-600">Contratos Digitales</a>
                                    <a href="{{ route('products.payroll') }}" class="-mx-3 block rounded-xl px-3 py-2 text-base font-medium leading-7 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600">Nómina Automática</a>
                                    <a href="{{ route('products.timesheets') }}" class="-mx-3 block rounded-xl px-3 py-2 text-base font-medium leading-7 text-gray-600 hover:bg-purple-50 hover:text-purple-600">Control de Asistencia</a>
                                </div>
                                <a href="{{ route('about') }}" class="-mx-3 block rounded-xl px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50 hover:text-primary-600">Sobre Nosotros</a>
                            </div>
                            <div class="py-6">
                                <a href="{{ route('login') }}" class="-mx-3 block rounded-xl px-3 py-3 text-base font-bold leading-7 text-white bg-gradient-to-r from-primary-600 to-emerald-600 text-center shadow-lg">Iniciar Sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- 2. CONTENIDO PRINCIPAL -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- 3. FOOTER (MEGA FOOTER OSCURO) -->
        <!-- Fondo gris muy oscuro (bg-gray-900) con texto blanco/gris claro para contraste -->
        <footer class="bg-gray-900 text-white mt-24 relative" aria-labelledby="footer-heading">
            
            <h2 id="footer-heading" class="sr-only">Footer</h2>
            
            <div class="mx-auto max-w-7xl px-6 pb-12 pt-20 lg:px-8">
                <div class="xl:grid xl:grid-cols-4 xl:gap-12">
                    
                    <!-- COLUMNA 1: MARCA Y REDES -->
                    <div class="space-y-8 xl:col-span-1">
                        <a href="{{ route('home') }}" class="flex items-center gap-3">
                            <div class="bg-white/10 p-2 rounded-xl backdrop-blur-sm border border-white/10">
                                <svg class="h-8 w-8 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold text-white tracking-tight">HR-System</span>
                        </a>
                        <p class="text-base leading-7 text-gray-400">
                            La plataforma integral para digitalizar y optimizar tu departamento de recursos humanos.
                        </p>
                        <!-- Redes Sociales -->
                        <div class="flex space-x-6">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <span class="sr-only">X</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M13.6823 10.6218L20.2391 3H18.6854L12.9921 9.61788L8.44486 3H3.2002L10.0765 13.0074L3.2002 21H4.75404L10.7663 14.0113L15.5685 21H20.8131L13.6819 10.6218H13.6823ZM11.5541 13.0956L10.8574 12.0991L5.31391 4.16971H7.70053L12.1742 10.5689L12.8709 11.5655L18.6861 19.8835H16.2995L11.5541 13.096V13.0956Z" /></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" /></svg>
                            </a>
                        </div>
                    </div>

                    <!-- COLUMNA 2: SOLUCIONES -->
                    <div class="mt-16 xl:mt-0">
                        <h3 class="text-base font-semibold leading-6 text-white tracking-wider uppercase mb-6">Soluciones</h3>
                        <ul role="list" class="space-y-4">
                            <li><a href="{{ route('products.personnel') }}" class="text-base leading-6 text-gray-400 hover:text-primary-400 transition-colors">Gestión de Personal</a></li>
                            <li><a href="{{ route('products.contracts') }}" class="text-base leading-6 text-gray-400 hover:text-primary-400 transition-colors">Contratos Digitales</a></li>
                            <li><a href="{{ route('products.payroll') }}" class="text-base leading-6 text-gray-400 hover:text-primary-400 transition-colors">Nómina Automática</a></li>
                            <li><a href="{{ route('products.timesheets') }}" class="text-base leading-6 text-gray-400 hover:text-primary-400 transition-colors">Control de Asistencia</a></li>
                        </ul>
                    </div>

                    <!-- COLUMNA 3: COMPAÑÍA -->
                    <div class="mt-16 xl:mt-0">
                        <h3 class="text-base font-semibold leading-6 text-white tracking-wider uppercase mb-6">Compañía</h3>
                        <ul role="list" class="space-y-4">
                            <li><a href="{{ route('about') }}" class="text-base leading-6 text-gray-400 hover:text-primary-400 transition-colors">Sobre Nosotros</a></li>
                            <li><a href="#" class="text-base leading-6 text-gray-400 hover:text-primary-400 transition-colors">Blog</a></li>
                            <li><a href="#" class="text-base leading-6 text-gray-400 hover:text-primary-400 transition-colors">Carreras</a></li>
                            <li><a href="#" class="text-base leading-6 text-gray-400 hover:text-primary-400 transition-colors">Prensa</a></li>
                        </ul>
                    </div>

                    <!-- COLUMNA 4: CONTACTO -->
                    <div class="mt-16 xl:mt-0">
                        <h3 class="text-base font-semibold leading-6 text-white tracking-wider uppercase mb-6">Contacto</h3>
                        <ul role="list" class="space-y-4">
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 text-primary-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                <span class="text-base leading-6 text-gray-400">soporte@hr-system.com</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 text-primary-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                <span class="text-base leading-6 text-gray-400">+52 (55) 1234-5678</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 text-primary-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <span class="text-base leading-6 text-gray-400">Torre Reforma, Piso 25<br>Ciudad de México, MX</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 lg:mt-24">
                    <div class="md:flex md:items-center md:justify-between">
                        <p class="text-sm leading-5 text-gray-500">&copy; 2025 HR-System. Todos los derechos reservados.</p>
                        <div class="mt-4 md:order-1 md:mt-0 flex gap-6 text-sm text-gray-400">
                            <a href="#" class="hover:text-white transition-colors">Privacidad</a>
                            <a href="#" class="hover:text-white transition-colors">Términos</a>
                            <a href="#" class="hover:text-white transition-colors">Cookies</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>