<?php
// ==========================================
// SESI 7 - TUGAS DASAR PHP, FORM & VALIDASI
// ==========================================

// 1. Inisialisasi Variabel untuk Form & Error Handling
$nama = "";
$harga = "";
$deskripsi = "";
$kategori = "";

$errors = [];
$successMessage = "";
$submittedData = null;

// Cek apakah form dikirim dengan method POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Mengambil dan membersihkan input data (Sanitasi)
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $harga = isset($_POST['harga']) ? trim($_POST['harga']) : '';
    $kategori = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
    $deskripsi = isset($_POST['deskripsi']) ? trim($_POST['deskripsi']) : '';

    // ====================================================
    // 2. VALIDASI DATA MENGGUNAKAN IF-ELSE & OPERATOR LOGIKA
    // ====================================================

    // Validasi: Nama Produk tidak boleh kosong
    if (empty($nama)) {
        $errors['nama'] = "Nama produk wajib diisi!";
    } elseif (strlen($nama) < 3) {
        $errors['nama'] = "Nama produk minimal 3 karakter!";
    }

    // Validasi: Harga Produk tidak boleh kosong & harus berupa angka positif
    if (empty($harga)) {
        $errors['harga'] = "Harga produk wajib diisi!";
    } elseif (!is_numeric($harga)) {
        $errors['harga'] = "Harga harus berupa angka!";
    } elseif ((float)$harga <= 0) {
        $errors['harga'] = "Harga harus lebih besar dari Rp 0!";
    }

    // Validasi: Kategori Produk
    if (empty($kategori)) {
        $errors['kategori'] = "Silakan pilih kategori produk!";
    }

    // Validasi: Deskripsi Produk
    if (empty($deskripsi)) {
        $errors['deskripsi'] = "Deskripsi produk tidak boleh kosong!";
    } elseif (strlen($deskripsi) < 10) {
        $errors['deskripsi'] = "Deskripsi minimal 10 karakter agar informatif!";
    }

    // ====================================================
    // 3. PROSES DATA JIKA TIDAK ADA ERROR (SIMULASI TANPA DB)
    // ====================================================
    if (empty($errors)) {
        // Menggunakan Operator Matematika & Logika untuk demonstrasi
        $hargaAngka = (float)$harga;
        $pajakPPN = $hargaAngka * 0.11; // PPN 11% (Operator Perkalian)
        $totalHarga = $hargaAngka + $pajakPPN; // Operator Penjumlahan

        // Menyiapkan data hasil pemrosesan (Simulasi object/array produk)
        $submittedData = [
            'id' => 'PRD-' . rand(1000, 9999),
            'nama' => htmlspecialchars($nama),
            'harga_asli' => $hargaAngka,
            'pajak' => $pajakPPN,
            'total_harga' => $totalHarga,
            'kategori' => htmlspecialchars($kategori),
            'deskripsi' => nl2br(htmlspecialchars($deskripsi)),
            'waktu_input' => date('d F Y, H:i:s \W\I\B')
        ];

        $successMessage = "Produk berhasil divalidasi dan diproses (Simulasi Berhasil)!";

        // Reset nilai form setelah berhasil
        $nama = "";
        $harga = "";
        $kategori = "";
        $deskripsi = "";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Produk - Sesi 7 PHP</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="app-header">
        <div class="container header-content">
            <div class="brand">
                <div class="brand-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                <div class="brand-text">
                    <h1>E-Commerce Product Entry</h1>
                    <span class="badge-subtitle">Tugas Sesi 7: Dasar PHP, Form & Validasi</span>
                </div>
            </div>
            <div class="header-status">
                <span class="status-indicator"></span>
                <span>Mode: Tanpa Database (PHP Memory Simulation)</span>
            </div>
        </div>
    </header>

    <main class="container main-layout">
        
        <!-- KOLOM KIRI: FORM INPUT -->
        <section class="form-section card-box">
            <div class="section-header">
                <h2><i class="fa-solid fa-square-plus"></i> Tambah Produk Baru</h2>
                <p>Isi formulir di bawah ini untuk memproses data produk dengan validasi PHP.</p>
            </div>

            <!-- Notifikasi Error Global jika ada -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <strong>Terjadi Kesalahan Input!</strong>
                        <p>Mohon periksa kembali kolom yang ditandai merah di bawah ini.</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Notifikasi Sukses -->
            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <strong>Sukses!</strong>
                        <p><?= $successMessage ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="product-form" novalidate>
                
                <!-- Input Nama Produk -->
                <div class="form-group <?= isset($errors['nama']) ? 'has-error' : '' ?>">
                    <label for="nama"><i class="fa-solid fa-tag"></i> Nama Produk <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        placeholder="Contoh: Keyboard Mechanical RGB TKL" 
                        value="<?= htmlspecialchars($nama) ?>"
                    >
                    <?php if (isset($errors['nama'])): ?>
                        <span class="error-msg"><i class="fa-solid fa-circle-info"></i> <?= $errors['nama'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="grid-2-col">
                    <!-- Input Harga Produk -->
                    <div class="form-group <?= isset($errors['harga']) ? 'has-error' : '' ?>">
                        <label for="harga"><i class="fa-solid fa-money-bill-wave"></i> Harga (Rp) <span class="required">*</span></label>
                        <div class="input-prefix-wrapper">
                            <span class="input-prefix">Rp</span>
                            <input 
                                type="number" 
                                id="harga" 
                                name="harga" 
                                placeholder="550000" 
                                value="<?= htmlspecialchars($harga) ?>"
                                min="1"
                            >
                        </div>
                        <?php if (isset($errors['harga'])): ?>
                            <span class="error-msg"><i class="fa-solid fa-circle-info"></i> <?= $errors['harga'] ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Input Kategori -->
                    <div class="form-group <?= isset($errors['kategori']) ? 'has-error' : '' ?>">
                        <label for="kategori"><i class="fa-solid fa-layer-group"></i> Kategori <span class="required">*</span></label>
                        <select id="kategori" name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Elektronik & Gadget" <?= $kategori === 'Elektronik & Gadget' ? 'selected' : '' ?>>Elektronik & Gadget</option>
                            <option value="Aksesoris Komputer" <?= $kategori === 'Aksesoris Komputer' ? 'selected' : '' ?>>Aksesoris Komputer</option>
                            <option value="Fashion & Apparel" <?= $kategori === 'Fashion & Apparel' ? 'selected' : '' ?>>Fashion & Apparel</option>
                            <option value="Peralatan Rumah Tangga" <?= $kategori === 'Peralatan Rumah Tangga' ? 'selected' : '' ?>>Peralatan Rumah Tangga</option>
                            <option value="Lainnya" <?= $kategori === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                        <?php if (isset($errors['kategori'])): ?>
                            <span class="error-msg"><i class="fa-solid fa-circle-info"></i> <?= $errors['kategori'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Input Deskripsi Produk -->
                <div class="form-group <?= isset($errors['deskripsi']) ? 'has-error' : '' ?>">
                    <label for="deskripsi"><i class="fa-solid fa-align-left"></i> Deskripsi Produk <span class="required">*</span></label>
                    <textarea 
                        id="deskripsi" 
                        name="deskripsi" 
                        rows="4" 
                        placeholder="Tuliskan spesifikasi, keunggulan, dan kondisi produk secara jelas..."
                    ><?= htmlspecialchars($deskripsi) ?></textarea>
                    <?php if (isset($errors['deskripsi'])): ?>
                        <span class="error-msg"><i class="fa-solid fa-circle-info"></i> <?= $errors['deskripsi'] ?></span>
                    <?php endif; ?>
                </div>

                <!-- Tombol Action -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Proses & Validasi Data
                    </button>
                    <button type="reset" class="btn btn-secondary" onclick="window.location.href=window.location.pathname">
                        <i class="fa-solid fa-arrows-rotate"></i> Reset
                    </button>
                </div>
            </form>
        </section>

        <!-- KOLOM KANAN: OUTPUT & PREVIEW HASIL PROSES PHP -->
        <section class="preview-section">
            
            <div class="card-box preview-box">
                <div class="section-header">
                    <h2><i class="fa-solid fa-desktop"></i> Hasil Pemrosesan PHP</h2>
                    <p>Data hasil validasi dan perhitungan variabel PHP ditampilkan di sini.</p>
                </div>

                <?php if ($submittedData): ?>
                    <!-- KARTU PREVIEW PRODUK YANG BERHASIL DIPROSES -->
                    <div class="result-card">
                        <div class="result-badge">
                            <span class="status-pill"><i class="fa-solid fa-check"></i> Lolos Validasi</span>
                            <span class="product-id"><?= $submittedData['id'] ?></span>
                        </div>

                        <h3 class="product-title"><?= $submittedData['nama'] ?></h3>
                        <span class="category-chip"><i class="fa-solid fa-folder"></i> <?= $submittedData['kategori'] ?></span>

                        <div class="price-breakdown">
                            <div class="price-row">
                                <span>Harga Dasar</span>
                                <strong>Rp <?= number_format($submittedData['harga_asli'], 0, ',', '.') ?></strong>
                            </div>
                            <div class="price-row">
                                <span>PPN 11% (Operator Hitung)</span>
                                <span>Rp <?= number_format($submittedData['pajak'], 0, ',', '.') ?></span>
                            </div>
                            <div class="price-row total-row">
                                <span>Total Biaya Produk</span>
                                <span class="highlight-price">Rp <?= number_format($submittedData['total_harga'], 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <div class="desc-box">
                            <label><i class="fa-solid fa-file-lines"></i> Deskripsi:</label>
                            <p><?= $submittedData['deskripsi'] ?></p>
                        </div>

                        <div class="timestamp-box">
                            <i class="fa-regular fa-clock"></i> Diproses pada: <?= $submittedData['waktu_input'] ?>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- STATE KETIKA BELUM ADA DATA DISUBMIT -->
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                        <h3>Belum Ada Data yang Diproses</h3>
                        <p>Silakan isi form di samping kiri dan tekan tombol <strong>"Proses & Validasi Data"</strong> untuk melihat hasil eksekusi logika PHP.</p>
                        
                        <div class="learning-checklist">
                            <h4><i class="fa-solid fa-code"></i> Komponen PHP yang Diuji:</h4>
                            <ul>
                                <li><i class="fa-solid fa-circle-check text-green"></i> <strong>Deklarasi Variabel</strong> (<code>$nama</code>, <code>$harga</code>, <code>$errors</code>)</li>
                                <li><i class="fa-solid fa-circle-check text-green"></i> <strong>Operator Logika & Aritmatika</strong> (<code>&&</code>, <code>!</code>, <code>*</code>, <code>+</code>)</li>
                                <li><i class="fa-solid fa-circle-check text-green"></i> <strong>Percabangan If-Else</strong> (Validasi tidak boleh kosong & sanitasi)</li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- EDUKASI SINKRONISASI KODE -->
            <div class="card-box info-box">
                <h3><i class="fa-solid fa-lightbulb text-amber"></i> Penjelasan Logika PHP</h3>
                <div class="code-snippet-note">
                    <p>Validasi dilakukan di sisi server (Server-Side Validation) dengan alur:</p>
                    <ol>
                        <li>Mengecek request method <code>$_SERVER["REQUEST_METHOD"] === "POST"</code></li>
                        <li>Sanitasi input menggunakan <code>trim()</code> dan <code>htmlspecialchars()</code></li>
                        <li>Memeriksa kelengkapan dengan fungsi <code>empty()</code> dan <code>is_numeric()</code></li>
                        <li>Menghitung kalkulasi PPN dengan operator <code>$harga * 0.11</code></li>
                    </ol>
                </div>
            </div>

        </section>

    </main>

    <footer class="app-footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Tugas Sesi 7 - Bootcamp Eduwork. Dibuat dengan PHP Native, HTML5 & Modern CSS.</p>
        </div>
    </footer>

</body>
</html>
