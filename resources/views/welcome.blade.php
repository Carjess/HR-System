<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HR-System - Gestiona tu Equipo</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        {{-- Alpine.js se importa a través de app.js --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 h-full">
        
        <header class="fixed inset-x-0 top-0 z-50 flex justify-center pt-8">
            {{-- `x-data` inicializa Alpine.js para los menús --}}
            <nav class="flex items-center justify-between px-6 py-3 lg:px-8 w-11/12 max-w-7xl 
                        bg-white/95 rounded-full shadow-lg ring-1 ring-gray-900/5 backdrop-blur-sm" 
                 aria-label="Global" x-data="{ open: false }"> {{-- `open` es para el menú móvil --}}
                
                <div class="flex lg:flex-1">
                    <a href="/" class="-m-1.5 p-1.5">
                        <span class="text-xl font-bold text-gray-900">HR-System</span>
                    </a>
                </div>

                <div class="flex lg:hidden">
                    <button type="button" @click="open = true" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Abrir menú principal</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="/" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600">Inicio</a>
                    <a href="#about" class="text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600">Sobre Nosotros</a>
                    
                    {{-- `x-data` aquí crea un estado local solo para este desplegable --}}
                    <div class="relative" x-data="{ productsOpen: false }" @click.outside="productsOpen = false">
                        <button type="button" @click="productsOpen = ! productsOpen" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 hover:text-blue-600">
                            Productos
                            <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <div x-show="productsOpen" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 translate-y-1" 
                             x-transition:enter-end="opacity-100 translate-y-0" 
                             x-transition:leave="transition ease-in duration-150" 
                             x-transition:leave-start="opacity-100 translate-y-0" 
                             x-transition:leave-end="opacity-0 translate-y-1" 
                             class="absolute -left-8 top-full z-10 mt-5 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5"
                             style="display: none;"> {{-- Oculto por defecto, Alpine lo maneja --}}
                            <div class="p-4">
                                <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        
                                    </div>
                                    <div class="flex-auto">
                                        <a href="#features" @click="productsOpen = false" class="block font-semibold text-gray-900">
                                            Gestión de Personal
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600">Administra tus empleados.</p>
                                    </div>
                                </div>
                                <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        
                                    </div>
                                    <div class="flex-auto">
                                        <a href="#features" @click="productsOpen = false" class="block font-semibold text-gray-900">
                                            Gestión de Contratos
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600">Administra tipos y detalles de contratos.</p>
                                    </div>
                                </div>
                                <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        

[Image of clock icon]

                                    </div>
                                    <div class="flex-auto">
                                        <a href="#features" @click="productsOpen = false" class="block font-semibold text-gray-900">
                                            Facturación de Horas
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600">Registra y controla las horas trabajadas.</p>
                                    </div>
                                </div>
                                <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm leading-6 hover:bg-gray-50">
                                    <div class="flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        
                                    </div>
                                    <div class="flex-auto">
                                        <a href="#features" @click="productsOpen = false" class="block font-semibold text-gray-900">
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

            <div x-show="open" x-transition:enter="duration-150 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-150 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
                class="lg:hidden" x-ref="dialog" @click.outside="open = false" style="display: none;">
                <div class="fixed inset-0 z-50"></div>
                <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <a href="/" class="-m-1.5 p-1.5">
                            <span class="text-xl font-bold text-gray-900">HR-System</span>
                        </a>
                        <button type="button" @click="open = false" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                            <span class="sr-only">Cerrar menú</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a href="/" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Inicio</a>
                                <a href="#about" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Sobre Nosotros</a>
                                
                                <div class="relative" x-data="{ productsOpenMobile: false }">
                                    <button @click="productsOpenMobile = !productsOpenMobile" type="button" class="flex w-full items-center justify-between -mx-3 rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                        Productos
                                        <svg :class="{ 'rotate-180': productsOpenMobile }" class="h-5 w-5 flex-none transition duration-150 ease-in-out" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="productsOpenMobile" class="mt-2 space-y-2 px-3" style="display: none;">
                                        <a href="#features" @click="open = false" class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">Gestión de Personal</a>
                                        <a href="#features" @click="open = false" class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">Gestión de Contratos</a>
                                        <a href="#features" @click="open = false" class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">Facturación de Horas</a>
                                        <a href="#features" @click="open = false" class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">Pagos de Nómina</a>
                                    </div>
                                </div>
                            </div>
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

        <main class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#80caff] to-[#4f46e5] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" 
                     style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>

            <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        Gestiona tu equipo de forma simple y centralizada
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Bienvenido a HR-System, tu plataforma todo-en-uno para administrar empleados, contratos, nóminas, horarios y mucho más.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('register') }}" class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Empezar Ahora
                        </a>
                        <a href="#features" class="text-sm font-semibold leading-6 text-gray-900">Ver beneficios <span aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
            </div>
        </main>

        <section id="features" class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-blue-600">Todo lo que necesitas</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Beneficios de tu Software de RR. HH.
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Estos son los módulos que has construido. Cada uno es una "tarjeta" rectangular con texto y una imagen, tal como pediste.
                    </p>
                </div>
                
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <dl class="grid max-w-none grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-2">
                        
                        <div id="gestion-personal" class="flex flex-col rounded-2xl bg-gray-50 p-8 shadow-sm transition duration-300 hover:shadow-xl">
                            <dt class="text-lg font-semibold leading-7 text-gray-900">
                                Gestión de Personal (CRUD)
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                Crea, edita, elimina y visualiza el perfil de todos tus empleados, incluyendo su puesto y departamento.
                            </dd>
                            <dd class="mt-6 flex-grow">
                                <div class="rounded-lg bg-gray-200 p-4 h-48 flex items-center justify-center text-gray-500">
                                    
                                </div>
                            </dd>
                        </div>

                        <div id="gestion-contratos" class="flex flex-col rounded-2xl bg-gray-50 p-8 shadow-sm transition duration-300 hover:shadow-xl">
                            <dt class="text-lg font-semibold leading-7 text-gray-900">
                                Gestión de Contratos
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                Asigna tipos de contrato (Temporal, Indefinido) a tus empleados, con fechas de inicio, fin y salario.
                            </dd>
                            <dd class="mt-6 flex-grow">
                                <div class="rounded-lg bg-gray-200 p-4 h-48 flex items-center justify-center text-gray-500">
                                    
                                </div>
                            </dd>
                        </div>

                        <div id="facturacion-horas" class="flex flex-col rounded-2xl bg-gray-50 p-8 shadow-sm transition duration-300 hover:shadow-xl">
                            <dt class="text-lg font-semibold leading-7 text-gray-900">
                                Facturación de Horas
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                Permite que los empleados registren sus horas trabajadas día a día. Edita y elimina registros fácilmente.
                            </dd>
                            <dd class="mt-6 flex-grow">
                                <div class="rounded-lg bg-gray-200 p-4 h-48 flex items-center justify-center text-gray-500">
                                    
                                </div>
                            </dd>
                        </div>

                        <div id="pagos-nomina" class="flex flex-col rounded-2xl bg-gray-50 p-8 shadow-sm transition duration-300 hover:shadow-xl">
                            <dt class="text-lg font-semibold leading-7 text-gray-900">
                                Pagos de Nómina
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                Genera los recibos de pago para todos los empleados con un solo clic, calculando salarios, horas y deducciones.
                            </dd>
                            <dd class="mt-6 flex-grow">
                                <div class="rounded-lg bg-gray-200 p-4 h-48 flex items-center justify-center text-gray-500">
                                    
                                </div>
                            </dd>
                        </div>
                        
                    </dl>
                </div>
            </div>
        </section>

        <section id="about" class="bg-gray-100 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-blue-600">Nuestra Misión</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Sobre Nosotros
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Este proyecto es una demostración de habilidades en desarrollo full-stack con Laravel. Creado para practicar y dominar los conceptos de un sistema de RRHH real, desde la gestión de empleados hasta el procesamiento de nóminas.
                    </p>
                </div>
            </div>
        </section>

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