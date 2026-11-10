<?php
/**
 * ==============================================================================
 * TUGAS SESI 8 - EDUSTORE E-COMMERCE WITH PHP & MYSQL
 * ------------------------------------------------------------------------------
 * 1. Menghubungkan PHP ke database MySQL (koneksi.php).
 * 2. Mengambil data produk dari database dan menampilkan menggunakan looping PHP.
 * 3. Fitur filter produk berdasarkan kategori dengan query dinamis (WHERE category).
 * ==============================================================================
 */

// 1. Hubungkan ke database MySQL
require_once __DIR__ . '/koneksi.php';

// Inisialisasi variabel filter & pencarian dari parameter URL ($_GET)
$kategoriTerpilih = isset($_GET['kategori']) ? trim($_GET['kategori']) : 'all';
$kataKunci        = isset($_GET['search']) ? trim($_GET['search']) : '';
$urutan           = isset($_GET['sort']) ? trim($_GET['sort']) : 'default';

// Sanitasi input untuk keamanan query MySQL
$kategoriEscaped = mysqli_real_escape_string($conn, $kategoriTerpilih);
$kataKunciEscaped = mysqli_real_escape_string($conn, $kataKunci);

// 2. Hitung jumlah produk per kategori secara dinamis dari database untuk badge filter
$categoryCounts = [
    'all' => 0
];
$catQuery = mysqli_query($conn, "SELECT category, COUNT(*) AS total FROM products GROUP BY category");
if ($catQuery) {
    while ($catRow = mysqli_fetch_assoc($catQuery)) {
        $catName = $catRow['category'];
        $categoryCounts[$catName] = (int)$catRow['total'];
        $categoryCounts['all'] += (int)$catRow['total'];
    }
}

// 3. Bangun Query SQL berdasarkan Filter Kategori & Pencarian
$conditions = [];

// Filter Kategori (Fokus Tugas Utama Sesi 8)
if (!empty($kategoriEscaped) && strtolower($kategoriEscaped) !== 'all') {
    $conditions[] = "category = '{$kategoriEscaped}'";
}

// Filter Pencarian (Fitur Pelengkap)
if (!empty($kataKunciEscaped)) {
    $conditions[] = "(name LIKE '%{$kataKunciEscaped}%' OR description LIKE '%{$kataKunciEscaped}%')";
}

// Gabungkan klausa WHERE jika ada kondisi filter
$sql = "SELECT * FROM products";
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Tambahkan pengurutan (Sorting)
switch ($urutan) {
    case 'price-low':
        $sql .= " ORDER BY price ASC";
        break;
    case 'price-high':
        $sql .= " ORDER BY price DESC";
        break;
    case 'name-asc':
        $sql .= " ORDER BY name ASC";
        break;
    default:
        $sql .= " ORDER BY id ASC";
        break;
}

// Eksekusi query produk
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Database Gagal: " . mysqli_error($conn));
}

$totalProduk = mysqli_num_rows($result);

