<?php
/**
 * ==========================================================
 * TUGAS SESI 9 - CRUD OPERATION: DELETE (HAPUS DATA PRODUK)
 * File: delete.php
 * ----------------------------------------------------------
 * Deskripsi: Menghapus record produk dari tabel database MySQL
 *            berdasarkan ID produk yang dikirimkan via URL.
 * ==========================================================
 */

require_once __DIR__ . '/koneksi.php';

// 1. Ambil dan validasi ID produk dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // 2. Eksekusi query DELETE menggunakan Prepared Statement
    $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?pesan=delete_sukses");
            exit;
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?pesan=delete_gagal");
            exit;
        }
    }
}

// Jika ID tidak valid, kembalikan ke index.php
header("Location: index.php?pesan=id_tidak_valid");
exit;
?>
