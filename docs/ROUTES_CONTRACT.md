# Kontrak Route, Validasi, dan Format Respons
Dokumen ini acuan bersama untuk route, FormRequest, dan variabel view.
Update dokumen ini setiap kali ada perubahan route atau aturan validasi.

## 1. Daftar Route

### 1.1 Grup guest (middleware: `guest`)
| Method | URI              | Name             | Controller@action       |
|--------|------------------|------------------|-------------------------|
| GET    | /register        | register         | AuthController@showRegister |
| POST   | /register        | register.store   | AuthController@register |
| GET    | /login           | login            | AuthController@showLogin |
| POST   | /login           | login.store      | AuthController@login |

### 1.2 Grup auth (middleware: `auth`)
| Method | URI              | Name             | Controller@action       | Role       |
|--------|------------------|------------------|-------------------------|------------|
| POST   | /logout          | logout           | AuthController@logout   | -          |
| GET    | /dashboard       | dashboard        | DashboardController@index | staff, admin |
| GET    | /categories      | categories.index | CategoryController@index | staff, admin |
| GET    | /categories/create | categories.create | CategoryController@create | admin    |
| POST   | /categories      | categories.store | CategoryController@store | admin      |
| GET    | /categories/{category}/edit | categories.edit | CategoryController@edit | admin |
| PUT    | /categories/{category} | categories.update | CategoryController@update | admin |
| DELETE | /categories/{category} | categories.destroy | CategoryController@destroy | admin |
| GET    | /products        | products.index   | ProductController@index | staff, admin |
| GET    | /products/create | products.create  | ProductController@create | admin      |
| POST   | /products        | products.store   | ProductController@store | admin      |
| GET    | /products/{product} | products.show | ProductController@show | staff, admin |
| GET    | /products/{product}/edit | products.edit | ProductController@edit | admin   |
| PUT    | /products/{product} | products.update | ProductController@update | admin   |
| DELETE | /products/{product} | products.destroy | ProductController@destroy | admin |
| GET    | /transactions    | transactions.index | StockTransactionController@index | staff, admin |
| GET    | /transactions/create | transactions.create | StockTransactionController@create | staff, admin |
| POST   | /transactions    | transactions.store | StockTransactionController@store | staff, admin |
| GET    | /transactions/{transaction} | transactions.show | StockTransactionController@show | staff, admin |

### 1.3 Grup admin (middleware: `auth`, `role:admin`) — P2
| Method | URI              | Name             | Controller@action       |
|--------|------------------|------------------|-------------------------|
| GET    | /users           | users.index      | UserController@index    |
| PUT    | /users/{user}/role | users.updateRole | UserController@updateRole |

Catatan: route admin (create/edit/update/destroy) untuk kategori dan produk
didaftarkan SEBELUM route resource index supaya tidak tertangkap `{category}`.

## 2. FormRequest

### 2.1 RegisterRequest
| Field    | Aturan                                  | Pesan (ID)                                  |
|----------|-----------------------------------------|---------------------------------------------|
| name     | required, string, max:255               | Nama wajib diisi, maksimal 255 karakter.    |
| email    | required, email, unique:users,email     | Email wajib diisi dan harus unik.           |
| password | required, string, min:8, confirmed      | Password minimal 8 karakter dan harus cocok.|

### 2.2 LoginRequest
| Field    | Aturan                                  | Pesan (ID)                                  |
|----------|-----------------------------------------|---------------------------------------------|
| email    | required, email                         | Email wajib diisi.                          |
| password | required, string                        | Password wajib diisi.                       |

### 2.3 CategoryRequest
| Field       | Aturan                                  | Pesan (ID)                                  |
|-------------|-----------------------------------------|---------------------------------------------|
| name        | required, string, max:255, unique:categories,name (abaikan saat edit) | Nama kategori wajib diisi dan harus unik. |
| description | nullable, string, max:1000              | Deskripsi maksimal 1000 karakter.           |

### 2.4 ProductRequest
| Field       | Aturan                                  | Pesan (ID)                                  |
|-------------|-----------------------------------------|---------------------------------------------|
| category_id | required, exists:categories,id          | Kategori wajib dipilih.                     |
| sku         | required, string, max:100, unique:products,sku (abaikan saat edit) | SKU wajib diisi dan harus unik. |
| name        | required, string, max:255               | Nama produk wajib diisi.                    |
| description | nullable, string, max:2000              | Deskripsi maksimal 2000 karakter.           |
| unit        | required, string, max:50                | Satuan wajib diisi.                         |
| price       | required, numeric, min:0                | Harga harus angka positif.                  |
| min_stock   | required, integer, min:0                | Stok minimum harus angka bulat ≥ 0.         |

Catatan: `stock` TIDAK ada di form. Stok hanya berubah lewat transaksi (BR-01).

### 2.5 StoreStockTransactionRequest
| Field            | Aturan                                  | Pesan (ID)                                  |
|------------------|-----------------------------------------|---------------------------------------------|
| product_id       | required, exists:products,id            | Produk wajib dipilih.                       |
| type             | required, in:in,out                     | Jenis transaksi harus masuk atau keluar.    |
| quantity         | required, integer, min:1                | Jumlah minimal 1.                           |
| transaction_date | required, date                          | Tanggal transaksi wajib diisi.              |
| note             | nullable, string, max:500               | Catatan maksimal 500 karakter.              |

Catatan: `user_id` diisi server dari `auth()->id()`, tidak dari request.

## 3. Variabel yang dikirim ke view

### 3.1 dashboard.index
- `totalProducts` (int)
- `totalCategories` (int)
- `lowStockCount` (int) — produk dengan `stock <= min_stock`
- `todayTransactions` (int) — transaksi hari ini
- `lowStockProducts` (Collection, max 5, eager load `category`)
- `latestTransactions` (Collection, max 5, eager load `product`, `user`)

### 3.2 categories.index
- `categories` (Collection)

### 3.3 products.index
- `products` (LengthAwarePaginator, 10 per halaman, eager load `category`)
- `categories` (Collection, untuk dropdown filter)
- `q` (string|null)
- `categoryId` (int|null)

### 3.4 transactions.index
- `transactions` (LengthAwarePaginator, 15 per halaman, eager load `product`, `user`)
- `products` (Collection, untuk dropdown filter)
- `type`, `productId`, `dateFrom`, `dateTo` (untuk mempertahankan filter)

## 4. Format flash message
- Sukses: `session()->flash('success', '...')`
- Gagal: `session()->flash('error', '...')`

## 5. Contoh query (acuan implementasi)

### 5.1 Produk dengan filter dan paginasi
```php
Product::with('category')
    ->when($q, fn($query) => $query->where(function($q2) use ($q) {
        $q2->where('name', 'like', "%{$q}%")
           ->orWhere('sku', 'like', "%{$q}%");
    }))
    ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
    ->latest()
    ->paginate(10)
    ->withQueryString();