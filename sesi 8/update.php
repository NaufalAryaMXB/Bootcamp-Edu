<?php
/**
 * ==============================================================================
 * TUGAS SESI 8 - CRUD OPERATION: UPDATE (EDIT / UPDATE PRODUCT)
 * File: update.php
 * Deskripsi: Mengambil data produk berdasarkan ID dari MySQL, menampilkannya
 *            ke dalam form edit, dan memperbarui data menggunakan query UPDATE.
 * ==============================================================================
 */

// 1. Hubungkan ke database
require_once __DIR__ . '/koneksi.php';

// Ambil ID produk dari parameter URL atau POST
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$errors = [];

// 2. Jika form di-submit dengan method POST (Proses Perubahan Data)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = isset($_POST['name']) ? trim($_POST['name']) : '';
    $category    = isset($_POST['category']) ? trim($_POST['category']) : '';
    $price       = isset($_POST['price']) ? trim($_POST['price']) : '';
    $stock       = isset($_POST['stock']) ? trim($_POST['stock']) : '0';
    $image       = isset($_POST['image']) ? trim($_POST['image']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Validasi
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
    }

    // Jika tidak ada error, eksekusi query UPDATE dengan Prepared Statement
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "UPDATE products SET name = ?, category = ?, price = ?, description = ?, image = ?, stock = ? WHERE id = ?");
        if ($stmt) {
            $priceFloat = (float)$price;
            $stockInt = (int)$stock;
            mysqli_stmt_bind_param($stmt, "ssdssii", $name, $category, $priceFloat, $description, $image, $stockInt, $id);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header("Location: index.php?pesan=update_sukses");
                exit;
            } else {
                $errors['general'] = "Gagal memperbarui data: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors['general'] = "Query prepare gagal: " . mysqli_error($conn);
        }
    }
} else {
    // 3. Ambil data lama produk dari database untuk diisi ke formulir
    $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$product) {
        // Jika produk tidak ditemukan di database
        header("Location: index.php?pesan=tidak_ditemukan");
        exit;
    }

    $name        = $product['name'];
    $category    = $product['category'];
    $price       = $product['price'];
    $stock       = $product['stock'];
    $image       = $product['image'];
    $description = $product['description'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk #<?php echo $id; ?> - EduStore (CRUD: Update)</title>

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

    <!-- ================= FORM EDIT PRODUK (UPDATE) ================= -->
    <main class="container form-page-section">
        <div class="crud-form-card">
            <div class="crud-form-header">
                <h2>
                    <i class="fa-solid fa-pen-to-square"></i> Edit Data Produk (Update)
                </h2>
                <p>Perbarui informasi produk ID: <strong>#<?php echo $id; ?></strong> pada database MySQL.</p>
            </div>

            <?php if (!empty($errors['general'])): ?>
                <div class="alert-banner alert-danger" style="margin: 20px 32px 0;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($errors['general']); ?></span>
                </div>
            <?php endif; ?>

            <form action="update.php?id=<?php echo $id; ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="crud-form-body">
                    
                    <!-- Nama Produk -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nama Produk <span class="required">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" 
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
                                       min="1000" step="1000" 
                                       value="<?php echo htmlspecialchars((int)$price); ?>" required>
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
                                   min="0" 
                                   value="<?php echo htmlspecialchars((int)$stock); ?>" required>
                            <?php if (isset($errors['stock'])): ?>
                                <span class="form-hint" style="color: var(--danger);"><?php echo $errors['stock']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- URL Gambar Produk -->
                    <div class="form-group">
                        <label for="image" class="form-label">
                            URL Gambar Produk
                        </label>
                        <input type="url" id="image" name="image" class="form-control" 
                               value="<?php echo htmlspecialchars($image); ?>">
                        <span class="form-hint">Masukkan tautan URL gambar produk atau biarkan seperti semula.</span>
                        
                        <!-- Box Preview Gambar -->
                        <div class="image-preview-box" id="imagePreviewBox">
                            <img src="<?php echo htmlspecialchars($image); ?>" 
                                 id="previewImg" 
                                 style="<?php echo empty($image) ? 'display: none;' : ''; ?>" 
                                 alt="Pratinjau Gambar">
                            <div class="image-preview-empty" id="previewEmpty" style="<?php echo !empty($image) ? 'display: none;' : ''; ?>">
                                <i class="fa-solid fa-image" style="font-size: 1.8rem; margin-bottom: 4px;"></i>
                                <span>Pratinjau gambar produk</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Produk -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            Deskripsi Produk <span class="required">*</span>
                        </label>
                        <textarea id="description" name="description" class="form-control form-textarea" 
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
                        <i class="fa-solid fa-check"></i> Simpan Perubahan
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
