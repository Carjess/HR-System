<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            
            // Quién envía y quién recibe
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            
            $table->string('subject'); // Asunto
            $table->text('body'); // El mensaje
            
            // Opciones
            $table->boolean('is_read')->default(false); // ¿Ya lo leyó?
            $table->boolean('allow_reply')->default(true); // ¿Permitir respuesta?
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};