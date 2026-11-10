<?php
/**
 * ==============================================================================
 * TUGAS SESI 8 - CRUD OPERATION: DELETE (REMOVE PRODUCT)
 * File: delete.php
 * Deskripsi: Menghapus data produk dari database MySQL berdasarkan parameter ID
 *            yang dikirimkan lewat URL, lalu mengarahkan kembali ke index.php.
 * ==============================================================================
 */

// 1. Hubungkan ke database
require_once __DIR__ . '/koneksi.php';

// 2. Ambil parameter ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // 3. Periksa apakah produk dengan ID tersebut ada di database
    $checkStmt = mysqli_prepare($conn, "SELECT id, name FROM products WHERE id = ?");
    mysqli_stmt_bind_param($checkStmt, "i", $id);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    $product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($checkStmt);

    if ($product) {
        // 4. Eksekusi query DELETE menggunakan Prepared Statement
        $deleteStmt = mysqli_prepare($conn, "DELETE FROM products WHERE id = ?");
        mysqli_stmt_bind_param($deleteStmt, "i", $id);

        if (mysqli_stmt_execute($deleteStmt)) {
            mysqli_stmt_close($deleteStmt);
            mysqli_close($conn);

            // Redirect ke halaman index dengan pesan sukses terhapus
            header("Location: index.php?pesan=delete_sukses&item=" . urlencode($product['name']));
            exit;
        } else {
            $errorMsg = mysqli_stmt_error($deleteStmt);
            mysqli_stmt_close($deleteStmt);
            mysqli_close($conn);

            header("Location: index.php?pesan=delete_gagal&error=" . urlencode($errorMsg));
            exit;
        }
    } else {
        // Produk tidak ditemukan
        mysqli_close($conn);
        header("Location: index.php?pesan=tidak_ditemukan");
        exit;
    }
} else {
    // ID tidak valid
    mysqli_close($conn);
    header("Location: index.php");
    exit;
}
?>
