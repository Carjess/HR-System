@extends('layouts.public')

@section('content')

    <!-- 1. SECCIÓN "HERO" (EL TÍTULO PRINCIPAL) -->
    <main class="relative isolate px-6 pt-14 lg:px-8">
        
        <!-- Fondo degradado -->
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#80caff] to-[#4f46e5] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" 
                 style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <!-- Contenido Hero -->
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                    Gestiona tu equipo de forma simple y centralizada
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Bienvenido a HR-System, tu plataforma todo-en-uno para administrar empleados, contratos, nóminas, horarios y mucho más.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    
                    <a href="#features" class="text-sm font-semibold leading-6 text-gray-900">Ver beneficios <span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>
    </main>

    <!-- 2. SECCIÓN DE BENEFICIOS (CON TARJETAS Y SVGs) -->
    <section id="features" class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-blue-600">Todo lo que necesitas</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Beneficios de tu Software de RR. HH.
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Estos son los módulos que has construido. Cada uno es una "tarjeta" rectangular con texto y un ícono minimalista.
                </p>
            </div>
            
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-none grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-2">
                    
                    <!-- Tarjeta 1: Gestión de Personal -->
                    <div id="gestion-personal" class="flex flex-col rounded-2xl bg-gray-50 p-8 shadow-sm transition duration-300 hover:shadow-xl">
                        <dt class="text-lg font-semibold leading-7 text-gray-900">
                            Gestión de Personal (CRUD)
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">
                            Crea, edita, elimina y visualiza el perfil de todos tus empleados, incluyendo su puesto y departamento.
                        </dd>
                        <dd class="mt-6 flex-grow flex items-center justify-center">
                            <svg class="h-48 w-48 text-blue-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372m-1.066-2.625a8.37 8.37 0 0 1 3.32-3.32M9 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25a8.25 8.25 0 0 1-8.25 8.25A8.25 8.25 0 0 1 3 14.25a8.25 8.25 0 0 1 16.5 0Z" />
                            </svg>
                        </dd>
                    </div>

                    <!-- Tarjeta 2: Gestión de Contratos -->
                    <div id="gestion-contratos" class="flex flex-col rounded-2xl bg-gray-50 p-8 shadow-sm transition duration-300 hover:shadow-xl">
                        <dt class="text-lg font-semibold leading-7 text-gray-900">
                            Gestión de Contratos
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">
                            Asigna tipos de contrato (Temporal, Indefinido) a tus empleados, con fechas de inicio, fin y salario.
                        </dd>
                        <dd class="mt-6 flex-grow flex items-center justify-center">
                            <svg class="h-48 w-48 text-blue-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </dd>
                    </div>

                    <!-- Tarjeta 3: Facturación de Horas -->
                    <div id="facturacion-horas" class="flex flex-col rounded-2xl bg-gray-50 p-8 shadow-sm transition duration-300 hover:shadow-xl">
                        <dt class="text-lg font-semibold leading-7 text-gray-900">
                            Facturación de Horas
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">
                            Permite que los empleados registren sus horas trabajadas día a día. Edita y elimina registros fácilmente.
                        </dd>
                        <dd class="mt-6 flex-grow flex items-center justify-center">
                            <svg class="h-48 w-48 text-blue-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </dd>
                    </div>

                    <!-- Tarjeta 4: Pagos de Nómina -->
                    <div id="pagos-nomina" class="flex flex-col rounded-2xl bg-gray-50 p-8 shadow-sm transition duration-300 hover:shadow-xl">
                        <dt class="text-lg font-semibold leading-7 text-gray-900">
                            Pagos de Nómina
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">
                            Genera los recibos de pago para todos los empleados con un solo clic, calculando salarios, horas y deducciones.
                        </dd>
                        <dd class="mt-6 flex-grow flex items-center justify-center">
                            <svg class="h-48 w-48 text-blue-200" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.75A.75.75 0 0 1 3 4.5h.75m0 0v.75A.75.75 0 0 1 3 6h-.75m0 0v.75A.75.75 0 0 1 3 4.5h.75m0 0V3m0 3v.75A.75.75 0 0 1 3 6h-.75M3.75 9v.75A.75.75 0 0 1 3 10.5h-.75m0 0v-.75A.75.75 0 0 1 3 9h.75m0 0v.75A.75.75 0 0 1 3 10.5h-.75m0 0v.75A.75.75 0 0 1 3 9h.75m0 0V6m0 3v.75A.75.75 0 0 1 3 10.5h-.75M3.75 12v.75A.75.75 0 0 1 3 13.5h-.75m0 0v-.75A.75.75 0 0 1 3 12h.75m0 0v.75A.75.75 0 0 1 3 13.5h-.75m0 0v.75A.75.75 0 0 1 3 12h.75m0 0V9m0 3v.75a.75.75 0 0 1-.75.75h-.75m0 0v-.75a.75.75 0 0 1 .75-.75h.75m0 0v.75a.75.75 0 0 1-.75.75h-.75m0 0v.75a.75.75 0 0 1 .75-.75h.75m0 0h-.75a.75.75 0 0 1-.75-.75V9m1.5 4.5v.75a.75.75 0 0 1-.75.75h-.75m0 0v-.75a.75.75 0 0 1 .75-.75h.75m0 0v.75a.75.75 0 0 1-.75.75h-.75m0 0V9m6 6v.75a.75.75 0 0 1-.75.75h-.75m0 0v-.75a.75.75 0 0 1 .75-.75h.75m0 0v.75a.75.75 0 0 1-.75.75h-.75m0 0V9m6 6v.75a.75.75 0 0 1-.75.75h-.75m0 0v-.75a.75.75 0 0 1 .75-.75h.75m0 0v.75a.75.75 0 0 1-.75.75h-.75m0 0V9" />
                            </svg>
                        </dd>
                    </div>
                    
                </dl>
            </div>
        </div>
    </section>

@endsection