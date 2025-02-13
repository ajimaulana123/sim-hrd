#!/bin/bash

echo "🚀 Memulai setup Laravel project..."

# Install dependencies dengan Composer
echo "📦 Menjalankan composer install..."
composer install

# Salin file .env
echo "⚙️ Menyalin .env.example ke .env..."
cp .env.example .env

# Install dependencies frontend (coba cari yang tersedia)
echo "📦 Install dependencies frontend..."
if command -v yarn &> /dev/null
then
    yarn
elif command -v npm &> /dev/null
then
    npm install
elif command -v pnpm &> /dev/null
then
    pnpm install
else
    echo "⚠️ Tidak ada yarn, npm, atau pnpm. Install salah satu dulu!"
    exit 1
fi

# Generate application key
echo "🔑 Generate application key..."
php artisan key:generate

# Jalankan migrasi database
echo "📂 Menjalankan migrasi database..."
php artisan migrate

# Jalankan seeder database
echo "🌱 Menjalankan seeder database..."
php artisan db:seed

# Build frontend
echo "🛠️ Membuild frontend..."
yarn build || npm run build || pnpm build

# Jalankan server
echo "🚀 Menjalankan Laravel server..."
php artisan serve
