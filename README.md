# 📚 Eduwork Fullstack Web Development — Pertemuan 1

Dokumentasi lengkap seluruh materi, tugas, dan proyek pembelajaran dari **Sesi 1 hingga Sesi 22** pada program Fullstack Web Development Eduwork.

---

## 🛠️ Tech Stack & Ekosistem

- **Backend:** PHP 8.3, Laravel 11.x, Eloquent ORM, Laravel Breeze
- **Frontend:** Blade Templating, Tailwind CSS, Alpine.js, Vite
- **Database:** MySQL 8.x (dikelola via Laragon)
- **Local Server:** Laragon (Apache 2.4 & PHP 8.3)
- **Tooling:** Composer, NPM, Artisan CLI, Git

---

## 📁 Struktur Direktori

```
Pertemuan 1/
├── README.md                 # Dokumentasi master seluruh sesi (Sesi 1 - 22)
├── sesi 1/ - sesi 3/         # Fundamental HTML (Struktur, Tag Semantik, Form, Tabel)
├── sesi 4/ - sesi 6/         # Fundamental CSS & Layout (Box Model, Flexbox, Responsive)
├── sesi 7/ - sesi 9/         # Pemrograman PHP Native (Logika, Fungsi, Array, Form Handling)
├── sesi 10/ - sesi 14/       # OOP PHP, Desain Database MySQL, & Pengenalan Arsitektur MVC
├── sesi 15/                  # Inisialisasi Laravel, Model Product, Relasi & Pagination
├── sesi 16/                  # Blade Components, Form Tambah Produk & CRUD Dasar
├── sesi 17/                  # Validasi Input Formulir & Penanganan Error Interaktif
├── sesi 18/                  # Dashboard Admin: Metrik Produk, Kategori & Total Klik
├── sesi 19/                  # Role User & Admin (Migrasi Role, Middleware Admin 403)
├── sesi 20/                  # Integrasi View via HomeController (Kategori & Produk Dinamis)
├── sesi 21/                  # Form Tambah Produk & Kategori (Route product.store & product-category.store)
└── sesi 22/                  # Fitur Lengkap Edit & Hapus (PUT/DELETE, Validasi, Dialog Konfirmasi)
```

> **Catatan Proyek Aktif:** Proyek aplikasi web aktif dijalankan dan dikembangkan langsung pada root Laragon di **`C:\laragon\www\myapp`**.

---

## 📖 Rangkuman Kurikulum & Progres Tugas (Sesi 1 — 22)

### 🔹 Modul 1: Web Fundamental & Styling (Sesi 1 – 6)
- **Sesi 1 – 3 (HTML Dasar & Semantik):**
  - Pembuatan dokumen HTML berstandar W3C.
  - Implementasi tag heading, paragraf, list, navigasi, tabel, multimedia (gambar/audio), serta formulir input (text, email, password, radio, checkbox, submit).
- **Sesi 4 – 6 (CSS Dasar & Tata Letak):**
  - Selektor CSS, CSS Box Model (*margin, padding, border, content*).
  - Tata letak modern menggunakan **Flexbox** (*justify-content, align-items, flex-direction*).
  - Desain web responsif dengan *media queries* untuk berbagai ukuran layar (mobile, tablet, desktop).

---

### 🔹 Modul 2: Fundamental PHP Native (Sesi 7 – 9)
- **Sesi 7:** Variabel, tipe data, operator aritmatika dan logika dalam PHP native.
- **Sesi 8:** Struktur kendali percabangan (*if-else, switch-case*) dan perulangan (*for, while, foreach*).
- **Sesi 9:** Pembuatan fungsi kustom (*user-defined functions*), manipulasi array (indeks & asosiatif), serta pemrosesan data formulir dengan metode `$_GET` dan `$_POST`.

---

