#!/bin/bash
set -e

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

echo "Laravel listo. Iniciando Apache en el puerto ${PORT:-80}..."

# Ajustar puerto dinámico de Render si viene especificado en la variable $PORT
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf
fi

# Arrancar Apache
exec apache2-foreground
