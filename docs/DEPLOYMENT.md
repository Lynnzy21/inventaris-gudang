# Panduan Deployment (Production)

Dokumen ini berisi langkah-langkah untuk menyiapkan dan men-deploy aplikasi Sistem Inventaris Gudang ke hosting publik (contoh: Railway).

## 1. Environment Variables
Di dashboard hosting, tambahkan environment variables berikut. **Jangan** meng-commit file `.env` yang berisi nilai asli.

| Variabel | Nilai yang Disarankan | Keterangan |
| --- | --- | --- |
| `APP_NAME` | "Inventaris Gudang" | Nama aplikasi |
| `APP_ENV` | `production` | Wajib production di server |
| `APP_KEY` | `base64:xxxxx...` | Generate lokal via `php artisan key:generate --show` |
| `APP_DEBUG` | `false` | **Wajib false** di production untuk keamanan |
| `APP_URL` | `https://domain-kamu.railway.app` | URL publik aplikasi (harus pakai https) |
| `DB_CONNECTION` | `mysql` | - |
| `DB_HOST` | (Host dari hosting) | Biasanya disediakan otomatis |
| `DB_PORT` | `3306` | - |
| `DB_DATABASE` | (Nama DB dari hosting) | - |
| `DB_USERNAME` | (User dari hosting) | - |
| `DB_PASSWORD` | (Password dari hosting) | - |
| `SESSION_DRIVER` | `database` | Menggunakan tabel sessions di database |

## 2. Build Asset (Tailwind & Vite)
Karena aplikasi menggunakan Vite untuk meng-compile Tailwind CSS, jalankan perintah ini di server (atau di pipeline CI/CD) sebelum aplikasi live:

```bash
npm ci
npm run build


Catatan: Jika build di server gagal karena keterbatasan memori, jalankan npm run build di komputer lokal, lalu commit folder public/build ke repository (pastikan public/build dihapus dari .gitignore).