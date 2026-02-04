# Deployment Guide - Zhafira CRM ke Hostinger

## Domain: crm.zhafiravila.com

---

## LANGKAH 1: Setup Subdomain di Hostinger

1. Login ke **hPanel Hostinger**
2. Pergi ke **Domains** > **Subdomains**
3. Buat subdomain: `crm.zhafiravila.com`
4. Catat **Document Root** (biasanya: `/public_html/crm` atau `/domains/crm.zhafiravila.com/public_html`)

---

## LANGKAH 2: Upload Files

### Opsi A: Via File Manager (Mudah)
1. Zip semua file project (kecuali folder `vendor` dan `node_modules`)
2. Upload zip ke document root subdomain
3. Extract di Hostinger

### Opsi B: Via Git (Recommended)
1. Di Hostinger, buka **Advanced** > **Git**
2. Clone dari repository

---

## LANGKAH 3: Setup Database

1. Di hPanel, pergi ke **Databases** > **MySQL Databases**
2. Database sudah ada: `u861895257_crm`
3. Catat:
   - Database name: `u861895257_crm`
   - Username: `u861895257_crm` (atau sesuai yang dibuat)
   - Password: (password database Anda)

---

## LANGKAH 4: Install Dependencies via SSH

1. Di hPanel, aktifkan **SSH Access**
2. Connect via SSH atau gunakan **Terminal** di hPanel
3. Jalankan:

```bash
cd domains/crm.zhafiravila.com/public_html
# atau sesuaikan dengan document root Anda

# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Copy dan edit .env
cp .env.production .env
nano .env
# Edit DB_PASSWORD sesuai password database Anda

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 755 storage bootstrap/cache
```

---

## LANGKAH 5: Konfigurasi .htaccess

Buat file `.htaccess` di root folder (bukan di public):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Atau jika Hostinger support, arahkan Document Root langsung ke folder `public`.

---

## LANGKAH 6: Update Google Apps Script

Setelah website live, update URL webhook di Google Sheets:

```javascript
const WEBHOOK_URL = 'https://crm.zhafiravila.com/api/webhook/google-sheets';
```

---

## LANGKAH 7: Test

1. Buka https://crm.zhafiravila.com
2. Login dengan: admin / admin123
3. Test tambah data di Google Sheets
4. Cek apakah data masuk ke CRM

---

## Credentials Default

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Marketing | marketing1 | marketing123 |
| Marketing | marketing2 | marketing123 |
| Marketing | marketing3 | marketing123 |

---

## Troubleshooting

### Error 500
- Cek permissions: `chmod -R 755 storage bootstrap/cache`
- Cek `.env` sudah benar
- Cek `php artisan config:cache`

### Database Error
- Pastikan credentials database benar di `.env`
- Jalankan `php artisan migrate`

### Webhook Tidak Jalan
- Pastikan URL sudah HTTPS
- Cek secret key sama di Apps Script dan `.env`
