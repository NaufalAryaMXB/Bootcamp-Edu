<?php
/**
 * ==============================================================================
 * TUGAS SESI 9 - EDUSTORE E-COMMERCE (PHP & MYSQL BACKEND)
 * File: index.php
 * ------------------------------------------------------------------------------
 * Modul ini menampilkan:
 * 1. Read: Daftar produk diambil secara dinamis dari database MySQL.
 * 2. Create: Tombol navigasi menuju formulir create.php.
 * 3. Update & Delete: Tombol aksi per item produk ke update.php & delete.php.
 * 4. Cart: Integrasi keranjang belanja (Slide-over drawer & session/localStorage).
 * ==============================================================================
 */

// 1. Inisialisasi Session untuk mendukung fitur Keranjang Belanja (Cart)
session_start();

// 2. Hubungkan ke database MySQL
require_once __DIR__ . '/koneksi.php';

// 3. TULIS / SESUAIKAN QUERY READ PRODUK ANDA DI BAWAH INI:
$sql = "SELECT * FROM products ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Database Gagal: " . mysqli_error($conn));
}

$totalProduk = mysqli_num_rows($result);

// 4. Tangkap parameter pesan notifikasi (Flash Feedback)
$pesan = isset($_GET['pesan']) ? trim($_GET['pesan']) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tugas Sesi 9 Eduwork - Integrasi CRUD Database & Keranjang Belanja E-Commerce (PHP & MySQL)">
    <title>EduStore - Katalog CRUD & Keranjang Belanja (PHP & MySQL)</title>

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
                <span class="mode-pill" title="Status Halaman">
                    <span class="pulse-dot"></span>
                    <span>Tugas Sesi 9: PHP MySQL Backend & Keranjang Belanja</span>
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

            <!-- Search Bar -->
            <div class="nav-search">
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari keyboard, mouse, headphone, smartwatch..." autocomplete="off">
                    <button type="button" class="search-clear" id="searchClear" title="Bersihkan pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Nav Actions: Tombol Tambah Produk (Create) & Keranjang Belanja (Cart) -->
            <div class="nav-actions">
                <!-- Link ke Form Tambah Produk (Create) -->
                <a href="create.php" class="btn-add-product-nav" title="Tambah Produk Baru ke Database">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Produk</span>
                </a>

                <!-- Tombol Buka Keranjang Belanja (Cart) -->
                <button type="button" class="btn-action-icon" id="cartBtn" title="Buka Keranjang Belanja">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge-count" id="cartBadge">0</span>
                </button>
            </div>
        </nav>
    </header>

    <!-- ================= ALERT BANNER NOTIFIKASI FEEDBACK ================= -->
    <?php if ($pesan === 'create_sukses'): ?>
        <div class="container" style="margin-top: 16px;">
            <div class="alert-banner alert-success">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><strong>Berhasil! (Create)</strong> Produk baru telah berhasil disimpan ke database MySQL.</span>
                </div>
                <button type="button" class="alert-close" onclick="this.closest('.alert-banner').remove()">&times;</button>
            </div>
        </div>
    <?php elseif ($pesan === 'update_sukses'): ?>
        <div class="container" style="margin-top: 16px;">
            <div class="alert-banner alert-success">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><strong>Berhasil! (Update)</strong> Data produk telah berhasil diperbarui di database.</span>
                </div>
                <button type="button" class="alert-close" onclick="this.closest('.alert-banner').remove()">&times;</button>
            </div>
        </div>
    <?php elseif ($pesan === 'delete_sukses'): ?>
        <div class="container" style="margin-top: 16px;">
            <div class="alert-banner alert-success">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><strong>Berhasil! (Delete)</strong> Produk telah berhasil dihapus dari database.</span>
                </div>
                <button type="button" class="alert-close" onclick="this.closest('.alert-banner').remove()">&times;</button>
            </div>
        </div>
    <?php elseif ($pesan === 'delete_gagal'): ?>
        <div class="container" style="margin-top: 16px;">
            <div class="alert-banner alert-danger">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><strong>Gagal!</strong> Terjadi kesalahan saat menghapus data produk.</span>
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
                        <i class="fa-solid fa-bolt"></i> Tugas Sesi 9 Eduwork
                    </span>
                    <h1 class="hero-title">Integrasi CRUD & Keranjang Belanja</h1>
                    <p class="hero-desc">Katalog e-commerce berbasis <strong>PHP & MySQL</strong>: Tambah produk (Create), Tampilkan katalog dari database (Read), Edit data (Update), Hapus produk (Delete), dan tambahkan ke Keranjang Belanja (Cart).</p>
                    
                    <div class="hero-stats">
                        <div class="hero-stat-item">
                            <span class="stat-value"><?php echo $totalProduk; ?> Produk</span>
                            <span class="stat-label">Data MySQL Aktif</span>
                        </div>
                        <div class="hero-stat-item">
                            <span class="stat-value">PHP 8.x</span>
                            <span class="stat-label">Backend Terintegrasi</span>
                        </div>
                        <div class="hero-stat-item">
                            <span class="stat-value">Cart</span>
                            <span class="stat-label">Keranjang Belanja Aktif</span>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-card-preview">
                        <div class="hero-preview-icon">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <div class="hero-preview-text">
                            <h4>Status Koneksi Database</h4>
                            <p style="font-family: monospace; font-size: 0.74rem;">
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
                <div class="feature-icon-wrap"><i class="fa-solid fa-truck"></i></div>
                <div class="feature-info">
                    <h4>Bebas Ongkir</h4>
                    <p>Ke seluruh kota di Indonesia</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrap"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="feature-info">
                    <h4>Garansi Resmi</h4>
                    <p>Jaminan 1 tahun ganti baru</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrap"><i class="fa-solid fa-rotate-left"></i></div>
                <div class="feature-info">
                    <h4>7 Hari Pengembalian</h4>
                    <p>Bila produk rusak atau cacat</p>
                </div>
            </div>
            <div class="feature-box">
                <div class="feature-icon-wrap"><i class="fa-solid fa-headset"></i></div>
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
                    Katalog Produk E-Commerce (MySQL)
                </h2>
                <p>Kelola data produk secara real-time dan tambahkan ke keranjang belanja</p>
            </div>
            <div>
                <a href="create.php" class="btn-add-product-nav">
                    <i class="fa-solid fa-plus"></i> Tambah Produk Baru
                </a>
            </div>
        </div>

        <!-- Filter Bar: Kategori & Sorting -->
        <div class="filter-bar">
            <!-- Filter Kategori Kancing -->
            <div class="category-filters" id="categoryFilters">
                <button type="button" class="filter-btn active" data-category="all">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Semua</span>
                    <span class="cat-count" id="countAll"><?php echo $totalProduk; ?></span>
                </button>
                <button type="button" class="filter-btn" data-category="Aksesoris">
                    <i class="fa-solid fa-keyboard"></i>
                    <span>Aksesoris</span>
                </button>
                <button type="button" class="filter-btn" data-category="Audio">
                    <i class="fa-solid fa-headphones"></i>
                    <span>Audio</span>
                </button>
                <button type="button" class="filter-btn" data-category="Wearable">
                    <i class="fa-solid fa-clock"></i>
                    <span>Wearable</span>
                </button>
                <button type="button" class="filter-btn" data-category="Gadget">
                    <i class="fa-solid fa-desktop"></i>
                    <span>Gadget</span>
                </button>
            </div>

            <!-- Kontrol Tambahan: Hitungan & Sorting -->
            <div class="filter-controls">
                <div class="result-count-badge">
                    Menampilkan <strong id="visibleCount"><?php echo $totalProduk; ?></strong> produk
                </div>
                <div class="sort-select-wrap">
                    <select id="sortSelect" class="sort-select">
                        <option value="default">Urutan Default</option>
                        <option value="price-low">Harga: Termurah</option>
                        <option value="price-high">Harga: Tertinggi</option>
                        <option value="name-asc">Nama: A - Z</option>
                    </select>
                </div>
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
                    $stock = (int)($product['stock'] ?? 0);
                    $isLowStock = $stock <= 15;
                ?>
                    <!-- Kartu Produk Dinamis yang di-render oleh PHP -->
                    <article class="product-card" 
                             data-id="<?php echo $product['id']; ?>" 
                             data-category="<?php echo htmlspecialchars($product['category'] ?? 'Umum'); ?>" 
                             data-price="<?php echo $product['price']; ?>" 
                             data-name="<?php echo htmlspecialchars($product['name']); ?>">
                        
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
                                <?php echo $isLowStock ? 'Sisa: ' : 'Stok: '; ?><?php echo $stock; ?>
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
                                    <span class="rating-count">(95)</span>
                                </div>
                                <span class="card-shipping"><i class="fa-solid fa-truck"></i> Siap Kirim</span>
                            </div>

                            <div class="card-footer">
                                <div class="card-price-wrap">
                                    <span class="price-label">Harga</span>
                                    <span class="card-price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></span>
                                </div>
                                <div class="card-actions">
                                    <button type="button" class="btn-icon-secondary btn-quick-view" title="Lihat Cepat" data-id="<?php echo $product['id']; ?>">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <!-- Tombol Beli / Tambahkan ke Keranjang -->
                                    <button type="button" class="btn-add-cart" 
                                            data-id="<?php echo $product['id']; ?>" 
                                            data-name="<?php echo htmlspecialchars($product['name']); ?>" 
                                            data-price="<?php echo $product['price']; ?>">
                                        <i class="fa-solid fa-cart-plus"></i> Beli
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Tombol Aksi CRUD Per Item (Update & Delete) -->
                        <div class="card-admin-actions">
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
                <!-- Empty State jika tidak ada data produk di MySQL -->
                <div class="empty-state" style="display: block;">
                    <div class="empty-icon"><i class="fa-solid fa-box-open"></i></div>
                    <h3>Belum Ada Produk di Database</h3>
                    <p>Tabel <code>products</code> saat ini masih kosong. Silakan tambahkan produk baru pertama Anda!</p>
                    <a href="create.php" class="btn-reset-filter" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-plus"></i> Tambah Produk Sekarang
                    </a>
                </div>
            <?php endif; ?>

            <!-- Empty State jika pencarian / filter client-side tidak ditemukan -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon"><i class="fa-solid fa-box-open"></i></div>
                <h3>Produk Tidak Ditemukan</h3>
                <p>Maaf, tidak ada produk yang cocok dengan pencarian atau kategori Anda.</p>
                <button type="button" class="btn-reset-filter" id="btnResetFilter">
                    <i class="fa-solid fa-rotate-left"></i> Reset Filter
                </button>
            </div>

        </div>
    </main>

    <!-- ========================================================== -->
    <!-- KERANJANG BELANJA (CART SLIDE-OVER DRAWER)                  -->
    <!-- ========================================================== -->
    <!-- Backdrop Overlay saat keranjang terbuka -->
    <div class="cart-drawer-overlay" id="cartDrawerOverlay"></div>

    <!-- Drawer Panel Slide dari Kanan -->
    <aside class="cart-drawer" id="cartDrawer" aria-label="Keranjang Belanja">
        <!-- Header Drawer -->
        <div class="cart-drawer-header">
            <div class="cart-drawer-title">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Keranjang Belanja</span>
                <span class="cart-item-count-badge" id="cartDrawerCount">0 Produk</span>
            </div>
            <button type="button" class="cart-close-btn" id="cartCloseBtn" title="Tutup Keranjang">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Body Drawer (Daftar Produk yang ditambahkan ke Keranjang) -->
        <div class="cart-drawer-body">
            <!-- Container item keranjang dinamis -->
            <div id="cartDrawerItems"></div>

            <!-- Tampilan saat keranjang masih kosong -->
            <div class="cart-empty-box" id="cartEmptyState">
                <div class="cart-empty-icon">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                </div>
                <h4>Keranjang Belanja Kosong</h4>
                <p>Belum ada produk yang ditambahkan. Klik tombol <strong>"Beli"</strong> pada produk impian Anda!</p>
            </div>
        </div>

        <!-- Footer Drawer: Subtotal, Total & Tombol Checkout -->
        <div class="cart-drawer-footer" id="cartDrawerFooter" style="display: none;">
            <div class="cart-summary-line subtotal">
                <span>Subtotal Produk</span>
                <span id="cartSubtotal">Rp 0</span>
            </div>
            <div class="cart-summary-line total">
                <span>Total Belanja</span>
                <span class="total-amount" id="cartTotal">Rp 0</span>
            </div>
            <button type="button" class="cart-checkout-btn" id="cartCheckoutBtn">
                <i class="fa-solid fa-credit-card"></i> Lanjut ke Pembayaran
            </button>
            <button type="button" class="cart-clear-btn" id="cartClearBtn">
                <i class="fa-solid fa-trash-can"></i> Kosongkan Keranjang
            </button>
        </div>
    </aside>

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
                        <div class="logo-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                        <span>Edu<span class="highlight">Store</span></span>
                    </a>
                    <p>Platform e-commerce katalog produk modern dengan integrasi CRUD MySQL dan Keranjang Belanja untuk tugas Bootcamp Eduwork.</p>
                </div>

                <div class="footer-col">
                    <h4>Fitur Tugas Sesi 9</h4>
                    <ul>
                        <li><a href="#katalog">Katalog Produk (Read)</a></li>
                        <li><a href="create.php">Form Tambah Produk (Create)</a></li>
                        <li><a href="#katalog">Edit & Hapus (Update & Delete)</a></li>
                        <li><a href="javascript:void(0)" onclick="document.getElementById('cartBtn').click()">Keranjang Belanja (Cart)</a></li>
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
                    <h4>Teknologi Digunakan</h4>
                    <ul>
                        <li><a href="#">PHP 8.x</a></li>
                        <li><a href="#">MySQL Database</a></li>
                        <li><a href="#">Modern Vanilla CSS</a></li>
                        <li><a href="#">JavaScript Interactivity</a></li>
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
                    <span class="tech-badge">JavaScript</span>
                    <span class="tech-badge">PHP MySQL</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Frontend Script (Cart & UI) -->
    <script src="script.js"></script>
</body>
</html>
