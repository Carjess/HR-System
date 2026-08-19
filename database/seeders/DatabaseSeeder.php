<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\ContractType;
use App\Models\Contract;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ----------------------------------------------------
        // 1. DEPARTAMENTOS
        // ----------------------------------------------------
        $depTi = Department::firstOrCreate(['name' => 'Tecnología e Innovación']);
        $depRrhh = Department::firstOrCreate(['name' => 'Recursos Humanos']);
        $depFinanzas = Department::firstOrCreate(['name' => 'Finanzas y Contabilidad']);
        $depVentas = Department::firstOrCreate(['name' => 'Marketing y Ventas']);
        $depOperaciones = Department::firstOrCreate(['name' => 'Operaciones y Logística']);

        // ----------------------------------------------------
        // 2. PUESTOS / CARGOS
        // ----------------------------------------------------
        $posDevSenior = Position::firstOrCreate([
            'name' => 'Desarrollador Full Stack Senior',
            'department_id' => $depTi->id
        ]);
        $posUiUx = Position::firstOrCreate([
            'name' => 'Diseñador UI/UX & Producto',
            'department_id' => $depTi->id
        ]);
        $posGerenteRrhh = Position::firstOrCreate([
            'name' => 'Gerente de Gestión Humana',
            'department_id' => $depRrhh->id
        ]);
        $posReclutador = Position::firstOrCreate([
            'name' => 'Especialista de Reclutamiento',
            'department_id' => $depRrhh->id
        ]);
        $posContador = Position::firstOrCreate([
            'name' => 'Contador General',
            'department_id' => $depFinanzas->id
        ]);
        $posEjecutivoVentas = Position::firstOrCreate([
            'name' => 'Ejecutivo de Cuentas Corporativas',
            'department_id' => $depVentas->id
        ]);

        // ----------------------------------------------------
        // 3. TIPOS DE CONTRATO
        // ----------------------------------------------------
        $tipoIndefinidoSenior = ContractType::firstOrCreate(
            ['name' => 'Indefinido - Tiempo Completo'],
            [
                'description' => 'Contrato a término indefinido con jornada completa (40 horas semanales).',
                'salary' => 3200.00,
                'department_id' => $depTi->id,
                'position_id' => $posDevSenior->id
            ]
        );

        $tipoIndefinidoEspecialista = ContractType::firstOrCreate(
            ['name' => 'Indefinido - Especialista'],
            [
                'description' => 'Contrato a término indefinido con todos los beneficios de ley.',
                'salary' => 2400.00,
                'department_id' => $depRrhh->id,
                'position_id' => $posReclutador->id
            ]
        );

        $tipoPlazoFijo = ContractType::firstOrCreate(
            ['name' => 'Plazo Fijo - 12 Meses'],
            [
                'description' => 'Contrato temporal renovable sujeto a evaluación de desempeño.',
                'salary' => 1800.00,
                'department_id' => $depVentas->id,
                'position_id' => $posEjecutivoVentas->id
            ]
        );

        $tipoPasantia = ContractType::firstOrCreate(
            ['name' => 'Convenio de Prácticas / Pasantía'],
            [
                'description' => 'Convenio de aprendizaje y formación profesional.',
                'salary' => 750.00,
                'department_id' => $depTi->id,
                'position_id' => $posUiUx->id
            ]
        );

        // ----------------------------------------------------
        // 4. USUARIOS / EMPLEADOS
        // ----------------------------------------------------

        // A. Administrador Principal (Credenciales de acceso solicitadas)
        $admin = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Administrador General',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'position_id' => $posGerenteRrhh->id,
                'telefono' => '+1 809 555 0101',
                'direccion' => 'Torre Empresarial, Piso 10',
                'fecha_contratacion' => Carbon::now()->subYears(2),
                'email_verified_at' => now(),
            ]
        );

        Contract::updateOrCreate(
            ['employee_id' => $admin->id],
            [
                'contract_type_id' => $tipoIndefinidoSenior->id,
                'start_date' => Carbon::now()->subYears(2)->toDateString(),
                'salary' => 3800.00,
            ]
        );

        // B. Supervisor
        $supervisor = User::updateOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'name' => 'Carlos Mendoza (Supervisor TI)',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'position_id' => $posDevSenior->id,
                'telefono' => '+1 809 555 0202',
                'direccion' => 'Av. Principal #45',
                'fecha_contratacion' => Carbon::now()->subYear(),
                'email_verified_at' => now(),
            ]
        );

        Contract::updateOrCreate(
            ['employee_id' => $supervisor->id],
            [
                'contract_type_id' => $tipoIndefinidoSenior->id,
                'start_date' => Carbon::now()->subYear()->toDateString(),
                'salary' => 3200.00,
            ]
        );

        // C. Empleado 1 (Diseñadora)
        $empleado1 = User::updateOrCreate(
            ['email' => 'ana.gomez@example.com'],
            [
                'name' => 'Ana Gómez',
                'password' => Hash::make('12345678'),
                'role' => 'employee',
                'position_id' => $posUiUx->id,
                'telefono' => '+1 809 555 0303',
                'direccion' => 'Calle Las Palmas #12',
                'fecha_contratacion' => Carbon::now()->subMonths(8),
                'email_verified_at' => now(),
            ]
        );

        Contract::updateOrCreate(
            ['employee_id' => $empleado1->id],
            [
                'contract_type_id' => $tipoIndefinidoEspecialista->id,
                'start_date' => Carbon::now()->subMonths(8)->toDateString(),
                'salary' => 2400.00,
            ]
        );

        // D. Empleado 2 (Contador)
        $empleado2 = User::updateOrCreate(
            ['email' => 'david.rodriguez@example.com'],
            [
                'name' => 'David Rodríguez',
                'password' => Hash::make('12345678'),
                'role' => 'employee',
                'position_id' => $posContador->id,
                'telefono' => '+1 809 555 0404',
                'direccion' => 'Urb. El Rosal, Casa #8',
                'fecha_contratacion' => Carbon::now()->subMonths(5),
                'email_verified_at' => now(),
            ]
        );

        Contract::updateOrCreate(
            ['employee_id' => $empleado2->id],
            [
                'contract_type_id' => $tipoPlazoFijo->id,
                'start_date' => Carbon::now()->subMonths(5)->toDateString(),
                'salary' => 2100.00,
            ]
        );

        // E. Empleado 3 (Ventas)
        $empleado3 = User::updateOrCreate(
            ['email' => 'laura.torres@example.com'],
            [
                'name' => 'Laura Torres',
                'password' => Hash::make('12345678'),
                'role' => 'employee',
                'position_id' => $posEjecutivoVentas->id,
                'telefono' => '+1 809 555 0505',
                'direccion' => 'Residencial San Carlos #21',
                'fecha_contratacion' => Carbon::now()->subMonths(3),
                'email_verified_at' => now(),
            ]
        );

        Contract::updateOrCreate(
            ['employee_id' => $empleado3->id],
            [
                'contract_type_id' => $tipoPlazoFijo->id,
                'start_date' => Carbon::now()->subMonths(3)->toDateString(),
                'salary' => 1900.00,
            ]
        );

        // ----------------------------------------------------
        // 5. MENSAJES DE PRUEBA EN EL CHAT (Para el Inbox)
        // ----------------------------------------------------
        Message::firstOrCreate([
            'sender_id' => $empleado1->id,
            'receiver_id' => $admin->id,
            'body' => '¡Hola Administrador! Ya subí los nuevos diseños de la interfaz para su revisión.',
        ], [
            'subject' => 'Ticket #1001',
            'is_read' => false,
            'allow_reply' => true,
        ]);

        Message::firstOrCreate([
            'sender_id' => $supervisor->id,
            'receiver_id' => $admin->id,
            'body' => 'Hola, acabo de aprobar las horas de la nómina de esta quincena.',
        ], [
            'subject' => 'Ticket #1002',
            'is_read' => true,
            'allow_reply' => true,
        ]);
    }
}