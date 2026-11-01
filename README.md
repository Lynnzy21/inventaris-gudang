# Sistem Manajemen Inventaris Gudang

Aplikasi web server-side berbasis Laravel untuk mencatat barang, kategori, dan keluar-masuk stok di gudang. Aplikasi ini dirancang untuk memastikan stok barang selalu sinkron dengan riwayat transaksi, dengan pembatasan akses berdasarkan peran (admin dan staff).

## Fitur Utama

- **Autentikasi Manual**: Registrasi, login, dan logout dengan proteksi CSRF dan throttle (5 percobaan/menit).
- **Kontrol Akses**: Pembagian peran (admin dan staff) dengan middleware kustom (`EnsureUserHasRole`).
- **Dashboard**: Ringkasan total produk, kategori, stok menipis, dan transaksi terkini.
- **CRUD Kategori & Produk**: Manajemen data master dengan validasi server-side, pencarian, filter, dan paginasi.
- **Transaksi Stok**: Pencatatan stok masuk/keluar yang aman menggunakan database transaction dan row lock (`lockForUpdate`) untuk mencegah race condition.
- **Riwayat Transaksi**: Filter berdasarkan jenis, produk, dan rentang tanggal.

## Stack Teknologi

- **Backend**: PHP 8.2+, Laravel 11.x
- **Database**: MySQL
- **Frontend**: Blade Templates, Tailwind CSS, Vite
- **Testing**: PHPUnit (Feature Tests)

## Instalasi Lokal

1. **Clone repository**
    ```bash
    git clone <url-repository-anda>
    cd inventaris-gudang
    ```

## Struktur Direktori (Bagian Utama)

... app/
Http/
Controllers/ # Logika aplikasi (Auth, Dashboard, Category, Product, Transaction)
Middleware/ # EnsureUserHasRole (kontrol akses)
Requests/ # Validasi form (Register, Login, Category, Product, Transaction)
Models/ # Eloquent models (User, Category, Product, StockTransaction)
database/
migrations/ # Skema database
seeders/ # Data demo
resources/views/ # Template Blade (layouts, partials, components, pages)
routes/
web.php # Definisi route aplikasi
docs/ # Dokumentasi (PRD, ROUTES_CONTRACT)

## Keamanan
...
Semua form dilindungi oleh @csrf.
Output data di Blade menggunakan {{ }} untuk mencegah XSS.
Query database menggunakan Eloquent ORM untuk mencegah SQL Injection.
Kolom role dan stock tidak dapat diisi langsung melalui request (mass assignment protection).
