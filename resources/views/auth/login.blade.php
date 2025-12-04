<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - HR-System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900">
    
    <div class="flex min-h-full">
        
        <!-- SECCIÓN IZQUIERDA: FORMULARIO -->
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white w-full max-w-[600px] z-10 relative shadow-2xl">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                
                <!-- Logo -->
                <div class="mb-10">
                    <a href="/" class="flex items-center gap-3 group w-fit">
                        <div class="bg-primary-600 text-white p-2.5 rounded-xl group-hover:scale-110 transition-transform duration-300 shadow-lg shadow-primary-500/30">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-black text-gray-900 tracking-tight">HR-<span class="text-primary-600">System</span></span>
                    </a>
                </div>

                <div>
                    <h2 class="text-3xl font-extrabold leading-tight text-gray-900 tracking-tight">Portal Corporativo</h2>
                    <p class="mt-2 text-sm text-gray-500">
                        Acceso exclusivo para personal autorizado.
                    </p>
                </div>

                <div class="mt-10">
                    <!-- Mensaje de estado -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold leading-6 text-gray-900">Correo Electrónico</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                       class="block w-full rounded-xl border-0 py-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 transition-all bg-gray-50 focus:bg-white"
                                       value="{{ old('email') }}" placeholder="empleado@empresa.com" autofocus>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-bold leading-6 text-gray-900">Contraseña</label>
                            </div>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                       class="block w-full rounded-xl border-0 py-3.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 transition-all bg-gray-50 focus:bg-white"
                                       placeholder="••••••••">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Opciones -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600 cursor-pointer">
                                <label for="remember_me" class="ml-3 block text-sm leading-6 text-gray-600 cursor-pointer font-medium">Recordar mi sesión</label>
                            </div>
                            
                            <!-- Enlace de Ayuda -->
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-500 transition-colors" title="Ayuda de acceso">
                                    ¿Problemas para entrar?
                                </a>
                            @endif
                        </div>

                        <!-- Botón Submit -->
                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-xl bg-primary-600 px-3 py-3.5 text-sm font-bold leading-6 text-white shadow-lg shadow-primary-600/30 hover:bg-primary-700 hover:shadow-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-all hover:-translate-y-0.5 duration-200">
                                Ingresar al Sistema
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DERECHA: IMAGEN DECORATIVA -->
        <div class="relative hidden w-0 flex-1 lg:block">
            <img class="absolute inset-0 h-full w-full object-cover" 
                 src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" 
                 alt="Oficina Moderna">
            
            <!-- Overlay Degradado -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary-900/90 via-primary-800/80 to-emerald-900/80 mix-blend-multiply"></div>
            
            <!-- Contenido Flotante -->
            <div class="absolute inset-0 flex flex-col justify-center items-center text-center p-12 z-20">
                <div class="max-w-xl text-white">
                    <h2 class="text-5xl font-black mb-6 drop-shadow-lg tracking-tight">Tu espacio de trabajo digital.</h2>
                    <p class="text-xl text-primary-100 font-medium drop-shadow-md leading-relaxed">
                        Gestiona tu perfil, consulta tus recibos y mantente conectado con tu equipo.
                    </p>
                    
                    <!-- Widget Decorativo -->
                    <div class="mt-12 bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl shadow-2xl max-w-sm mx-auto transform rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="h-10 w-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold">✓</div>
                            <div class="text-left">
                                <p class="text-xs text-white/70 uppercase font-bold">Estado del Sistema</p>
                                <p class="text-white font-bold">Operativo</p>
                            </div>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-1.5 mb-2">
                            <div class="bg-green-400 h-1.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>