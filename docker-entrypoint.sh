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

# 5. Configurar puertos para Render
# Si Render asigna un puerto en $PORT, hacemos que Apache escuche en ese puerto
if [ -n "$PORT" ] && [ "$PORT" != "80" ]; then
    echo "Listen $PORT" >> /etc/apache2/ports.conf
fi

# Hacer que el VirtualHost acepte cualquier puerto en el que escuche Apache
sed -i 's/<VirtualHost \*:80>/<VirtualHost *:*>/g' /etc/apache2/sites-available/*.conf 2>/dev/null || true

echo "Comprobando sintaxis de Apache..."
apache2ctl -t || true

echo "Laravel listo. Iniciando Apache en primer plano..."

# Arrancar Apache
exec apache2-foreground
