<?php
/**
 * ==============================================================================
 * TUGAS SESI 8 - CRUD OPERATION: CREATE (ADD NEW PRODUCT)
 * File: create.php
 * Deskripsi: Menampilkan form input untuk menambahkan produk baru dan
 *            menyimpannya ke dalam database MySQL (tabel products).
 * ==============================================================================
 */

// 1. Hubungkan ke database
require_once __DIR__ . '/koneksi.php';

$errors = [];
$name = '';
$category = '';
$price = '';
$stock = '';
$image = '';
$description = '';

// 2. Pemrosesan Data ketika Form dikirim (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = isset($_POST['name']) ? trim($_POST['name']) : '';
    $category    = isset($_POST['category']) ? trim($_POST['category']) : '';
    $price       = isset($_POST['price']) ? trim($_POST['price']) : '';
    $stock       = isset($_POST['stock']) ? trim($_POST['stock']) : '0';
    $image       = isset($_POST['image']) ? trim($_POST['image']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Validasi Form di sisi server
    if (empty($name)) {
        $errors['name'] = "Nama produk wajib diisi!";
    } elseif (strlen($name) < 3) {
        $errors['name'] = "Nama produk minimal 3 karakter!";
    }

    if (empty($category)) {
        $errors['category'] = "Silakan pilih salah satu kategori!";
    }

    if (empty($price)) {
        $errors['price'] = "Harga produk wajib diisi!";
    } elseif (!is_numeric($price) || (float)$price <= 0) {
        $errors['price'] = "Harga harus berupa angka lebih besar dari Rp 0!";
    }

    if (!is_numeric($stock) || (int)$stock < 0) {
        $errors['stock'] = "Stok harus berupa angka minimal 0!";
    }

    if (empty($description)) {
        $errors['description'] = "Deskripsi produk wajib diisi!";
    } elseif (strlen($description) < 10) {
        $errors['description'] = "Deskripsi minimal 10 karakter agar informatif!";
    }

    // Gambar cadangan otomatis jika dikosongkan
    if (empty($image)) {
        $defaultImages = [
            'Aksesoris' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=80',
            'Audio'     => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80',
            'Wearable'  => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80',
            'Gadget'    => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=600&q=80'
        ];
        $image = isset($defaultImages[$category]) ? $defaultImages[$category] : 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80';
    }

    // Jika validasi sukses, simpan ke database MySQL via Prepared Statement
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO products (name, category, price, description, image, stock) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $priceFloat = (float)$price;
            $stockInt = (int)$stock;
            mysqli_stmt_bind_param($stmt, "ssdssi", $name, $category, $priceFloat, $description, $image, $stockInt);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header("Location: index.php?pesan=create_sukses");
                exit;
            } else {
                $errors['general'] = "Gagal menyimpan ke database: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors['general'] = "Query prepare gagal: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- ================= FORM TAMBAH PRODUK (CREATE) ================= -->
    <main class="container form-page-section">
        <div class="crud-form-card">
            <div class="crud-form-header">
                <h2>
                    <i class="fa-solid fa-circle-plus"></i> Tambah Produk Baru (Create)
                </h2>
                <p>Isi formulir berikut untuk menambahkan produk baru ke database MySQL (Tabel <code>products</code>).</p>
            </div>

            <?php if (!empty($errors['general'])): ?>
                <div class="alert-banner alert-danger" style="margin: 20px 32px 0;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($errors['general']); ?></span>
                </div>
            <?php endif; ?>

            <form action="create.php" method="POST">
                <div class="crud-form-body">
                    
                    <!-- Nama Produk -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nama Produk <span class="required">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" 
                               placeholder="Contoh: Mechanical Keyboard Wireless RGB" 
                               value="<?php echo htmlspecialchars($name); ?>" required>
                        <?php if (isset($errors['name'])): ?>
                            <span class="form-hint" style="color: var(--danger);"><?php echo $errors['name']; ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Kategori Produk -->
                    <div class="form-group">
                        <label for="category" class="form-label">
                            Kategori Produk <span class="required">*</span>
                        </label>
                        <select id="category" name="category" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Aksesoris" <?php echo $category === 'Aksesoris' ? 'selected' : ''; ?>>Aksesoris Komputer</option>
                            <option value="Audio" <?php echo $category === 'Audio' ? 'selected' : ''; ?>>Audio & Headphone</option>
                            <option value="Wearable" <?php echo $category === 'Wearable' ? 'selected' : ''; ?>>Wearable & Smartwatch</option>
                            <option value="Gadget" <?php echo $category === 'Gadget' ? 'selected' : ''; ?>>Gadget & Display</option>
                        </select>
                        <?php if (isset($errors['category'])): ?>
                            <span class="form-hint" style="color: var(--danger);"><?php echo $errors['category']; ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Harga & Stok (2 Kolom) -->
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label for="price" class="form-label">
                                Harga Produk (Rp) <span class="required">*</span>
                            </label>
                            <div class="input-addon-group">
                                <span class="input-addon-prefix">Rp</span>
                                <input type="number" id="price" name="price" class="form-control input-with-addon" 
                                       placeholder="799000" min="1000" step="1000" 
                                       value="<?php echo htmlspecialchars($price); ?>" required>
                            </div>
                            <?php if (isset($errors['price'])): ?>
                                <span class="form-hint" style="color: var(--danger);"><?php echo $errors['price']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="stock" class="form-label">
                                Jumlah Stok <span class="required">*</span>
                            </label>
                            <input type="number" id="stock" name="stock" class="form-control" 
                                   placeholder="25" min="0" 
                                   value="<?php echo htmlspecialchars($stock); ?>" required>
                            <?php if (isset($errors['stock'])): ?>
                                <span class="form-hint" style="color: var(--danger);"><?php echo $errors['stock']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- URL Gambar Produk -->
                    <div class="form-group">
                        <label for="image" class="form-label">
                            URL Gambar Produk (Opsional)
                        </label>
                        <input type="url" id="image" name="image" class="form-control" 
                               placeholder="https://images.unsplash.com/..." 
                               value="<?php echo htmlspecialchars($image); ?>">
                        <span class="form-hint">Kosongkan jika ingin memakai gambar otomatis sesuai kategori pilihan.</span>
                        
                        <!-- Box Preview Gambar -->
                        <div class="image-preview-box" id="imagePreviewBox">
                            <img src="<?php echo !empty($image) ? htmlspecialchars($image) : ''; ?>" 
                                 id="previewImg" 
                                 style="<?php echo empty($image) ? 'display: none;' : ''; ?>" 
                                 alt="Pratinjau Gambar">
                            <div class="image-preview-empty" id="previewEmpty" style="<?php echo !empty($image) ? 'display: none;' : ''; ?>">
                                <i class="fa-solid fa-image" style="font-size: 1.8rem; margin-bottom: 4px;"></i>
                                <span>Pratinjau gambar produk akan tampil di sini</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            Deskripsi Produk <span class="required">*</span>
                        </label>
                        <textarea id="description" name="description" class="form-control form-textarea" 
                                  placeholder="Tuliskan spesifikasi, keunggulan, dan kelengkapan produk secara detail..." 
                                  rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <span class="form-hint" style="color: var(--danger);"><?php echo $errors['description']; ?></span>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="crud-form-footer">
                    <a href="index.php" class="btn-secondary">
                        <i class="fa-solid fa-xmark"></i> Batal
                    </a>
                    <button type="submit" class="btn-submit-save">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan ke Database
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Script Live Preview Gambar -->
    <script>
        const imageInput = document.getElementById('image');
        const previewImg = document.getElementById('previewImg');
        const previewEmpty = document.getElementById('previewEmpty');

        if (imageInput) {
            imageInput.addEventListener('input', (e) => {
                const url = e.target.value.trim();
                if (url.length > 5) {
                    previewImg.src = url;
                    previewImg.style.display = 'block';
                    previewEmpty.style.display = 'none';
                } else {
                    previewImg.style.display = 'none';
                    previewEmpty.style.display = 'flex';
                }
            });

            previewImg.addEventListener('error', () => {
                previewImg.style.display = 'none';
                previewEmpty.style.display = 'flex';
            });
        }
    </script>
</body>
</html>
