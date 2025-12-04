<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Acceso - HR-System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-900 flex items-center justify-center p-4">
    
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-8 sm:p-10 text-center">
            
            <!-- Icono de Candado/Seguridad -->
            <div class="mx-auto h-20 w-20 bg-orange-50 rounded-full flex items-center justify-center mb-6 text-orange-500 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>

            <h1 class="text-2xl font-black text-gray-900 tracking-tight mb-4">¿Olvidaste tu contraseña?</h1>
            
            <div class="bg-blue-50 rounded-xl p-4 mb-8 text-left border border-blue-100">
                <p class="text-sm text-blue-800 leading-relaxed font-medium">
                    <span class="block mb-2 font-bold text-blue-900">🔒 Política de Seguridad</span>
                    El restablecimiento automático de contraseñas está desactivado para proteger los datos sensibles de la empresa.
                </p>
            </div>
            
            <p class="text-base text-gray-600 leading-relaxed mb-8">
                Para recuperar tu acceso, por favor contacta directamente al departamento de <strong>Recursos Humanos</strong> o a tu supervisor inmediato para que te generen una nueva credencial temporal.
            </p>

            <div class="space-y-4">
                <a href="{{ route('login') }}" class="flex w-full justify-center rounded-xl bg-primary-600 px-3 py-3.5 text-sm font-bold text-white shadow-lg hover:bg-primary-700 transition-all hover:-translate-y-0.5 duration-200">
                    Volver a Iniciar Sesión
                </a>
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-100">
                <p class="text-xs text-gray-400">Si eres administrador, puedes restablecer contraseñas de otros usuarios desde el panel de gestión de empleados.</p>
            </div>
        </div>
    </div>

</body>
</html>