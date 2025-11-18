@extends('layouts.public')

@section('content')

    <main class="relative isolate px-6 pt-14 lg:px-8">
        
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#80caff] to-[#4f46e5] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                 style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                    Sobre HR-System
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    HR-System es un proyecto de práctica avanzado construido con Laravel para demostrar un sistema de gestión de recursos humanos completo. Creado por [Aquí puedes poner tu nombre o el de tu compañía].
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Nuestra misión es centralizar la información de los empleados, optimizar el pago de nóminas y facilitar la gestión de contratos y horarios, todo en una plataforma intuitiva creada para demostrar las capacidades del framework Laravel.
                </p>
            </div>
        </div>
    </main>

@endsection