@extends('layouts.public')

@section('content')

<!-- SECCIÓN "PRODUCTO: GESTIÓN DE CONTRATOS" -->
<main class="relative isolate px-6 pt-14 lg:px-8">
    
    <!-- Fondo degradado -->
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#80caff] to-[#4f46e5] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
             style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
        </div>
    </div>

    <!-- Contenido de la página -->
    <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                Gestión de Contratos
            </h1>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                Define y asigna contratos a tus empleados. Mantén un historial completo de los términos, salarios y fechas de cada acuerdo laboral.
            </p>
        </div>
    </div>
</main>

<!-- Sección de detalles (Texto + Imagen) -->
<section class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="grid grid-cols-1 items-center gap-x-8 gap-y-16 lg:grid-cols-2">
            <!-- Columna de Texto -->
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Control Total sobre los Acuerdos</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Crea tipos de contrato reutilizables (Indefinido, Temporal, Prácticas) y asigna salarios y duraciones específicas a cada empleado. Todo el historial se mantiene en el perfil del empleado.
                </p>
                <ul class="mt-8 list-disc pl-5 space-y-2 text-gray-600">
                    <li>Crea tipos de contrato ilimitados.</li>
                    <li>Asigna fechas de inicio y fin (opcional para indefinidos).</li>
                    <li>Registra el salario base para cada contrato.</li>
                </ul>
            </div>
            <!-- Columna de Imagen -->
            <div class="rounded-2xl bg-gray-50 p-8 shadow-sm">
                <div class="rounded-lg bg-gray-200 p-4 h-96 flex items-center justify-center text-gray-500">
                    [Imagen de la lista de contratos en el perfil]
                </div>
            </div>
        </div>
    </div>
</section>


@endsection