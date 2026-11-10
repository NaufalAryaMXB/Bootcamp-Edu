<?php
/**
 * ==========================================================
 * TUGAS SESI 9 - CRUD OPERATION: UPDATE (EDIT DATA PRODUK)
 * File: update.php
 * ----------------------------------------------------------
 * Deskripsi: Mengambil data lama produk berdasarkan ID dari URL,
 *            menampilkannya di dalam form edit, dan menyimpan
 *            perubahannya kembali ke database MySQL.
 * ==========================================================
 */

require_once __DIR__ . '/koneksi.php';

$pesanError = '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

if ($id <= 0) {
    header("Location: index.php?pesan=id_tidak_valid");
    exit;
}

// 1. Pemrosesan Penyimpanan saat Formulir dikirim (Metode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = isset($_POST['name']) ? trim($_POST['name']) : '';
    $category    = isset($_POST['category']) ? trim($_POST['category']) : '';
    $price       = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $stock       = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
    $image       = isset($_POST['image']) ? trim($_POST['image']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    if (empty($name) || strlen($name) < 3) {
        $pesanError = "Nama produk wajib diisi minimal 3 karakter!";
    } elseif (empty($category)) {
        $pesanError = "Silakan pilih salah satu kategori!";
    } elseif ($price <= 0) {
        $pesanError = "Harga produk harus lebih besar dari Rp 0!";
    } else {
        // TULIS / SESUAIKAN QUERY UPDATE ANDA DI SINI:
        $stmt = mysqli_prepare($conn, "UPDATE products SET name = ?, category = ?, price = ?, stock = ?, image = ?, description = ? WHERE id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssdsssi", $name, $category, $price, $stock, $image, $description, $id);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header("Location: index.php?pesan=update_sukses");
                exit;
            } else {
                $pesanError = "Gagal memperbarui data: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $pesanError = "Gagal mempersiapkan query: " . mysqli_error($conn);
        }
    }
}

// 2. Ambil data produk lama dari MySQL untuk diisikan ke form (Pre-fill)
$stmtGet = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmtGet, "i", $id);
mysqli_stmt_execute($stmtGet);
$res = mysqli_stmt_get_result($stmtGet);
$product = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmtGet);

if (!$product) {
    header("Location: index.php?pesan=tidak_ditemukan");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form Edit Produk - EduStore (CRUD: Update)">
    <title>Edit Data Produk - EduStore (CRUD: Update)</title>

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

    <!-- Header Navbar Ringkas -->
    <header class="header">
        <nav class="navbar container">
            <a href="index.php" class="logo">
                <div class="logo-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                <span>Edu<span class="highlight">Store</span></span>
            </a>
            <div>
                <a href="index.php" class="btn-icon-secondary" style="width: auto; padding: 8px 16px; border-radius: 9999px; gap: 8px; text-decoration: none; font-size: 0.88rem; font-weight: 600;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
                </a>
            </div>
        </nav>
    </header>

    <!-- Form Edit Produk (CRUD: Update) -->
    <main class="form-page-section">
        <div class="container">
            <div class="crud-form-card">
                
                <!-- Card Header -->
                <div class="crud-form-header">
                    <h2><i class="fa-solid fa-pen-to-square"></i> Edit Data Produk</h2>
                    <p>Perbarui informasi produk lalu simpan perubahan ke database MySQL.</p>
                </div>

                <?php if (!empty($pesanError)): ?>
                    <div style="margin: 20px 32px 0; padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #b91c1c; font-size: 0.88rem; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span><?php echo htmlspecialchars($pesanError); ?></span>
                    </div>
                <?php endif; ?>

                <form action="update.php" method="POST" class="crud-form-body">
                    
                    <!-- Hidden ID Field untuk mengenali produk yang diupdate -->
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                    <!-- Input: Nama Produk -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fa-solid fa-tag text-primary"></i> Nama Produk <span class="required">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" required value="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>

                    <!-- Input Grid: Kategori & Harga -->
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="category" class="form-label">
                                <i class="fa-solid fa-layer-group text-primary"></i> Kategori Produk <span class="required">*</span>
                            </label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="Aksesoris" <?php echo ($product['category'] === 'Aksesoris') ? 'selected' : ''; ?>>Aksesoris Komputer</option>
                                <option value="Audio" <?php echo ($product['category'] === 'Audio') ? 'selected' : ''; ?>>Audio & Headphone</option>
                                <option value="Wearable" <?php echo ($product['category'] === 'Wearable') ? 'selected' : ''; ?>>Wearable & Smartwatch</option>
                                <option value="Gadget" <?php echo ($product['category'] === 'Gadget') ? 'selected' : ''; ?>>Gadget & Monitor</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-label">
                                <i class="fa-solid fa-money-bill-wave text-primary"></i> Harga Satuan (Rp) <span class="required">*</span>
                            </label>
                            <div class="input-prefix-wrap">
                                <span class="input-prefix">Rp</span>
                                <input type="number" id="price" name="price" class="form-control with-prefix" min="1" step="1000" required value="<?php echo (int)$product['price']; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Input Grid: Stok & URL Gambar -->
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="stock" class="form-label">
                                <i class="fa-solid fa-boxes-stacked text-primary"></i> Jumlah Stok Unit <span class="required">*</span>
                            </label>
                            <input type="number" id="stock" name="stock" class="form-control" min="0" required value="<?php echo (int)$product['stock']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="image" class="form-label">
                                <i class="fa-solid fa-image text-primary"></i> URL Gambar Produk
                            </label>
                            <input type="url" id="image" name="image" class="form-control" value="<?php echo htmlspecialchars($product['image']); ?>">
                        </div>
                    </div>

                    <!-- Live Image Preview Box -->
                    <div class="form-group">
                        <label class="form-label">Pratinjau Gambar Produk:</label>
                        <div class="image-preview-box" id="imagePreviewBox">
                            <img id="previewImg" src="<?php echo htmlspecialchars($product['image']); ?>" alt="Pratinjau Gambar" style="max-height: 180px; border-radius: 8px; object-fit: cover;">
                        </div>
                    </div>

                    <!-- Input: Deskripsi Produk -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="fa-solid fa-align-left text-primary"></i> Deskripsi Lengkap Produk <span class="required">*</span>
                        </label>
                        <textarea id="description" name="description" class="form-textarea" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <!-- Tombol Aksi Form -->
                    <div class="form-actions">
                        <a href="index.php" class="btn-form-cancel">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </a>
                        <button type="submit" class="btn-form-submit">
                            <i class="fa-solid fa-check"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </main>

    <!-- Script Live Image Preview -->
    <script>
        const imageInput = document.getElementById('image');
        const previewImg = document.getElementById('previewImg');

        if (imageInput && previewImg) {
            imageInput.addEventListener('input', (e) => {
                const url = e.target.value.trim();
                if (url.length > 5) {
                    previewImg.src = url;
                    previewImg.style.display = 'block';
                }
            });
        }
    </script>
</body>
</html>
