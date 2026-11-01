# Instruksi untuk Copilot: Sistem Inventaris Gudang

Simpan file ini di `.github/copilot-instructions.md` (buat foldernya jika belum ada). Copilot membacanya otomatis sebagai konteks repository.

## Konteks proyek

Ini tugas UAS mata kuliah Web Application Development yang dikerjakan individu. Pemilik repo harus bisa menjelaskan setiap baris kode, jadi kode harus sederhana, eksplisit, dan mengikuti konvensi standar Laravel. Dokumen acuan:

- `docs/PRD.md` untuk fitur, aturan bisnis, skema database, dan hak akses
- `docs/ROUTES_CONTRACT.md` untuk route, validasi, dan format respons

Jika ada konflik antara permintaan di chat dan dokumen di atas, hentikan dan tanyakan dulu. Jangan menebak.

## Stack

- PHP 8.2+, Laravel (versi stabil terbaru), MySQL
- Blade untuk view, tampilan memakai Tailwind CSS yang di-build dengan Vite (bawaan Laravel). Layout memuat asset dengan `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
- Tidak memakai Livewire, Inertia, Alpine, atau framework JS. Interaksi kecil (buka-tutup sidebar di layar kecil) ditulis dengan JavaScript biasa di `resources/js/app.js`.

## Larangan keras

- Jangan memasang package selain yang sudah ada di Laravel default. Jangan menjalankan `composer require` atau `npm install <paket>` tanpa izin. Pengecualian: paket Tailwind CSS untuk Vite (`tailwindcss`, `@tailwindcss/vite`) jika belum terpasang.
- Jangan memakai atau meniru starter kit dan generator: Breeze, Jetstream, Fortify, Filament, Voyager, `make:auth`, CRUD generator, dan sejenisnya. Autentikasi ditulis manual dengan facade `Auth`.
- Jangan mengubah skema database atau aturan hak akses tanpa memperbarui `docs/PRD.md` di commit yang sama.
- Jangan menulis `{!! !!}` pada data yang berasal dari user.
- Jangan membuat REST API atau route JSON. Aplikasi ini server-rendered.

## Konvensi kode

- Nama kelas, method, variabel, dan tabel dalam bahasa Inggris. Label UI, pesan error, dan komentar dalam bahasa Indonesia.
- Komentar singkat (satu atau dua baris) menjelaskan **mengapa** di tempat yang logikanya tidak jelas: middleware, transaksi database, query relasi, dan pengecekan keamanan. Jangan mengomentari hal yang sudah jelas dari kodenya.
- Controller tipis. Validasi di `FormRequest`. Query lewat Eloquent atau Query Builder dengan binding. Tidak ada string concatenation di query, tidak ada `DB::raw` yang memuat input user.
- Setiap model punya `$fillable` eksplisit. Jangan memakai `$guarded = []`.
- Gunakan route model binding dan nama route sesuai kontrak (`products.index`, dst.).
- Gunakan eager loading (`with`) pada daftar yang menampilkan relasi, untuk menghindari N+1.
- Pesan flash memakai kunci `success` dan `error`.

## Aturan keamanan (checklist setiap fitur)

1. Setiap form POST/PUT/PATCH/DELETE memuat `@csrf` dan `@method` bila perlu.
2. Output di Blade memakai `{{ }}`.
3. Input divalidasi di server lewat `FormRequest`. Kolom `role` dan `stock` tidak pernah diisi dari request.
4. Route dilindungi middleware `auth`, `guest`, atau `role:admin` sesuai tabel di kontrak.
5. Password di-hash (cast `hashed` atau `Hash::make`). Saat login panggil `session()->regenerate()`. Saat logout panggil `invalidate()` dan `regenerateToken()`.
6. Pesan error login bersifat umum.

## Struktur UI (Tailwind)

Arah desain: bersih, modern, dan profesional, gaya dashboard admin. Spasi lega, tipografi konsisten (font sans bawaan Tailwind), hierarki jelas (judul halaman, subjudul abu), efek hover dan focus pada tombol, input, dan baris tabel, serta tampilan kosong ("Belum ada data") pada tabel yang tidak berisi. Warna utama indigo (`indigo-600`), latar halaman `slate-50`, kartu putih dengan `rounded-xl` dan `shadow-sm`, teks `slate-700`.

- `layouts/app.blade.php`: sidebar tetap di kiri (tersembunyi di layar kecil, bisa dibuka dengan tombol), topbar dengan nama user dan tombol logout, area konten dengan judul halaman.
- `layouts/auth.blade.php`: kartu login atau register di tengah layar.
- Partial: `partials/sidebar`, `partials/navbar`, `partials/flash` (alert hijau untuk `success`, merah untuk `error`).
- Komponen yang dipakai ulang lewat Blade component atau `@include`: kartu statistik, tabel, badge, tombol, input form beserta pesan error. Jangan menyalin markup yang sama di banyak view.
- Tabel: bungkus dengan `overflow-x-auto` supaya aman di layar kecil. Badge: transaksi masuk hijau, keluar merah, stok menipis kuning atau merah.
- Form: label di atas input, pesan error validasi merah di bawah input terkait, nilai lama lewat `old()`.
- Sidebar menampilkan menu admin hanya untuk role admin (`auth()->user()->role === 'admin'`).
- Ikon: SVG inline sederhana seperlunya. Jangan menambah library ikon atau font eksternal selain yang diminta.
- Kelas Tailwind ditulis langsung di markup. Selain `resources/css/app.css` (import Tailwind dan pengaturan tema), jangan membuat file CSS besar sendiri.

## Cara kerja

- Kerjakan **satu fase** per permintaan. Setelah selesai, berhenti.
- Di akhir tiap fase tuliskan: daftar file yang dibuat atau diubah, tujuan tiap file dalam satu kalimat, dan perintah untuk memverifikasi (`php artisan migrate:fresh --seed`, `php artisan route:list`, `php artisan test`).
- Jika ada pilihan desain yang berpengaruh pada esai (misalnya letak logika), jelaskan pilihan dan alasannya dalam dua kalimat.
- Jika perintah gagal, tampilkan pesan error apa adanya. Jangan menyembunyikan atau mengakali error.
- Jangan melakukan `git commit`. Pemilik repo membuat commit sendiri tiap fase.
