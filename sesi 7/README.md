# 📦 Tugas Sesi 7 - Dasar PHP, Form Input & Validasi (Tanpa Database)

Tugas ini berisi implementasi **Dasar PHP, Form Input Produk, dan Validasi Sederhana Server-Side** yang dikemas dengan antarmuka frontend modern, bersih, dan responsif.

---

## 📋 Cakupan Tugas

### 1. Dasar PHP
- **Deklarasi Variabel:** Menggunakan variabel PHP (`$nama`, `$harga`, `$kategori`, `$deskripsi`, `$errors`, `$submittedData`).
- **Operator:**
  - **Operator Penugasan / Assignment (`=`)** untuk inisialisasi dan pengisian nilai.
  - **Operator Logika (`&&`, `!`)** untuk pengecekan kondisi validasi berganda.
  - **Operator Perbandingan (`===`, `<`, `<=`)** untuk memeriksa request method dan batasan panjang string/nilai angka.
  - **Operator Aritmatika (`*`, `+`)** untuk menghitung simulasi PPN 11% dan total harga produk.
- **Penggunaan `if-else` & `elseif`:** Menyeleksi apakah form dikirim melalui metode POST, memvalidasi setiap kolom input, serta menentukan apakah data lolos validasi atau memiliki error.

---

### 2. Tugas Form Input
Form input dibuat untuk menambahkan produk baru dengan atribut:
- **Nama Produk** (`input[type="text"]`)
- **Harga Produk** (`input[type="number"]`) dengan prefix Rp
- **Kategori Produk** (`select dropdown`)
- **Deskripsi Produk** (`textarea`)

---

### 3. Tugas Validasi (Server-Side)
Validasi dijalankan di sisi server menggunakan PHP murni sebelum data diproses:
- **Nama Produk:** Wajib diisi (tidak boleh kosong) dan minimal 3 karakter.
- **Harga Produk:** Wajib diisi, harus berupa numerik (`is_numeric()`), dan bernilai positif (> 0).
- **Kategori:** Wajib dipilih salah satu opsi.
- **Deskripsi:** Wajib diisi dan minimal 10 karakter.
- **Sanitasi & Keamanan:** Menggunakan `trim()` untuk membuang spasi berlebih dan `htmlspecialchars()` untuk mencegah serangan XSS.

---

## 🗂️ Struktur File
```
sesi 7/
├── index.php    # Form input, pemrosesan logika PHP, validasi, dan preview hasil
├── style.css    # Styling CSS modern, kartu pratinjau, badge, dan layout responsif
└── README.md    # Dokumentasi lengkap tugas sesi 7
```

---

## 🚀 Cara Menjalankan

### Cara 1: Menggunakan Ekstensi VS Code "PHP Server" (Paling Praktis)
1. Pasang ekstensi **PHP Server** di VS Code / Cursor / IDE.
2. Klik kanan pada file `index.php` -> Pilih **"PHP Server: Serve project"**.
3. Browser akan otomatis terbuka di `http://localhost:3000/index.php` atau port serupa.

### Cara 2: Menggunakan XAMPP / Laragon
1. Salin atau arahkan folder `sesi 7` ke dalam direktori `htdocs` (untuk XAMPP) atau `www` (untuk Laragon):
   - Contoh: `C:\xampp\htdocs\sesi7\`
2. Buka control panel XAMPP dan nyalakan **Apache**.
3. Akses melalui browser: `http://localhost/sesi7/index.php`.

### Cara 3: Menggunakan PHP Built-in Server (Terminal)
Jika PHP sudah terpasang di PATH sistem:
```bash
cd "sesi 7"
php -S localhost:8000
```
Buka browser di `http://localhost:8000/index.php`.
