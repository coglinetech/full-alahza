#!/bin/bash

echo "Memulai proses update Laravel..."

# Pull dari branch main (sesuaikan jika branch kamu bukan main)
echo "Menarik kode terbaru dari GitHub..."
git pull origin master

# Build frontend assets (Node.js harus tersedia di hosting)
echo "Building frontend assets..."
if command -v npm &> /dev/null; then
    npm run build
    echo "Frontend build selesai."
else
    echo "PERINGATAN: npm tidak ditemukan, skip npm run build. Upload folder public/build/ secara manual."
fi

# Update dependencies (opsional, hapus tanda # jika ingin dijalankan)
# composer install --no-dev --optimize-autoloader

# Jalankan migrasi database
echo "Menjalankan migrasi database..."
php artisan migrate

# Membersihkan semua cache
echo "Membersihkan semua cache..."
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Optimalisasi kembali (opsional, bagus untuk performa di hosting)
echo "Mengoptimalkan aplikasi..."
php artisan optimize

echo "Update selesai! Aplikasi sudah versi terbaru."