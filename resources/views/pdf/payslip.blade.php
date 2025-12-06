<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Nómina</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #315762; /* Tu color Primary */
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .company-info {
            text-align: right;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #315762;
            margin: 0;
        }
        .document-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            color: #444;
            margin: 0;
        }
        
        /* Secciones */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #315762;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            margin-top: 20px;
            text-transform: uppercase;
        }

        /* Tablas de Datos */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .data-table th, .data-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .data-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            color: #555;
        }
        
        /* Tabla de Desglose (Ingresos vs Deducciones) */
        .breakdown-table {
            width: 100%;
            margin-top: 10px;
        }
        .breakdown-col {
            width: 48%;
            vertical-align: top;
        }
        .spacer-col {
            width: 4%;
        }
        
        .amount {
            text-align: right;
            font-family: 'Courier New', monospace;
        }
        
        /* Totales */
        .total-row td {
            border-top: 2px solid #315762;
            font-weight: bold;
            font-size: 14px;
            padding-top: 10px;
        }
        .net-pay-box {
            background-color: #f0fdf4; /* Verde muy claro */
            border: 1px solid #10b981;
            padding: 15px;
            text-align: right;
            margin-top: 30px;
            border-radius: 5px;
        }
        .net-pay-label {
            font-size: 16px;
            font-weight: bold;
            color: #065f46;
        }
        .net-pay-amount {
            font-size: 28px;
            font-weight: bold;
            color: #047857;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- ENCABEZADO -->
        <div class="header">
            <table>
                <tr>
                    <td style="vertical-align: top;">
                        <!-- Aquí podrías poner una etiqueta <img> con tu logo base64 o url pública -->
                        <img src="img/rh_green.png" style="height: 60px;"> 
                        <h1 class="document-title">Recibo de Nómina</h1>
                        <p>Periodo: {{ \Carbon\Carbon::parse($payslip->pay_period_start)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($payslip->pay_period_end)->format('d/m/Y') }}</p>
                    </td>
                    <td class="company-info">
                        <h2 class="company-name">HR System Corp.</h2>
                        <p>Av. Principal Empresarial 123<br>Caracas, Venezuela<br>Rif: J-12345678-9</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- DATOS DEL EMPLEADO -->
        <div class="section-title">Información del Empleado</div>
        <table class="data-table">
            <tr>
                <th width="20%">Nombre:</th>
                <td width="30%">{{ $payslip->employee->name }}</td>
                <th width="20%">ID Empleado:</th>
                <td width="30%">{{ $payslip->employee->id }}</td>
            </tr>
            <tr>
                <th>Departamento:</th>
                <td>{{ $payslip->employee->position->department->name ?? 'General' }}</td>
                <th>Cargo:</th>
                <td>{{ $payslip->employee->position->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fecha Ingreso:</th>
                <td>{{ $payslip->employee->fecha_contratacion ? \Carbon\Carbon::parse($payslip->employee->fecha_contratacion)->format('d/m/Y') : '-' }}</td>
                <th>Email:</th>
                <td>{{ $payslip->employee->email }}</td>
            </tr>
        </table>

        <!-- DESGLOSE DE PAGOS -->
        <div class="section-title">Detalle del Pago</div>
        
        <table class="breakdown-table">
            <tr>
                <!-- COLUMNA DEVENGOS (INGRESOS) -->
                <td class="breakdown-col">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th colspan="2" style="background-color: #e0f2f1; color: #00695c;">INGRESOS (Devengos)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Salario Base</td>
                                <td class="amount">{{ number_format($payslip->base_salary, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Bonificaciones</td>
                                <td class="amount">{{ number_format($payslip->bonuses, 2) }}</td>
                            </tr>
                            <!-- Espacio relleno si no hay más conceptos -->
                            <tr><td colspan="2" style="height: 20px;"></td></tr>
                            <tr class="total-row">
                                <td>Total Ingresos</td>
                                <td class="amount">{{ number_format($payslip->base_salary + $payslip->bonuses, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <td class="spacer-col"></td>

                <!-- COLUMNA DEDUCCIONES -->
                <td class="breakdown-col">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th colspan="2" style="background-color: #ffebee; color: #c62828;">DEDUCCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Retenciones de Ley / Otros</td>
                                <td class="amount">{{ number_format($payslip->deductions, 2) }}</td>
                            </tr>
                            <!-- Espacio relleno -->
                            <tr><td colspan="2" style="height: 42px;"></td></tr> 
                            <tr class="total-row">
                                <td>Total Deducciones</td>
                                <td class="amount text-red">{{ number_format($payslip->deductions, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <!-- RESUMEN DE HORAS (Si aplica) -->
        @if($payslip->total_hours > 0)
            <div style="margin-top: 15px; font-size: 11px; color: #666;">
                <strong>Registro de Tiempo:</strong> Se han contabilizado un total de <strong>{{ $payslip->total_hours }} horas</strong> trabajadas en este periodo.
            </div>
        @endif

        <!-- NOTAS ADICIONALES -->
        @if($payslip->notes)
            <div style="margin-top: 20px; border: 1px dashed #ccc; padding: 10px; background-color: #fafafa;">
                <strong>Nota / Comentario:</strong><br>
                {{ $payslip->notes }}
            </div>
        @endif

        <!-- TOTAL NETO A PAGAR -->
        <div class="net-pay-box">
            <span class="net-pay-label">NETO A PAGAR:</span><br>
            <span class="net-pay-amount">USD {{ number_format($payslip->net_pay, 2) }}</span>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>Este documento es un comprobante de pago digital generado automáticamente por el sistema HR-System.</p>
            <p>Fecha de Generación: {{ now()->format('d/m/Y H:i A') }}</p>
        </div>
    </div>
</body>
</html>