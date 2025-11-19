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
        Schema::table('contract_types', function (Blueprint $table) {
            // Añadimos descripción (texto largo opcional)
            $table->text('description')->nullable()->after('name');
            
            // Añadimos salario base sugerido para este tipo
            $table->decimal('salary', 10, 2)->default(0)->after('description');
            
            // Añadimos la relación con el Departamento
            $table->foreignId('department_id')->nullable()->constrained('departments')->after('salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contract_types', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['description', 'salary', 'department_id']);
        });
    }
};