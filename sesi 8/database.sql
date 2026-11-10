-- ==========================================================
-- TUGAS SESI 8 - EDUWORK E-COMMERCE
-- Database Schema & Migration Script untuk Sesi 8
-- ==========================================================

USE ecommerce_db;

-- 1. Pastikan kolom category dan image tersedia di tabel products
-- (Jika belum ada dari sesi sebelumnya, jalankan query berikut):
ALTER TABLE products 
ADD COLUMN category VARCHAR(50) DEFAULT 'Umum' AFTER name;

ALTER TABLE products 
ADD COLUMN image VARCHAR(255) NULL AFTER description;

-- 2. Update Kategori & Link Gambar Produk Sesi Sebelumnya
UPDATE products 
SET category = 'Aksesoris', 
    image = 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=80' 
WHERE id = 1;

UPDATE products 
SET category = 'Wearable', 
    image = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80' 
WHERE id = 2;

UPDATE products 
SET category = 'Audio', 
    image = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80' 
WHERE id = 3;

UPDATE products 
SET category = 'Aksesoris', 
    image = 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=600&q=80' 
WHERE id = 4;

UPDATE products 
SET category = 'Audio', 
    image = 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=600&q=80' 
WHERE id = 5;

UPDATE products 
SET category = 'Gadget', 
    image = 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=600&q=80' 
WHERE id = 7;

UPDATE products 
SET category = 'Aksesoris', 
    image = 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=600&q=80' 
WHERE id = 8;

-- 3. Query Pengujian untuk Sesi 8

-- A. Menampilkan semua produk
SELECT * FROM products;

-- B. Menampilkan produk berdasarkan filter kategori tertentu (Contoh: Audio)
SELECT * FROM products WHERE category = 'Audio';

-- C. Menghitung jumlah produk per kategori (untuk badge count filter)
SELECT category, COUNT(*) AS total_produk 
FROM products 
GROUP BY category;
