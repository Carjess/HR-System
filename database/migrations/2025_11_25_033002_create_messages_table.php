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
        // Verificamos si la tabla no existe para evitar errores
        if (!Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                
                // Relaciones
                $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');   // Quien envía
                $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // Quien recibe
                
                // Contenido
                $table->string('subject')->nullable()->default('Chat'); // Asunto (opcional)
                $table->text('body'); // El mensaje
                
                // Estados
                $table->boolean('is_read')->default(false); // ¿Leído?
                $table->boolean('allow_reply')->default(true); // ¿Permite respuesta?
                
                $table->timestamps();
                
                // Índices para velocidad (IMPORTANTE PARA CHAT)
                $table->index(['sender_id', 'receiver_id']);
                $table->index('is_read');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};