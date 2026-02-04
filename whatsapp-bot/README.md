# Zhafira CRM - WhatsApp Bot

Bot otomatis untuk menangkap lead dari WhatsApp Web dan mengirimkannya ke CRM.

## Instalasi

```bash
cd whatsapp-bot
npm install
cp .env.example .env
```

## Menjalankan Bot

```bash
npm start
```

## Cara Pakai

1. Jalankan bot dengan `npm start`
2. Scan QR code yang muncul dengan WhatsApp di HP
3. Bot akan otomatis menangkap pesan masuk dan kirim ke CRM

## Konfigurasi (.env)

| Variable | Default | Deskripsi |
|----------|---------|-----------|
| `CRM_API_URL` | `https://crm.zhafiravila.com/api` | URL API CRM |
| `WEBHOOK_SECRET` | `zhafira-crm-2026` | Secret key |
| `AUTO_REPLY` | `false` | Aktifkan auto-reply |

## Troubleshooting

- **QR tidak muncul**: Coba terminal lain
- **Bot disconnect**: Pastikan HP online, bot auto-reconnect
- **Lead tidak masuk**: Cek WEBHOOK_SECRET sama dengan CRM
