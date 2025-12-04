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
        // Verificamos si la tabla ya existe para evitar errores si se corre de nuevo
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->string('title'); // Título del evento
                $table->text('description')->nullable(); // Detalles
                $table->dateTime('start_date'); // Inicio
                $table->dateTime('end_date')->nullable(); // Fin
                
                // Tipos: 'general', 'feriado', 'entrega', 'cumpleanos', 'vacation'
                $table->string('type')->default('general'); 
                
                // Visibilidad por departamento (null = todos)
                $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
                
                // Creador del evento
                $table->foreignId('created_by')->constrained('users');
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};