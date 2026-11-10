<?php
/**
 * ==========================================================
 * TUGAS SESI 9 - CART CONTROLLER (KERANJANG BELANJA PHP)
 * File: cart.php
 * ----------------------------------------------------------
 * Deskripsi: Mengelola data keranjang belanja menggunakan
 *            PHP Session ($_SESSION['cart']).
 * Aksi yang didukung via parameter URL (?action=...&id=...):
 * - add      : Menambah produk ke keranjang
 * - decrease : Mengurangi kuantitas item
 * - remove   : Menghapus 1 item tertentu
 * - clear    : Mengosongkan seluruh isi keranjang
 * ==========================================================
 */

session_start();
require_once __DIR__ . '/koneksi.php';

// Inisialisasi array keranjang jika belum dibuat di session
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = isset($_GET['action']) ? trim($_GET['action']) : '';
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Penanganan Aksi Keranjang Belanja
switch ($action) {
    case 'add':
        if ($productId > 0) {
            // Ambil data produk asli dari database MySQL
            $stmt = mysqli_prepare($conn, "SELECT id, name, price, image, stock FROM products WHERE id = ?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $productId);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);
                $product = mysqli_fetch_assoc($res);
                mysqli_stmt_close($stmt);

                if ($product) {
                    $stock = (int)$product['stock'];
                    if (isset($_SESSION['cart'][$productId])) {
                        // Tambah kuantitas jika belum melebihi stok yang tersedia
                        if ($_SESSION['cart'][$productId]['quantity'] < $stock) {
                            $_SESSION['cart'][$productId]['quantity'] += 1;
                        }
                    } else {
                        // Daftarkan item baru ke keranjang belanja
                        $_SESSION['cart'][$productId] = [
                            'id'       => (int)$product['id'],
                            'name'     => $product['name'],
                            'price'    => (float)$product['price'],
                            'image'    => $product['image'],
                            'quantity' => 1
                        ];
                    }
                }
            }
        }
        break;

    case 'decrease':
        if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] -= 1;
            // Jika kuantitas habis (0), hapus dari keranjang
            if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
                unset($_SESSION['cart'][$productId]);
            }
        }
        break;

    case 'remove':
        if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        break;

    case 'clear':
        unset($_SESSION['cart']);
        $_SESSION['cart'] = [];
        break;
}

// Redirect kembali ke halaman sebelumnya atau index.php
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
header("Location: " . $referer);
exit;
?>
