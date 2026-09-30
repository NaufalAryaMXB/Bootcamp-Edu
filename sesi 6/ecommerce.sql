-- ==========================================================
-- TUGAS SESI 6 - EDUWORK
-- Database E-Commerce MySQL & Query CRUD
-- ==========================================================

-- ----------------------------------------------------------
-- 1. PEMBUATAN DATABASE
-- ----------------------------------------------------------
CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

-- ----------------------------------------------------------
-- 2. PEMBUATAN TABEL-TABEL
-- ----------------------------------------------------------

-- a. Tabel USERS: Menyimpan data pengguna
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- b. Tabel PRODUCTS: Menyimpan data produk
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(12, 2) NOT NULL CHECK (price >= 0),
    description TEXT,
    stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- c. Tabel ORDERS: Menyimpan data pesanan relasi antara users dan products
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    total DECIMAL(14, 2) NOT NULL CHECK (total >= 0),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ==========================================================
-- 3. SEEDING / DATA AWAL (SAMPLE DATA)
-- ==========================================================

-- Data Pengguna
INSERT INTO users (name, email, password) VALUES
('Budi Santoso', 'budi.santoso@example.com', 'password123'),
('Siti Rahma', 'siti.rahma@example.com', 'rahma_secure#45'),
('Ahmad Fauzi', 'ahmad.fauzi@example.com', 'fauziPass2026');

-- Data Produk
INSERT INTO products (name, price, description, stock) VALUES
('Mechanical Keyboard Wireless RGB', 850000.00, 'Keyboard mekanikal 75% layout dengan koneksi 3-mode (Bluetooth, 2.4G, Type-C) dan hot-swappable switches.', 25),
('Smartwatch Ultra Pro AMOLED', 1250000.00, 'Jam tangan pintar dengan layar Always-On AMOLED, sensor detak jantung 24/7, SpO2, dan baterai tahan 14 hari.', 15),
('Wireless Noise-Cancelling Headphones', 1799000.00, 'Headphone over-ear dengan Active Noise Cancelling (ANC) tingkat tinggi dan kualitas audio Hi-Res lossless.', 10),
('Ergonomic Wireless Gaming Mouse', 450000.00, 'Mouse nirkabel presisi tinggi dengan sensor optik 16000 DPI, ultra-lightweight, dan tombol makro terprogram.', 40),
('True Wireless Earbuds ANC', 699000.00, 'TWS dengan driver dinamis 10mm, ketahanan air IPX5, mikrofon ganda jernih, dan low-latency gaming mode.', 30);

-- Data Pesanan (Orders)
INSERT INTO orders (user_id, product_id, quantity, total) VALUES
(1, 1, 1, 850000.00),
(1, 4, 2, 900000.00),
(2, 2, 1, 1250000.00),
(3, 3, 1, 1799000.00);

-- ==========================================================
-- 4. QUERY CRUD (CREATE, READ, UPDATE, DELETE) UNTUK PRODUK
-- ==========================================================

-- ----------------------------------------------------------
-- A. CREATE (Menambah Data Produk)
-- ----------------------------------------------------------

-- 1. Menambah satu produk baru
INSERT INTO products (name, price, description, stock) 
VALUES (
    'USB-C Multiport Hub 7-in-1', 
    320000.00, 
    'Adapter USB Type-C dengan port 4K HDMI, 3x USB 3.0, SD/TF Card Reader, dan 100W Power Delivery.', 
    50
);

-- 2. Menambah beberapa produk sekaligus (Batch Insert)
INSERT INTO products (name, price, description, stock) VALUES
('Monitor Gaming Curved 27 Inch 165Hz', 2850000.00, 'Monitor IPS 2K QHD 1ms response time dengan FreeSync dan G-Sync compatibility.', 12),
('Aluminium Laptop Stand Ergonomis', 175000.00, 'Dudukan laptop lipat bahan aluminium kokoh dengan ventilasi pembuangan panas optimal.', 65);


-- ----------------------------------------------------------
-- B. READ (Membaca / Menampilkan Data Produk)
-- ----------------------------------------------------------

-- 1. Menampilkan seluruh data produk
SELECT * FROM products;

-- 2. Menampilkan kolom tertentu (id, nama, harga, stok)
SELECT id, name, price, stock FROM products;

-- 3. Menampilkan produk berdasarkan ID spesifik
SELECT * FROM products WHERE id = 1;

-- 4. Menampilkan produk dengan harga di bawah Rp 1.000.000 dan diurutkan dari yang termurah
SELECT * FROM products 
WHERE price < 1000000.00 
ORDER BY price ASC;

-- 5. Mencari produk berdasarkan kata kunci nama produk (Search)
SELECT * FROM products 
WHERE name LIKE '%Wireless%';

-- 6. Menampilkan total jumlah produk dan rata-rata harga produk
SELECT 
    COUNT(*) AS total_produk,
    SUM(stock) AS total_stok_tersedia,
    AVG(price) AS rata_rata_harga,
    MIN(price) AS harga_terendah,
    MAX(price) AS harga_tertinggi
FROM products;


-- ----------------------------------------------------------
-- C. UPDATE (Mengubah Data Produk)
-- ----------------------------------------------------------

-- 1. Mengubah harga dan stok produk berdasarkan ID
UPDATE products 
SET 
    price = 799000.00, 
    stock = 35 
WHERE id = 1;

-- 2. Mengubah deskripsi produk tertentu
UPDATE products 
SET 
    description = 'Keyboard mekanikal RGB versi upgrade 2026 dengan peredam suara silicone pad dan gateron pro switch.' 
WHERE id = 1;

-- 3. Mengurangi stok produk saat terjadi transaksi pembelian (contoh beli 2 unit pada produk ID 4)
UPDATE products 
SET stock = stock - 2 
WHERE id = 4 AND stock >= 2;


-- ----------------------------------------------------------
-- D. DELETE (Menghapus Data Produk)
-- ----------------------------------------------------------

-- 1. Menghapus satu data produk berdasarkan ID
DELETE FROM products 
WHERE id = 6;

-- 2. Menghapus produk yang memiliki stok 0 (stok habis)
DELETE FROM products 
WHERE stock = 0;

-- ----------------------------------------------------------
-- BONUS: QUERY JOIN (Menampilkan Relasi Orders, Users & Products)
-- ----------------------------------------------------------
SELECT 
    o.order_id,
    u.name AS nama_customer,
    u.email AS email_customer,
    p.name AS nama_produk,
    p.price AS harga_satuan,
    o.quantity AS jumlah_beli,
    o.total AS total_pembayaran,
    o.order_date AS tanggal_transaksi
FROM orders o
JOIN users u ON o.user_id = u.id
JOIN products p ON o.product_id = p.id
ORDER BY o.order_id ASC;
