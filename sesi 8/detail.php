<?php
/**
 * ==============================================================================
 * TUGAS SESI 8 - OPERASI CRUD: READ DETAIL (DETAIL PRODUK)
 * File: detail.php
 * Deskripsi: Menampilkan informasi lengkap satu produk berdasarkan ID yang
 *            diambil dari tabel products di database MySQL.
 * ==============================================================================
 */

// 1. Hubungkan ke database
require_once __DIR__ . '/koneksi.php';

// Ambil ID produk dari parameter URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// 2. Query data produk dari MySQL
$stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    header("Location: index.php?pesan=tidak_ditemukan");
    exit;
}

$catClass = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $product['category'] ?? 'umum'));
$imageSrc = !empty($product['image']) ? $product['image'] : 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80';
$isLowStock = (int)$product['stock'] <= 15;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - EduStore Detail Produk</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons 6.5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    <header class="header">
        <nav class="navbar container">
            <a href="index.php" class="logo">
                <div class="logo-icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <span>Edu<span class="highlight">Store</span></span>
            </a>

            <div class="nav-actions">
                <a href="index.php" class="btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
                </a>
            </div>
        </nav>
    </header>

    <!-- ================= HALAMAN DETAIL PRODUK ================= -->
    <main class="container">
        <div class="detail-page-card">
            
            <!-- Gambar Produk -->
            <div class="detail-media">
                <img src="<?php echo htmlspecialchars($imageSrc); ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                     class="detail-img"
                     onerror="this.src='https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80'">
            </div>

            <!-- Konten Detail Produk -->
            <div class="detail-content">
                <div class="detail-actions-top">
                    <span class="badge-pill badge-category-<?php echo $catClass; ?>">
                        <?php echo htmlspecialchars($product['category']); ?>
                    </span>
                    <span class="card-stock-chip <?php echo $isLowStock ? 'low-stock' : ''; ?>">
                        <i class="fa-solid <?php echo $isLowStock ? 'fa-fire' : 'fa-circle-check'; ?>"></i>
                        <?php echo $isLowStock ? 'Sisa: ' : 'Stok: '; ?><?php echo (int)$product['stock']; ?> Unit
                    </span>
                </div>

                <h1 class="detail-title"><?php echo htmlspecialchars($product['name']); ?></h1>

                <div class="detail-price-box">
                    <span class="price-label">Harga Satuan Resmi</span>
                    <div class="detail-price">
                        Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                    </div>
                </div>

                <!-- Tabel Spesifikasi & Info Metadata -->
                <table class="detail-specs-table">
                    <tr>
                        <td>ID Produk:</td>
                        <td>#<?php echo $product['id']; ?></td>
                    </tr>
                    <tr>
                        <td>Kategori:</td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                    </tr>
                    <tr>
                        <td>Status Stok:</td>
                        <td><?php echo (int)$product['stock'] > 0 ? (int)$product['stock'] . ' unit tersedia' : '<span style="color:red;">Stok Habis</span>'; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Ditambahkan:</td>
                        <td><?php echo !empty($product['created_at']) ? date('d F Y, H:i \W\I\B', strtotime($product['created_at'])) : '-'; ?></td>
                    </tr>
                </table>

                <div style="margin-top: 10px; margin-bottom: 28px;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; color: var(--text-main);">
                        Deskripsi Produk:
                    </h4>
                    <p style="font-size: 0.9rem; line-height: 1.7; color: var(--text-muted);">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </p>
                </div>

                <!-- Tombol Aksi CRUD -->
                <div style="margin-top: auto; display: flex; gap: 12px; flex-wrap: wrap; padding-top: 20px; border-top: 1px solid var(--border-color);">
                    <a href="update.php?id=<?php echo $product['id']; ?>" class="btn-submit-save" style="background: #4f46e5;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Produk
                    </a>
                    <a href="delete.php?id=<?php echo $product['id']; ?>" 
                       class="btn-secondary" 
                       style="color: var(--danger); border-color: #fecaca;"
                       onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini: <?php echo htmlspecialchars(addslashes($product['name'])); ?>?');">
                        <i class="fa-solid fa-trash-can"></i> Hapus
                    </a>
                    <a href="index.php" class="btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="footer">
        <div class="container footer-bottom">
            <div>&copy; 2026 EduStore E-Commerce. CRUD Sesi 8.</div>
            <div class="footer-tech-stack">
                <span class="tech-badge">PHP 8.x</span>
                <span class="tech-badge">MySQL</span>
            </div>
        </div>
    </footer>
</body>
</html>
<?php
mysqli_close($conn);
?>
