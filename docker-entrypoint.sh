#!/bin/bash
set -e

# Crear enlace simbólico de storage
php artisan storage:link --force || true

# Ejecutar migraciones si la base de datos está configurada
if [ -n "$DB_HOST" ]; then
    echo "Ejecutando migraciones de base de datos..."
    php artisan migrate --force || true
fi

# Optimizar cachés de Laravel para producción
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