### 🔹 Modul 3: OOP, Database & Pengenalan Laravel (Sesi 10 – 14)
- **Sesi 10 – 11:** Pemrograman Berorientasi Objek (OOP) PHP — pembuatan class, object, constructor, visibility (*public, protected, private*), dan inheritance.
- **Sesi 12 – 13:** Perancangan basis data relasional MySQL, pembuatan tabel (*DDL/DML*), primary & foreign keys, normalisasi data, serta relasi *One-to-Many*.
- **Sesi 14:** Konsep arsitektur **Model-View-Controller (MVC)** dan instalasi framework Laravel.

---

### 🔹 Modul 4: Pengembangan Aplikasi E-Commerce "EduShop" (Sesi 15 – 22)

#### 🛒 Sesi 15: Setup Model, Relasi Eloquent & Katalog Produk
- Membuat Model **`Product`** dan **`ProductCategory`** yang terhubung ke tabel `products` dan `categories`.
- Mengatur relasi Eloquent:
  - `Product belongsTo ProductCategory` (via `category_id`)
  - `ProductCategory hasMany Product`
- Menampilkan data produk menggunakan controller dengan fitur **Pagination** (`Product::with('productCategory')->paginate(8)`).
- Membuat scope pencarian dan filter kategori (`scopeByCategory`).

#### 📝 Sesi 16: Form Tambah Produk & Blade Components
- Membangun antarmuka formulir tambah produk menggunakan template engine Blade.
- Menyediakan dropdown kategori produk secara dinamis dari database.
- Menyusun layout antarmuka modern dengan Tailwind CSS.

#### 🛡️ Sesi 17: Validasi Data & Penanganan Error Formulir
- Menerapkan validasi backend di controller (`required`, `numeric`, `min`, `max`, `url`).
- Menampilkan pesan error validasi spesifik di bawah tiap field input menggunakan directive Blade `@error` / `<x-input-error>`.
- Menjaga data input yang telah diketik tidak hilang saat terjadi kesalahan validasi dengan fungsi helper `old()`.
- Menyertakan notifikasi *flash message* sukses saat data berhasil disimpan.

#### 📊 Sesi 18: Dashboard Admin & Pelacakan Klik Produk
- Menambahkan kolom **`clicks`** pada tabel `products` untuk mencatat jumlah interaksi pengunjung.
- Mengimplementasikan pencatatan otomatis klik setiap kali halaman detail produk dibuka (`$product->increment('clicks')`).
- Membangun halaman **Dashboard Admin** yang menampilkan statistik utama toko:
  - Jumlah total produk
  - Jumlah kategori produk
  - Jumlah akumulasi klik seluruh produk

#### 🔐 Sesi 19: Role Pengguna & Middleware Admin
- Menambahkan kolom **`role`** pada tabel `users` via migrasi (`enum('admin', 'user')`, default: `'user'`).
- Membuat custom middleware **`AdminMiddleware`** (`app/Http/Middleware/AdminMiddleware.php`) untuk memeriksa apakah user yang login memiliki role `'admin'`.
- Menerapkan middleware pada route administratif:
  ```php
  Route::middleware(['auth', 'admin'])->group(function () {
      Route::get('/dashboard', [DashboardController::class, 'index']);
      Route::resource('categories', CategoryController::class);
      // Route CRUD admin lainnya...
  });
  ```
- Mengembalikan respon **HTTP 403 (Akses Ditolak)** secara aman apabila pengguna biasa mencoba mengakses halaman khusus admin.
- Memperbarui sistem keranjang belanja dengan persistensi database (`cart_items`) agar keranjang tidak hilang saat user logout dan login kembali.

#### 🌐 Sesi 20: Integrasi Controller ke View Beranda
- Menghubungkan halaman utama (`/`) ke **`HomeController@index`**.
- Mengambil dan mengirim data dinamis ke view `welcome.blade.php`:
  - Kategori produk terpopuler dengan jumlah produknya (`Category::withCount('products')`).
  - Produk unggulan & terbaru beserta badge kategori dan harga terformat Rupiah.
  - Produk paling sering dilihat berdasarkan statistik klik.
