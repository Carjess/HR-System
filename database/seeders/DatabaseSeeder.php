<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. CREAMOS TU USUARIO "ADMIN"
        // Así siempre tendrás un usuario para entrar:
        // email: test@example.com
        // pass: password
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin' 
        ]);

        // (Estos serán 'employee' por defecto, lo cual es perfecto)
        User::factory(50)->create();
    }
}