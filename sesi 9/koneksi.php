<?php
/**
 * ==========================================================
 * TUGAS SESI 9 - KONEKSI DATABASE MYSQL DENGAN PHP
 * File: koneksi.php
 * Deskripsi: Menghubungkan script PHP dengan database MySQL
 *            "ecommerce_db" menggunakan ekstensi mysqli.
 * ==========================================================
 */

// Konfigurasi Kredensial Database MySQL
$db_host = "localhost";      // Alamat server database
$db_user = "root";           // Username default XAMPP/Laragon
$db_pass = "";               // Password default XAMPP/Laragon (kosong)
$db_name = "ecommerce_db";   // Nama database e-commerce
$db_port = 3306;             // Port standar MySQL

// Membuat koneksi ke MySQL server
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// Penanganan kegagalan koneksi
if (!$conn) {
    die("
    <div style='font-family: system-ui, sans-serif; max-width: 650px; margin: 40px auto; padding: 24px; background: #fef2f2; border: 1px solid #f87171; border-radius: 12px; color: #991b1b; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);'>
        <h3 style='margin-top: 0; display: flex; align-items: center; gap: 8px;'>
            ⚠️ Koneksi Database MySQL Gagal!
        </h3>
        <p style='margin: 8px 0;'><strong>Pesan Kesalahan:</strong> <code>" . htmlspecialchars(mysqli_connect_error()) . "</code></p>
        <hr style='border: none; border-top: 1px solid #fecaca; margin: 16px 0;'>
        <p style='margin: 0 0 8px 0; font-weight: 600;'>Panduan Perbaikan Cepat:</p>
        <ol style='margin: 0; padding-left: 20px; line-height: 1.6;'>
            <li>Pastikan modul <strong>MySQL</strong> di Laragon atau XAMPP sudah berstatus <em>Running / Start</em>.</li>
            <li>Buka <strong>phpMyAdmin</strong> atau HeidiSQL, lalu buat database <code>{$db_name}</code> jika belum ada.</li>
            <li>Import file <code>database.sql</code> yang tersedia di folder <code>sesi 9/</code>.</li>
        </ol>
    </div>
    ");
}

// Set karakter encoding ke utf8mb4 agar mendukung karakter khusus dan simbol mata uang
mysqli_set_charset($conn, "utf8mb4");

// Variabel status koneksi untuk keperluan diagnosis (opsional)
$dbStatus = [
    'connected' => true,
    'host'      => $db_host,
    'database'  => $db_name
];
?>