- Melengkapi navbar dengan icon keranjang belanja dan *live item counter* realtime.

#### ➕ Sesi 21: Form Tambah Produk & Kategori dengan Route Khusus
- Membuat **`ProductCategoryController`** dan memperbarui **`ProductController`**:
  - `ProductCategoryController@create` &rarr; menampilkan form tambah kategori.
  - `ProductCategoryController@store` &rarr; memvalidasi input nama kategori unik dan menyimpan ke database.
  - `ProductController@create` &rarr; menampilkan form tambah produk.
  - `ProductController@store` &rarr; memvalidasi input produk, mengaitkan relasi kategori, dan menyimpan ke database.
- Menyesuaikan action formulir pada Blade:
  - Formulir kategori mengarah ke: **`route('product-category.store')`** (Method: `POST`).
  - Formulir produk mengarah ke: **`route('product.store')`** (Method: `POST`).

#### ✏️ Sesi 22: Fitur Lengkap Edit & Hapus (Produk & Kategori)
- **Fungsi Menampilkan Edit (`edit`):**
  - `ProductCategoryController@edit($id)` &rarr; menampilkan view edit kategori dengan data awal.
  - `ProductController@edit($id)` &rarr; menampilkan view edit produk dengan data awal dan opsi kategori.
- **Penyesuaian Formulir Edit:**
  - Menerapkan *method spoofing* HTTP via `@method('PUT')`.
  - Mengisi formulir secara otomatis menggunakan `old('field', $model->field)`.
- **Fungsi Update & Validasi (`update`):**
  - Memvalidasi perubahan data (mengecualikan ID kategori/produk saat ini pada aturan `unique`).
  - Menyimpan perubahan ke database via `$model->update($validated)`.
- **Fitur Hapus Berdasarkan ID (`destroy`):**
  - `ProductCategoryController@destroy($id)` &rarr; melepaskan relasi produk agar aman dari foreign key constraint, lalu menghapus kategori.
  - `ProductController@destroy($id)` &rarr; menghapus data produk dari katalog dan database.
  - Dilengkapi dialog konfirmasi JavaScript (`onsubmit="return confirm('...');"`) dan form `@method('DELETE')`.
  - Hak akses edit dan hapus dilindungi khusus untuk Admin.

---

## 🔑 Kredensial Pengujian Akun

Untuk menguji fitur autentikasi, middleware, dashboard admin, dan aksi CRUD:

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@edushop.com` | `password123` | Akses penuh ke Dashboard Admin, Tambah, Edit, dan Hapus Produk & Kategori |
| **User Biasa** | `budi@example.com` | `password123` | Belanja, lihat katalog, masukkan produk ke keranjang belanja (tombol edit/hapus disembunyikan) |
| **Guest / Publik** | *(Tanpa Login)* | *(Tanpa Login)* | Menjelajahi katalog produk, melihat kategori, dan belanja dengan keranjang sesi |

---

## 🚀 Panduan Menjalankan Proyek di Laragon

1. **Jalankan Laragon:**
   - Buka aplikasi Laragon, lalu klik **"Start All"** (memastikan Apache dan MySQL aktif pada port default).

2. **Buka Terminal di Folder Project:**
   ```bash
   cd C:\laragon\www\myapp
   ```

3. **Migrasi & Seeding Database (Jika Diperlukan):**
   ```bash
   php artisan migrate --seed
   ```

4. **Kompilasi Aset Frontend (Vite & Tailwind CSS):**
   ```bash
   npm run build
   ```

5. **Akses Aplikasi di Browser:**
   - URL Virtual Host: **`http://myapp.test`**
   - Atau via localhost: **`http://127.0.0.1:8000`** (jalankan `php artisan serve`)

