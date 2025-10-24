#!/bin/bash
# =========================================
# Script de despliegue automático Laravel + Vite
# Autor: Adolfo Quinteros
# =========================================

# 🚀 1. Mensaje inicial
echo "========================================="
echo "🚀 Iniciando despliegue del sistema..."
echo "========================================="

# 🧭 2. Cambiar a la ruta del proyecto (ajusta si es necesario)
cd /var/www/html || exit

# 🪄 3. Obtener últimos cambios
echo "📥 Ejecutando git pull..."
git pull origin main

# ⚙️ 4. Actualizar dependencias PHP si corresponde
if [ -f composer.json ]; then
  echo "🧩 Actualizando dependencias PHP..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# 🧱 5. Actualizar dependencias Node si corresponde
if [ -f package.json ]; then
  echo "📦 Actualizando dependencias Node..."
  npm install
  echo "🏗️ Compilando assets con Vite..."
  npm run build
fi

# 🗄️ 6. Migraciones y caché Laravel
echo "🧰 Ejecutando tareas de Laravel..."
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 🔐 7. Permisos de almacenamiento y caché
echo "🧾 Ajustando permisos..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# ✅ 8. Finalización
echo "========================================="
echo "✅ Despliegue completado exitosamente."
echo "========================================="