// Kategori default yang tersedia
$daftarKategori = [
    'all'       => ['label' => 'Semua',     'icon' => 'fa-layer-group'],
    'Aksesoris' => ['label' => 'Aksesoris', 'icon' => 'fa-keyboard'],
    'Audio'     => ['label' => 'Audio',     'icon' => 'fa-headphones'],
    'Wearable'  => ['label' => 'Wearable',  'icon' => 'fa-clock'],
    'Gadget'    => ['label' => 'Gadget',    'icon' => 'fa-desktop']
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tugas Sesi 8 Eduwork - Aplikasi Katalog E-Commerce dengan PHP & MySQL Database">
    <title>EduStore - Katalog Produk (PHP & MySQL Database)</title>

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

    <!-- ================= TOP ANNOUNCEMENT BAR ================= -->
    <div class="top-bar">
        <div class="container top-bar-content">
            <div class="top-bar-left">
                <div class="top-bar-item">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Gratis Ongkir ke Seluruh Indonesia min. belanja Rp 200rb</span>
                </div>
                <div class="top-bar-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>100% Produk Original & Bergaransi</span>
                </div>
            </div>
            <div class="top-bar-right">
                <!-- Status Koneksi Database Dinamis -->
                <span class="mode-pill" title="Status Database MySQL">
                    <span class="pulse-dot"></span>
                    <span>Database: <?php echo htmlspecialchars($koneksiStatus['pesan']); ?></span>
                </span>
            </div>
        </div>
    </div>

    <!-- ================= NAVBAR / HEADER ================= -->
    <header class="header">
        <nav class="navbar container">
            <!-- Brand Logo -->
            <a href="index.php" class="logo">
                <div class="logo-icon">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <span>Edu<span class="highlight">Store</span></span>
            </a>

            <!-- Search Bar (Form GET) -->
            <form action="index.php" method="GET" class="nav-search">
                <?php if ($kategoriTerpilih !== 'all'): ?>
                    <input type="hidden" name="kategori" value="<?php echo htmlspecialchars($kategoriTerpilih); ?>">
                <?php endif; ?>
                <?php if ($urutan !== 'default'): ?>
                    <input type="hidden" name="sort" value="<?php echo htmlspecialchars($urutan); ?>">
                <?php endif; ?>
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" name="search" class="search-input" placeholder="Cari keyboard, mouse, headphone, smartwatch..." value="<?php echo htmlspecialchars($kataKunci); ?>" autocomplete="off">
                    <?php if (!empty($kataKunci)): ?>
                        <a href="index.php<?php echo $kategoriTerpilih !== 'all' ? '?kategori=' . urlencode($kategoriTerpilih) : ''; ?>" class="search-clear" style="display: block;" title="Hapus pencarian">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Nav Actions (Tambah Produk / Create, Cart) -->
            <div class="nav-actions">
                <a href="create.php" class="btn-nav-add" title="Tambah Produk Baru (CRUD: Create)">
                    <i class="fa-solid fa-plus"></i> <span>Tambah Produk</span>
                </a>
                <button type="button" class="btn-action-icon" id="cartBtn" title="Keranjang Belanja">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge-count" id="cartBadge">0</span>
                </button>
            </div>
        </nav>
    </header>

    <!-- ================= NOTIFIKASI ALERT CRUD ================= -->
    <?php
    $pesan = isset($_GET['pesan']) ? $_GET['pesan'] : '';
    $item = isset($_GET['item']) ? htmlspecialchars($_GET['item']) : '';
    $errorDesc = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
    ?>
    <?php if ($pesan === 'create_sukses' || $pesan === 'tambah_sukses'): ?>
        <div class="container">
            <div class="alert-banner alert-success">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><strong>Berhasil! (Create)</strong> Produk baru telah berhasil disimpan ke database MySQL.</span>
                </div>
                <button type="button" class="alert-close" onclick="this.closest('.alert-banner').remove()">&times;</button>
            </div>
        </div>
    <?php elseif ($pesan === 'update_sukses' || $pesan === 'edit_sukses'): ?>
        <div class="container">
            <div class="alert-banner alert-success">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><strong>Berhasil! (Update)</strong> Perubahan data produk telah disimpan ke database MySQL.</span>
                </div>
                <button type="button" class="alert-close" onclick="this.closest('.alert-banner').remove()">&times;</button>
            </div>
        </div>
    <?php elseif ($pesan === 'delete_sukses' || $pesan === 'hapus_sukses'): ?>
        <div class="container">
            <div class="alert-banner alert-success">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><strong>Berhasil! (Delete)</strong> Produk <?php echo !empty($item) ? "<em>\"{$item}\"</em>" : ''; ?> telah berhasil dihapus dari database.</span>
                </div>
                <button type="button" class="alert-close" onclick="this.closest('.alert-banner').remove()">&times;</button>
            </div>
        </div>
    <?php elseif ($pesan === 'delete_gagal' || $pesan === 'hapus_gagal'): ?>
        <div class="container">
            <div class="alert-banner alert-danger">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><strong>Gagal Menghapus!</strong> Terjadi kesalahan: <?php echo $errorDesc; ?></span>
                </div>
                <button type="button" class="alert-close" onclick="this.closest('.alert-banner').remove()">&times;</button>
            </div>
        </div>
    <?php elseif ($pesan === 'tidak_ditemukan'): ?>
        <div class="container">
            <div class="alert-banner alert-danger">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><strong>Peringatan!</strong> Data produk yang dicari tidak ditemukan di database.</span>
                </div>
                <button type="button" class="alert-close" onclick="this.closest('.alert-banner').remove()">&times;</button>
            </div>
        </div>
    <?php endif; ?>

    <!-- ================= HERO PROMO BANNER ================= -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-banner">
                <div class="hero-info">
                    <span class="hero-tag">
                        <i class="fa-solid fa-fire"></i> Penawaran Eksklusif 2026
                    </span>
                    <h1 class="hero-title">Upgrade Setup & Gadget Impianmu Hari Ini</h1>
                    <p class="hero-desc">Data produk di bawah ini diambil langsung dari database MySQL <strong>ecommerce_db</strong> secara dinamis menggunakan looping PHP.</p>
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <span class="stat-value"><?php echo $categoryCounts['all']; ?> Produk</span>
                            <span class="stat-label">Total Data MySQL</span>
                        </div>
                        <div class="hero-stat-item">
                            <span class="stat-value">MySQL 8.x</span>
                            <span class="stat-label">Basis Data Relasional</span>
                        </div>
                        <div class="hero-stat-item">
                            <span class="stat-value">PHP 8.x</span>
                            <span class="stat-label">Perulangan Dinamis</span>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-card-preview">
                        <div class="hero-preview-icon">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <div class="hero-preview-text">
                            <h4>MySQL Query Aktif</h4>
                            <p style="font-family: monospace; font-size: 0.72rem; word-break: break-all; opacity: 0.95;">
                                <?php echo htmlspecialchars($sql); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= VALUE PROPOSITION STRIP ================= -->
    <div class="container">
        <div class="features-strip">
            <div class="feature-box">
                <div class="feature-icon-wrap">
                    <i class="fa-solid fa-truck"></i>
                </div>
                <div class="feature-info">
                    <h4>Bebas Ongkir</h4>
                    <p>Ke seluruh kota di Indonesia</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrap">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="feature-info">
                    <h4>Garansi Resmi</h4>
                    <p>Jaminan 1 tahun ganti baru</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrap">
                    <i class="fa-solid fa-rotate-left"></i>
                </div>
                <div class="feature-info">
                    <h4>7 Hari Pengembalian</h4>
                    <p>Bila produk rusak atau cacat</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrap">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div class="feature-info">
                    <h4>Layanan 24/7</h4>
                    <p>Dukungan teknis responsif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MAIN CATALOG SECTION ================= -->
    <main class="container catalog-section" id="katalog">
        
        <!-- Header Katalog & Filter -->
        <div class="section-head">
            <div class="section-title-wrap">
                <h2>
                    <i class="fa-solid fa-cubes-stacked text-primary"></i>
                    Katalog Produk Unggulan
                </h2>
                <p>Data produk dimuat dari tabel <code>products</code> di MySQL</p>
            </div>
            <div>
                <a href="create.php" class="btn-nav-add">
                    <i class="fa-solid fa-circle-plus"></i> Tambah Produk Baru
                </a>
            </div>
        </div>

        <!-- Filter Bar: Kategori & Sorting (Fokus Tugas Sesi 8) -->
        <div class="filter-bar">
            <!-- Filter Kategori Tombol (Query Link dengan Parameter URL) -->
            <div class="category-filters">
                <?php foreach ($daftarKategori as $key => $kat): 
                    $isActive = ($kategoriTerpilih === $key) || ($key === 'all' && $kategoriTerpilih === 'all');
                    
                    // URL link untuk kategori
                    $linkParams = [];
                    if ($key !== 'all') {
                        $linkParams['kategori'] = $key;
                    }
                    if (!empty($kataKunci)) {
                        $linkParams['search'] = $kataKunci;
                    }
                    if ($urutan !== 'default') {
                        $linkParams['sort'] = $urutan;
                    }
                    $categoryUrl = 'index.php' . (!empty($linkParams) ? '?' . http_build_query($linkParams) : '');
                    $countBadge = isset($categoryCounts[$key]) ? $categoryCounts[$key] : 0;
                ?>
                    <a href="<?php echo htmlspecialchars($categoryUrl); ?>#katalog" 
                       class="filter-btn <?php echo $isActive ? 'active' : ''; ?>">
                        <i class="fa-solid <?php echo htmlspecialchars($kat['icon']); ?>"></i>
                        <span><?php echo htmlspecialchars($kat['label']); ?></span>
                        <span class="cat-count"><?php echo $countBadge; ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Kontrol Tambahan: Hitungan & Sorting -->
            <div class="filter-controls">
                <div class="result-count-badge">
                    Menampilkan <strong><?php echo $totalProduk; ?></strong> produk
                    <?php if ($kategoriTerpilih !== 'all'): ?>
                        dalam kategori <em>"<?php echo htmlspecialchars($kategoriTerpilih); ?>"</em>
                    <?php endif; ?>
                </div>
                
                <form action="index.php" method="GET" class="sort-select-wrap">
                    <?php if ($kategoriTerpilih !== 'all'): ?>
                        <input type="hidden" name="kategori" value="<?php echo htmlspecialchars($kategoriTerpilih); ?>">
                    <?php endif; ?>
                    <?php if (!empty($kataKunci)): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($kataKunci); ?>">
                    <?php endif; ?>
                    <select name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="default" <?php echo $urutan === 'default' ? 'selected' : ''; ?>>Urutan Default</option>
                        <option value="price-low" <?php echo $urutan === 'price-low' ? 'selected' : ''; ?>>Harga: Termurah</option>
                        <option value="price-high" <?php echo $urutan === 'price-high' ? 'selected' : ''; ?>>Harga: Tertinggi</option>
                        <option value="name-asc" <?php echo $urutan === 'name-asc' ? 'selected' : ''; ?>>Nama: A - Z</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- ================= PRODUCT GRID CONTAINER (PHP LOOPING) ================= -->
        <div class="product-grid" id="productGrid">

            <?php if ($totalProduk > 0): ?>
                <?php 
                // Looping data produk dari database menggunakan while loop PHP
                while ($product = mysqli_fetch_assoc($result)): 
                    $catClass = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $product['category'] ?? 'umum'));
                    $imageSrc = !empty($product['image']) ? $product['image'] : 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80';
                    $isLowStock = (int)$product['stock'] <= 15;
                ?>
                    <!-- Kartu Produk yang dirender secara berulang (Looping) oleh PHP -->
                    <article class="product-card" data-category="<?php echo htmlspecialchars($product['category'] ?? 'Umum'); ?>">
                        <div class="card-media">
                            <img src="<?php echo htmlspecialchars($imageSrc); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="card-img" 
                                 loading="lazy"
                                 onerror="this.src='https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80'">
                            <div class="card-badge-top">
                                <span class="badge-pill badge-category-<?php echo $catClass; ?>">
                                    <?php echo htmlspecialchars($product['category'] ?? 'Umum'); ?>
                                </span>
                            </div>
                            <span class="card-stock-chip <?php echo $isLowStock ? 'low-stock' : ''; ?>">
                                <i class="fa-solid <?php echo $isLowStock ? 'fa-fire' : 'fa-circle-check'; ?>"></i>
                                <?php echo $isLowStock ? 'Sisa: ' : 'Stok: '; ?><?php echo (int)$product['stock']; ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <span class="card-category-text"><?php echo htmlspecialchars($product['category'] ?? 'Produk'); ?></span>
                            <h3 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="card-desc"><?php echo htmlspecialchars($product['description'] ?? 'Tidak ada deskripsi.'); ?></p>
                            
                            <div class="card-meta">
                                <div class="card-rating">
                                    <i class="fa-solid fa-star"></i>
                                    <span>4.8</span>
                                    <span class="rating-count">(<?php echo rand(40, 250); ?>)</span>
                                </div>
                                <span class="card-shipping"><i class="fa-solid fa-truck"></i> Siap Kirim</span>
                            </div>

                            <div class="card-footer">
                                <div class="card-price-wrap">
                                    <span class="price-label">Harga</span>
                                    <span class="card-price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></span>
                                </div>
                                <div class="card-actions">
                                    <button type="button" class="btn-icon-secondary btn-quick-view" 
                                            title="Lihat Detail Cepat" 
                                            data-id="<?php echo $product['id']; ?>">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn-add-cart" 
                                            data-id="<?php echo $product['id']; ?>" 
                                            data-name="<?php echo htmlspecialchars($product['name']); ?>">
                                        <i class="fa-solid fa-cart-plus"></i> Beli
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Tombol Aksi CRUD Per Item (Detail, Edit, Hapus) -->
                        <div class="card-admin-actions">
                            <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn-admin-action" style="color: #475569; background: #f1f5f9;" title="Lihat Halaman Detail Produk">
                                <i class="fa-solid fa-circle-info"></i> Detail
                            </a>
                            <a href="update.php?id=<?php echo $product['id']; ?>" class="btn-admin-action btn-admin-edit" title="Edit Data Produk (CRUD: Update)">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>
                            <a href="delete.php?id=<?php echo $product['id']; ?>" 
                               class="btn-admin-action btn-admin-delete" 
                               title="Hapus Produk dari Database (CRUD: Delete)" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini: <?php echo htmlspecialchars(addslashes($product['name'])); ?>?');">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>

            <?php else: ?>
                <!-- Empty State jika tidak ada produk yang cocok dengan query filter -->
                <div class="empty-state" style="display: block;">
                    <div class="empty-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3>Produk Tidak Ditemukan</h3>
                    <p>Tidak ada produk pada kategori <strong>"<?php echo htmlspecialchars($kategoriTerpilih); ?>"</strong><?php echo !empty($kataKunci) ? ' dengan kata kunci "' . htmlspecialchars($kataKunci) . '"' : ''; ?>.</p>
                    <a href="index.php" class="btn-reset-filter">
                        <i class="fa-solid fa-rotate-left"></i> Reset Filter Semua Produk
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- ================= QUICK VIEW MODAL ================= -->
    <div class="modal-overlay" id="quickViewModal">
        <div class="modal-box">
            <button type="button" class="modal-close-btn" id="modalCloseBtn" title="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="modal-media">
                <img src="" alt="Detail Produk" id="modalImg" class="modal-img">
            </div>
            <div class="modal-info">
                <span class="modal-category" id="modalCategory">Kategori</span>
                <h2 class="modal-title" id="modalTitle">Judul Produk</h2>
                <div class="modal-price" id="modalPrice">Rp 0</div>
                <p class="modal-desc" id="modalDesc">Deskripsi detail produk akan muncul di sini.</p>
                <div class="modal-meta-grid">
                    <div class="modal-meta-item">
                        <strong>Ketersediaan</strong>
                        <span id="modalStock">Stok Tersedia</span>
                    </div>
                    <div class="modal-meta-item">
                        <strong>Garansi</strong>
                        <span>1 Tahun Resmi</span>
                    </div>
                </div>
                <button type="button" class="btn-add-cart" id="modalAddToCartBtn" style="width: 100%; justify-content: center; padding: 12px;">
                    <i class="fa-solid fa-cart-shopping"></i> Tambahkan ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <!-- ================= TOAST NOTIFICATION CONTAINER ================= -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- ================= FOOTER ================= -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">
                        <div class="logo-icon">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <span>Edu<span class="highlight">Store</span></span>
                    </a>
                    <p>Platform e-commerce katalog produk modern yang dibangun menggunakan PHP, MySQL, dan vanilla frontend CSS untuk tugas bootcamp Eduwork.</p>
                </div>

                <div class="footer-col">
                    <h4>Kategori Populer</h4>
                    <ul>
                        <li><a href="index.php?kategori=Aksesoris#katalog">Aksesoris Komputer</a></li>
                        <li><a href="index.php?kategori=Audio#katalog">Audio & Headphone</a></li>
                        <li><a href="index.php?kategori=Wearable#katalog">Smartwatch & Wearable</a></li>
                        <li><a href="index.php?kategori=Gadget#katalog">Gadget & Monitor</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Layanan Pelanggan</h4>
                    <ul>
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">Kebijakan Garansi</a></li>
                        <li><a href="#">Lacak Pesanan</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Tentang Tugas</h4>
                    <ul>
                        <li><a href="#">Sesi 6: Database MySQL</a></li>
                        <li><a href="#">Sesi 7: PHP Form & Validasi</a></li>
                        <li><a href="#">Sesi 8: PHP MySQL & Filter Query</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    &copy; 2026 EduStore E-Commerce. Bootcamp Eduwork Fullstack Web Development.
                </div>
                <div class="footer-tech-stack">
                    <span class="tech-badge">HTML5</span>
                    <span class="tech-badge">CSS3</span>
                    <span class="tech-badge">PHP 8.x</span>
                    <span class="tech-badge">MySQL Database</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Frontend Interactive Script (Modal & Cart Toast) -->
    <script src="script.js"></script>
</body>
</html>
<?php
// Tutup koneksi database di akhir halaman
mysqli_close($conn);
?>
