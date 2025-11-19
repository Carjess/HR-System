<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // --- AÑADE ESTE CÓDIGO DENTRO DEL MÉTODO boot() ---

        // Esto crea una "puerta" o permiso llamado 'is-admin'
        // Solo devolverá 'true' si el rol del usuario que está
        // intentando pasar es estrictamente igual a 'admin'.
        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });

        // --- FIN DEL CÓDIGO A AÑADIR ---
    }
}