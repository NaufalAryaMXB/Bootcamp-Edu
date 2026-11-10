<?php
/**
 * ==========================================================
 * TUGAS SESI 8 - KONEKSI DATABASE MYSQL DENGAN PHP
 * File: koneksi.php
 * Deskripsi: Menghubungkan script PHP dengan database MySQL
 *            "ecommerce_db" yang dibuat pada sesi 6.
 * ==========================================================
 */

// Konfigurasi Kredensial Database
$db_host = "localhost";      // Alamat host MySQL
$db_user = "root";           // Username database (default XAMPP/Laragon: root)
$db_pass = "";               // Password database (default: kosong)
$db_name = "ecommerce_db";   // Nama database yang dibuat pada Sesi 6
$db_port = 3306;             // Port standar MySQL

// Membuat Koneksi menggunakan ekstensi mysqli
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

// Memeriksa keberhasilan koneksi
if (!$conn) {
    // Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan error yang jelas
    die("
    <div style='font-family: sans-serif; padding: 20px; background: #fef2f2; border: 1px solid #ef4444; border-radius: 8px; margin: 20px; color: #991b1b;'>
        <h3 style='margin-top: 0;'>⚠️ Koneksi Database Gagal!</h3>
        <p><strong>Pesan Error:</strong> " . mysqli_connect_error() . "</p>
        <p>Pastikan MySQL server di Laragon / XAMPP sudah dinyalakan (Running) dan database <code>{$db_name}</code> sudah dibuat.</p>
    </div>
    ");
}

// Set karakter encoding ke utf8mb4 agar mendukung simbol dan emoji
mysqli_set_charset($conn, "utf8mb4");

// Variabel status koneksi untuk ditampilkan pada badge header
$koneksiStatus = [
    'sukses' => true,
    'host' => $db_host,
    'database' => $db_name,
    'pesan' => "Terhubung ke MySQL ({$db_name})"
];
?>
