-- ==========================================================
-- TUGAS SESI 9 - EDUWORK FULLSTACK WEB DEVELOPMENT
-- Database E-Commerce MySQL: products & cart_items
-- ==========================================================

-- 1. Buat Database jika belum ada
CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

-- 2. Buat Tabel Produk (products)
-- Menyimpan katalog barang e-commerce untuk operasi CRUD & Cart
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'Umum',
    price DECIMAL(12, 2) NOT NULL CHECK (price >= 0),
    description TEXT,
    image VARCHAR(255) NULL,
    stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Data Awal (Sample Seed Data) Produk
-- Berisi 7 produk dari berbagai kategori teknologi & kerja
INSERT INTO products (name, category, price, description, image, stock) VALUES
(
    'Mechanical Keyboard Wireless RGB', 
    'Aksesoris', 
    799000.00, 
    'Keyboard mekanikal RGB versi upgrade 2026 dengan peredam suara silicone pad dan gateron pro switch tactile.', 
    'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=80', 
    35
),
(
    'Smartwatch AMOLED Fit Active Pro', 
    'Wearable', 
    1250000.00, 
    'Smartwatch canggih layar sentuh AMOLED Always-On Display dengan sensor detak jantung, SpO2, dan baterai tahan hingga 14 hari.', 
    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80', 
    20
),
(
    'Wireless Noise Cancelling Headphone', 
    'Audio', 
    1899000.00, 
    'Headphone over-ear peredam bising aktif (ANC) premium dengan driver dynamic 40mm dan baterai 40 jam.', 
    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80', 
    14
),
(
    'Ergonomic Wireless Vertical Mouse', 
    'Aksesoris', 
    349000.00, 
    'Mouse vertikal ergonomis 57 derajat untuk kenyamanan pergelangan tangan seharian dan koneksi dual Bluetooth + 2.4G.', 
    'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=600&q=80', 
    50
),
(
    'Studio Pro True Wireless Earbuds ANC', 
    'Audio', 
    649000.00, 
    'TWS earbuds bluetooth 5.3 berteknologi low-latency gaming mode, bass mendalam, dan tahan cipratan air IPX5.', 
    'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=600&q=80', 
    28
),
(
    'Monitor Gaming Curved 27 Inch 165Hz', 
    'Gadget', 
    2850000.00, 
    'Monitor lengkung 1500R resolusi 2K QHD dengan refresh rate 165Hz, response time 1ms, dan 99% sRGB color gamut.', 
    'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=600&q=80', 
    9
),
(
    'Aluminium Laptop Stand Ergonomis', 
    'Aksesoris', 
    175000.00, 
    'Dudukan laptop lipat bahan aluminium alloy kokoh dengan sirkulasi udara optimal dan 6 level ketinggian.', 
    'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=600&q=80', 
    65
)
ON DUPLICATE KEY UPDATE id=id;

-- 4. Tabel Opsional: Keranjang Belanja (cart_items)
-- Gunakan tabel ini jika Anda memilih mengimplementasikan fitur keranjang belanja
-- berbasis database MySQL (bukan PHP Session $_SESSION['cart']).
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL COMMENT 'ID sesi browser pengguna (misal: session_id())',
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1 CHECK (quantity > 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_cart_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 5. CONTOH QUERY REFERENSI UNTUK TUGAS SESI 9
-- ==========================================================

-- [READ] Ambil semua produk untuk katalog
-- SELECT * FROM products ORDER BY id DESC;

-- [CREATE] Tambah produk baru
-- INSERT INTO products (name, category, price, description, image, stock) 
-- VALUES ('Nama Produk', 'Aksesoris', 150000, 'Deskripsi produk...', 'https://...', 25);

-- [UPDATE] Edit produk berdasarkan ID
-- UPDATE products 
-- SET name = 'Nama Baru', category = 'Audio', price = 200000, stock = 10, description = 'Update desc...' 
-- WHERE id = 1;

-- [DELETE] Hapus produk berdasarkan ID
-- DELETE FROM products WHERE id = 1;

-- [CART] Ambil data keranjang dengan JOIN ke tabel products (jika via DB)
-- SELECT c.id AS cart_id, c.quantity, p.id AS product_id, p.name, p.price, p.image, (p.price * c.quantity) AS subtotal
-- FROM cart_items c
-- JOIN products p ON c.product_id = p.id
-- WHERE c.session_id = 'SESI_USER_DISINI';
