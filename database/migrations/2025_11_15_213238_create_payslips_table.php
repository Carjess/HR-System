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
        Schema::create('payslips', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained('users');

        // El rango de fechas de esta nómina
        $table->date('pay_period_start'); // Inicio del periodo de pago
        $table->date('pay_period_end');   // Fin del periodo

        // Estos son los datos que se calcularán y guardarán
        $table->decimal('base_salary', 10, 2); // Salario base de su contrato
        $table->decimal('total_hours', 5, 2)->default(0); // Total de horas aprobadas
        $table->decimal('bonuses', 10, 2)->default(0);
        $table->decimal('deductions', 10, 2)->default(0);
        $table->decimal('net_pay', 10, 2); // El pago neto final

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
