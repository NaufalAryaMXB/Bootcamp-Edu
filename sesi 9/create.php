<?php
/**
 * ==========================================================
 * TUGAS SESI 9 - CRUD OPERATION: CREATE (ADD NEW PRODUCT)
 * File: create.php
 * ----------------------------------------------------------
 * Deskripsi: Menyediakan formulir input produk dan memproses
 *            penyimpanan data baru ke database MySQL.
 * ==========================================================
 */

require_once __DIR__ . '/koneksi.php';

$pesanError = '';

// Pemrosesan Data ketika Formulir dikirim (Metode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = isset($_POST['name']) ? trim($_POST['name']) : '';
    $category    = isset($_POST['category']) ? trim($_POST['category']) : '';
    $price       = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $stock       = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
    $image       = isset($_POST['image']) ? trim($_POST['image']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Validasi form dasar di sisi server
    if (empty($name) || strlen($name) < 3) {
        $pesanError = "Nama produk wajib diisi minimal 3 karakter!";
    } elseif (empty($category)) {
        $pesanError = "Silakan pilih salah satu kategori produk!";
    } elseif ($price <= 0) {
        $pesanError = "Harga produk harus berupa angka lebih besar dari Rp 0!";
    } else {
        // Gambar default jika pengguna tidak mengisi link gambar
        if (empty($image)) {
            $image = 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80';
        }

        // TULIS / SESUAIKAN QUERY INSERT INTO ANDA DI SINI:
        $stmt = mysqli_prepare($conn, "INSERT INTO products (name, category, price, stock, image, description) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssdsss", $name, $category, $price, $stock, $image, $description);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header("Location: index.php?pesan=create_sukses");
                exit;
            } else {
                $pesanError = "Gagal menyimpan data ke MySQL: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $pesanError = "Gagal mempersiapkan query: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form Tambah Produk Baru - EduStore (CRUD: Create)">
    <title>Tambah Produk Baru - EduStore (CRUD: Create)</title>

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

    <!-- Form Tambah Produk (CRUD: Create) -->
    <main class="form-page-section">
        <div class="container">
            <div class="crud-form-card">
                
                <!-- Card Header -->
                <div class="crud-form-header">
                    <h2><i class="fa-solid fa-circle-plus"></i> Tambah Produk Baru</h2>
                    <p>Masukkan informasi detail produk untuk disimpan ke dalam database MySQL.</p>
                </div>

                <?php if (!empty($pesanError)): ?>
                    <div style="margin: 20px 32px 0; padding: 12px 16px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; color: #b91c1c; font-size: 0.88rem; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span><?php echo htmlspecialchars($pesanError); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Formulir Input Produk -->
                <form action="create.php" method="POST" class="crud-form-body">
                    
                    <!-- Input: Nama Produk -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fa-solid fa-tag text-primary"></i> Nama Produk <span class="required">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Mechanical Keyboard Wireless RGB" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        <span class="form-hint">Nama produk minimal 3 karakter agar mudah dicari pembeli.</span>
                    </div>

                    <!-- Input Grid: Kategori & Harga -->
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="category" class="form-label">
                                <i class="fa-solid fa-layer-group text-primary"></i> Kategori Produk <span class="required">*</span>
                            </label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="" disabled <?php echo !isset($_POST['category']) ? 'selected' : ''; ?>>-- Pilih Kategori --</option>
                                <option value="Aksesoris" <?php echo (isset($_POST['category']) && $_POST['category'] === 'Aksesoris') ? 'selected' : ''; ?>>Aksesoris Komputer</option>
                                <option value="Audio" <?php echo (isset($_POST['category']) && $_POST['category'] === 'Audio') ? 'selected' : ''; ?>>Audio & Headphone</option>
                                <option value="Wearable" <?php echo (isset($_POST['category']) && $_POST['category'] === 'Wearable') ? 'selected' : ''; ?>>Wearable & Smartwatch</option>
                                <option value="Gadget" <?php echo (isset($_POST['category']) && $_POST['category'] === 'Gadget') ? 'selected' : ''; ?>>Gadget & Monitor</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-label">
                                <i class="fa-solid fa-money-bill-wave text-primary"></i> Harga Satuan (Rp) <span class="required">*</span>
                            </label>
                            <div class="input-prefix-wrap">
                                <span class="input-prefix">Rp</span>
                                <input type="number" id="price" name="price" class="form-control with-prefix" placeholder="799000" min="1" step="1000" required value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Input Grid: Stok & URL Gambar -->
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="stock" class="form-label">
                                <i class="fa-solid fa-boxes-stacked text-primary"></i> Jumlah Stok Unit <span class="required">*</span>
                            </label>
                            <input type="number" id="stock" name="stock" class="form-control" placeholder="35" min="0" value="<?php echo isset($_POST['stock']) ? htmlspecialchars($_POST['stock']) : '10'; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="image" class="form-label">
                                <i class="fa-solid fa-image text-primary"></i> URL Gambar Produk
                            </label>
                            <input type="url" id="image" name="image" class="form-control" placeholder="https://images.unsplash.com/..." value="<?php echo isset($_POST['image']) ? htmlspecialchars($_POST['image']) : ''; ?>">
                            <span class="form-hint">Masukkan link URL gambar produk (Unsplash / Imgur).</span>
                        </div>
                    </div>

                    <!-- Live Image Preview Box -->
                    <div class="form-group">
                        <label class="form-label">Pratinjau Gambar Produk:</label>
                        <div class="image-preview-box" id="imagePreviewBox">
                            <img id="previewImg" src="" alt="Pratinjau Gambar" style="display: none; max-height: 180px; border-radius: 8px; object-fit: cover;">
                            <div id="previewPlaceholder" style="color: #94a3b8; font-size: 0.86rem; text-align: center;">
                                <i class="fa-regular fa-image" style="font-size: 2rem; margin-bottom: 6px; display: block;"></i>
                                Masukkan URL gambar di atas untuk melihat pratinjau live di sini
                            </div>
                        </div>
                    </div>

                    <!-- Input: Deskripsi Produk -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            <i class="fa-solid fa-align-left text-primary"></i> Deskripsi Lengkap Produk <span class="required">*</span>
                        </label>
                        <textarea id="description" name="description" class="form-textarea" rows="4" placeholder="Jelaskan spesifikasi, fitur unggulan, dan kelebihan produk..." required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                    </div>

                    <!-- Tombol Aksi Form -->
                    <div class="form-actions">
                        <a href="index.php" class="btn-form-cancel">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </a>
                        <button type="submit" class="btn-form-submit">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan ke Database
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
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        function updatePreview(url) {
            if (url && url.length > 5) {
                previewImg.src = url;
                previewImg.style.display = 'block';
                if (previewPlaceholder) previewPlaceholder.style.display = 'none';
            } else {
                previewImg.style.display = 'none';
                if (previewPlaceholder) previewPlaceholder.style.display = 'block';
            }
        }

        if (imageInput) {
            if (imageInput.value) updatePreview(imageInput.value);
            imageInput.addEventListener('input', (e) => {
                updatePreview(e.target.value.trim());
            });
        }
    </script>
</body>
</html>
