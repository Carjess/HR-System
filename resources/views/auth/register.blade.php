<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse - HR-System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900">
    
    <div class="flex min-h-full">
        
        <!-- SECCIÓN IZQUIERDA: IMAGEN -->
        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" 
                 src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80" 
                 alt="Equipo Colaborando">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary-900/90 via-emerald-900/80 to-primary-800/80 mix-blend-multiply"></div>
            
            <div class="absolute inset-0 flex flex-col justify-center items-center text-center p-12 z-20">
                <div class="max-w-xl text-white">
                    <h2 class="text-4xl font-bold mb-6">Únete al futuro de RRHH</h2>
                    <p class="text-lg text-primary-100">
                        Empieza a optimizar tu gestión de personal hoy mismo. Sin tarjetas de crédito.
                    </p>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DERECHA: FORMULARIO -->
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white w-full max-w-[600px] z-10 relative shadow-2xl">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                
                <div class="mb-8">
                    <a href="/" class="flex items-center gap-2 text-primary-600 font-bold mb-6 hover:text-primary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Volver al inicio
                    </a>
                    <h2 class="text-3xl font-black tracking-tight text-gray-900">Crear cuenta nueva</h2>
                    <p class="mt-2 text-sm text-gray-500">
                        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="font-bold text-primary-600 hover:text-primary-500">Inicia sesión</a>
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-bold leading-6 text-gray-900">Nombre Completo</label>
                        <div class="mt-2">
                            <input id="name" name="name" type="text" required autofocus autocomplete="name" 
                                   class="block w-full rounded-xl border-0 py-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 bg-gray-50 transition-all"
                                   value="{{ old('name') }}">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold leading-6 text-gray-900">Correo Electrónico</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" required autocomplete="username" 
                                   class="block w-full rounded-xl border-0 py-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 bg-gray-50 transition-all"
                                   value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold leading-6 text-gray-900">Contraseña</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" required autocomplete="new-password" 
                                   class="block w-full rounded-xl border-0 py-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 bg-gray-50 transition-all">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold leading-6 text-gray-900">Confirmar Contraseña</label>
                        <div class="mt-2">
                            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" 
                                   class="block w-full rounded-xl border-0 py-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 bg-gray-50 transition-all">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-xl bg-primary-600 px-3 py-3.5 text-sm font-bold leading-6 text-white shadow-lg shadow-primary-600/30 hover:bg-primary-700 hover:shadow-xl transition-all hover:-translate-y-0.5 duration-200">
                            Registrarme
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>