<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añadimos la columna 'role' después de la columna 'password'
            // 'admin' para administradores, 'employee' para empleados
            // Por defecto (default), cualquier usuario nuevo será un 'employee'
            $table->string('role')->default('employee')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Esto es para poder revertir el cambio si es necesario
            $table->dropColumn('role');
        });
    }
};