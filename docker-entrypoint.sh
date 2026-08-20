#!/bin/bash

# 1. Crear enlace simbólico de storage
php artisan storage:link --force || true

# 2. Ejecutar migraciones de base de datos
echo "Ejecutando migraciones de base de datos..."
php artisan migrate --force || true

# 3. Ejecutar seeders iniciales (crear admin, departamentos, empleados)
echo "Ejecutando sembrado de datos iniciales (Seeders)..."
php artisan db:seed --force || true

# 4. Optimizar cachés de Laravel para producción
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# 5. Configurar puertos para Render (soporta tanto Port 80 como $PORT dinámico)
if [ -n "$PORT" ] && [ "$PORT" != "80" ]; then
    echo "Listen $PORT" >> /etc/apache2/ports.conf 2>/dev/null || true
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT *:80>/g" /etc/apache2/sites-available/*.conf 2>/dev/null || true
fi

echo "Laravel listo. Iniciando servidor Apache..."

# Arrancar Apache siempre
exec apache2-foreground
