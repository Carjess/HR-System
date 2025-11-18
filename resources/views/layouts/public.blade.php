<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HR-System - Gestiona tu Equipo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts y Estilos (Vite) -->
        {{-- Alpine.js se importa a través de app.js --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 h-full">
        
        <!-- 1. BARRA DE NAVEGACIÓN "ISLA" -->
        <header class="fixed inset-x-0 top-0 z-50 flex justify-center pt-8">
            {{-- `x-data="{ open: false }"` inicializa Alpine.js para el menú móvil --}}
            <nav class="flex items-center justify-between px-6 py-3 lg:px-8 w-11/12 max-w-7xl 
                        bg-white/95 rounded-full shadow-lg ring-1 ring-gray-900/5 backdrop-blur-sm" 
                 aria-label="Global" x-data="{ open: false }">
                
                <!-- Logo/Nombre -->
                <div class="flex lg:flex-1">
                    <a href="{{ route('home') }}" class="-m-1.5 p-1.5">
                        <span class="text-xl font-bold text-gray-900">HR-System</span>
                    </a>
                </div>

                <!-- Botón de Menú Móvil -->
                <div class="flex lg:hidden">
                    <button type="button" @click="open = true" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Abrir menú principal</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

                <!-- Enlaces de Navegación (Escritorio) -->
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="{{ route('home') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600">Inicio</a>
                    <a href="{{ route('about') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600">Sobre Nosotros</a>
                    
                    <!-- Menú Desplegable "Productos" -->
                    <div class="relative" x-data="{ productsOpen: false }" @click.outside="productsOpen = false">
                        <button type="button" @click="productsOpen = ! productsOpen" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600">
                            Productos
                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <!-- Panel Desplegable (Escritorio) -->
                        <div x-show="productsOpen" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 translate-y-1" 
                             x-transition:enter-end="opacity-100 translate-y-0" 
                             x-transition:leave="transition ease-in duration-150" 
                             x-transition:leave-start="opacity-100 translate-y-0" 
                             x-transition:leave-end="opacity-0 translate-y-1" 
                             class="absolute -left-8 top-full z-10 mt-5 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5"
                             style="display: none;">
                            <div class="p-4">
                                <!-- Enlace Producto 1 -->
                                <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        <svg class="h-6 w-6 text-gray-600 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372m-1.066-2.625a8.37 8.37 0 0 1 3.32-3.32M9 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25a8.25 8.25 0 0 1-8.25 8.25A8.25 8.25 0 0 1 3 14.25a8.25 8.25 0 0 1 16.5 0Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-auto">
                                        <a href="{{ route('products.personnel') }}" @click="productsOpen = false" class="block font-semibold text-gray-900">
                                            Gestión de Personal
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600">Administra tus empleados.</p>
                                    </div>
                                </div>
                                <!-- Enlace Producto 2 -->
                                <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        <svg class="h-6 w-6 text-gray-600 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-auto">
                                        <a href="{{ route('products.contracts') }}" @click="productsOpen = false" class="block font-semibold text-gray-900">
                                            Gestión de Contratos
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600">Administra tipos y detalles de contratos.</p>
                                    </div>
                                </div>
                                <!-- Enlace Producto 3 -->
                                <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        <svg class="h-6 w-6 text-gray-600 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </div>
                                    <div class="flex-auto">
                                        <a href="{{ route('products.timesheets') }}" @click="productsOpen = false" class="block font-semibold text-gray-900">
                                            Facturación de Horas
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600">Registra y controla las horas trabajadas.</p>
                                    </div>
                                </div>
                                <!-- Enlace Producto 4 -->
                                <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        <svg class="h-6 w-6 text-gray-600 group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.75A.75.75 0 0 1 3 4.5h.75m0 0v.75A.75.75 0 0 1 3 6h-.75m0 0v.75A.75.75 0 0 1 3 4.5h.75m0 0V3m0 3v.75A.75.75 0 0 1 3 6h-.75M3.75 9v.75A.75.75 0 0 1 3 10.5h-.75m0 0v-.75A.75.75 0 0 1 3 9h.75m0 0v.75A.75.75 0 0 1 3 10.5h-.75m0 0v.75A.75.75 0 0 1 3 9h.75m0 0V6m0 3v.75A.75.75 0 0 1 3 10.5h-.75M3.75 12v.75A.75.75 0 0 1 3 13.5h-.75m0 0v-.75A.75.75 0 0 1 3 12h.75m0 0v.75A.75.75 0 0 1 3 13.5h-.75m0 0v.75A.75.75 0 0 1 3 12h.75m0 0V9m0 3v.75a.75.75 0 0 1-.75.75h-.75m0 0v-.75a.75.75 0 0 1 .75-.75h.75m0 0v.75a.75.75 0 0 1-.75.75h-.75m0 0v.75a.75.75 0 0 1 .75-.75h.75m0 0h-.75a.75.75 0 0 1-.75-.75V9m1.5 4.5v.75a.75.75 0 0 1-.75.75h-.75m0 0v-.75a.75.75 0 0 1 .75-.75h.75m0 0v.75a.75.75 0 0 1-.75.75h-.75m0 0V9m6 6v.75a.75.75 0 0 1-.75.75h-.75m0 0v-.75a.75.75 0 0 1 .75-.75h.75m0 0v.75a.75.75 0 0 1-.75.75h-.75m0 0V9m6 6v.75a.75.75 0 0 1-.75.75h-.75m0 0v-.75a.75.75 0 0 1 .75-.75h.75m0 0v.75a.75.75 0 0 1-.75.75h-.75m0 0V9" />
                                        </svg>
                                    </div>
                                    <div class="flex-auto">
                                        <a href="{{ route('products.payroll') }}" @click="productsOpen = false" class="block font-semibold text-gray-900">
                                            Pagos de Nómina
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600">Genera recibos de pago.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón Iniciar Sesión (Escritorio) -->
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900 px-4 py-2 rounded-full border border-gray-300 hover:bg-gray-50 transition duration-150">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                Iniciar Sesión <span aria-hidden="true">&rarr;</span>
                            </a>
                        @endauth
                    @endif
                </div>
            </nav>

            <!-- Menú Móvil (Panel lateral) -->
            <!-- ESTE ES EL BLOQUE QUE ESTABA INCOMPLETO EN MI RESPUESTA ANTERIOR -->
            <div x-show="open" x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-150 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
                class="lg:hidden" x-ref="dialog" @click.outside="open = false" style="display: none;">
                <div class="fixed inset-0 z-50"></div> {{-- Fondo oscuro --}}
                <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <!-- Encabezado Menú Móvil -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('home') }}" class="-m-1.5 p-1.5">
                            <span class="text-xl font-bold text-gray-900">HR-System</span>
                        </a>
                        <button type="button" @click="open = false" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                            <span class="sr-only">Cerrar menú</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Contenido Menú Móvil -->
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a href="{{ route('home') }}" @click="open = false" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Inicio</a>
                                <a href="{{ route('about') }}" @click="open = false" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Sobre Nosotros</a>
                                
                                <!-- Desplegable "Productos" Móvil -->
                                <div class="relative" x-data="{ productsOpenMobile: false }">
                                    <button @click="productsOpenMobile = !productsOpenMobile" type="button" class="flex w-full items-center justify-between -mx-3 rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                        Productos
                                        <svg :class="{ 'rotate-180': productsOpenMobile }" class="h-5 w-5 flex-none transition duration-150 ease-in-out" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <!-- Panel de Productos Móvil -->
                                    <div x-show="productsOpenMobile" class="mt-2 space-y-2 px-3" style="display: none;">
                                        <a href="{{ route('products.personnel') }}" @click="open = false" class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">Gestión de Personal</a>
                                        <a href="{{ route('products.contracts') }}" @click="open = false" class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">Gestión de Contratos</a>
                                        <a href="{{ route('products.timesheets') }}" @click="open = false" class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">Facturación de Horas</a>
                                        <a href="{{ route('products.payroll') }}" @click="open = false" class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">Pagos de Nómina</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Botón Iniciar Sesión (Móvil) -->
                            <div class="py-6">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Iniciar Sesión</a>
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- 2. CONTENIDO PRINCIPAL (DE CADA PÁGINA) -->
        <main>
            @yield('content')
        </main>

        <!-- 3. FOOTER (PIE DE PÁGINA) -->
        <footer class="bg-white">
            <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
                <div class="mt-8 border-t border-gray-900/10 pt-8">
                    <p class="text-center text-xs leading-5 text-gray-500">
                        &copy; 2025 HR-System. Un proyecto de práctica con Laravel.
                    </p>
                </div>
            </div>
        </footer>

    </body>
</html>