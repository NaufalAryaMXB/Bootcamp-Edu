/**
 * ==========================================================
 * TUGAS SESI 9 - EDUSTORE FRONTEND SCRIPT (CRUD & CART)
 * ==========================================================
 * File: script.js
 * Deskripsi:
 * - Menangani interaktivitas keranjang belanja (Slide-over Cart Drawer).
 * - Manajemen item keranjang (tambah, kurang, hapus, kosongkan, hitung total).
 * - Modal Quick View, filter kategori, pencarian, dan feedback Toast.
 * ----------------------------------------------------------
 * TIPS PENGEMBANGAN:
 * Script ini menyediakan keranjang frontend berbasis LocalStorage.
 * Anda dapat menghubungkannya ke PHP Session atau API database
 * menggunakan fetch() atau form submission biasa.
 * ==========================================================
 */

document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. STATE & STORAGE KERANJANG BELANJA (CART)
    // ==========================================
    const CART_STORAGE_KEY = 'edustore_sesi9_cart';
    
    // Ambil data keranjang dari LocalStorage browser
    let cart = [];
    try {
        const savedCart = localStorage.getItem(CART_STORAGE_KEY);
        cart = savedCart ? JSON.parse(savedCart) : [];
    } catch (e) {
        cart = [];
    }

    // ==========================================
    // 2. ELEMEN DOM UTAMA
    // ==========================================
    // Cart Drawer Elements
    const cartBtn = document.getElementById('cartBtn');
    const cartBadge = document.getElementById('cartBadge');
    const cartDrawer = document.getElementById('cartDrawer');
    const cartDrawerOverlay = document.getElementById('cartDrawerOverlay');
    const cartCloseBtn = document.getElementById('cartCloseBtn');
    const cartDrawerItems = document.getElementById('cartDrawerItems');
    const cartEmptyState = document.getElementById('cartEmptyState');
    const cartDrawerFooter = document.getElementById('cartDrawerFooter');
    const cartDrawerCount = document.getElementById('cartDrawerCount');
    const cartSubtotalEl = document.getElementById('cartSubtotal');
    const cartTotalEl = document.getElementById('cartTotal');
    const cartClearBtn = document.getElementById('cartClearBtn');
    const cartCheckoutBtn = document.getElementById('cartCheckoutBtn');

    // Filter & Search Elements
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const categoryButtons = document.querySelectorAll('.filter-btn');
    const sortSelect = document.getElementById('sortSelect');
    const productGrid = document.getElementById('productGrid');
    const productCards = Array.from(document.querySelectorAll('.product-card'));
    const emptyState = document.getElementById('emptyState');
    const visibleCount = document.getElementById('visibleCount');
    const btnResetFilter = document.getElementById('btnResetFilter');
    const toastContainer = document.getElementById('toastContainer');

    // Quick View Modal Elements
    const quickViewModal = document.getElementById('quickViewModal');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    const modalImg = document.getElementById('modalImg');
    const modalCategory = document.getElementById('modalCategory');
    const modalTitle = document.getElementById('modalTitle');
    const modalPrice = document.getElementById('modalPrice');
    const modalDesc = document.getElementById('modalDesc');
    const modalStock = document.getElementById('modalStock');
    const modalAddToCartBtn = document.getElementById('modalAddToCartBtn');

    let currentCategory = 'all';
    let searchQuery = '';
    let activeModalProduct = null;

    // Format Mata Uang Rupiah (Contoh: Rp 799.000)
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    // ==========================================
    // 3. FUNGSI KERANJANG BELANJA (CART OPERATIONS)
    // ==========================================

    // Simpan perubahan ke LocalStorage
    function saveCart() {
        try {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
        } catch (e) {
            console.error('Gagal menyimpan keranjang ke LocalStorage:', e);
        }
    }

    // Update Angka Badge Keranjang di Navbar
    function updateCartBadge() {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        if (cartBadge) {
            cartBadge.textContent = totalItems;
            cartBadge.classList.add('bounce');
            setTimeout(() => cartBadge.classList.remove('bounce'), 300);
        }
        if (cartDrawerCount) {
            cartDrawerCount.textContent = `${totalItems} Produk`;
        }
    }

    // Render Ulang Isi Drawer Keranjang Belanja
    function renderCartDrawer() {
        if (!cartDrawerItems) return;

        // Kosongkan list sebelumnya
        cartDrawerItems.innerHTML = '';

        if (cart.length === 0) {
            if (cartEmptyState) cartEmptyState.style.display = 'flex';
            if (cartDrawerFooter) cartDrawerFooter.style.display = 'none';
        } else {
            if (cartEmptyState) cartEmptyState.style.display = 'none';
            if (cartDrawerFooter) cartDrawerFooter.style.display = 'flex';

            let grandTotal = 0;

            cart.forEach(item => {
                const subtotal = item.price * item.quantity;
                grandTotal += subtotal;

                const itemCard = document.createElement('div');
                itemCard.className = 'cart-item-card';
                itemCard.setAttribute('data-id', item.id);
                itemCard.innerHTML = `
                    <img src="${item.image}" alt="${escapeHtml(item.name)}" class="cart-item-thumb" onerror="this.src='https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80'">
                    <div class="cart-item-info">
                        <h4 class="cart-item-name" title="${escapeHtml(item.name)}">${escapeHtml(item.name)}</h4>
                        <div class="cart-item-price">${formatRupiah(item.price)}</div>
                        <div class="cart-item-bottom">
                            <div class="cart-qty-wrapper">
                                <button type="button" class="cart-qty-btn btn-qty-minus" data-id="${item.id}" title="Kurangi">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <span class="cart-qty-number">${item.quantity}</span>
                                <button type="button" class="cart-qty-btn btn-qty-plus" data-id="${item.id}" title="Tambah">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <button type="button" class="cart-item-remove-btn" data-id="${item.id}" title="Hapus dari keranjang">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                `;
                cartDrawerItems.appendChild(itemCard);
            });

            // Update Total Harga
            if (cartSubtotalEl) cartSubtotalEl.textContent = formatRupiah(grandTotal);
            if (cartTotalEl) cartTotalEl.textContent = formatRupiah(grandTotal);
        }

        updateCartBadge();
    }

    // Tambah Produk ke Keranjang
    function addToCart(product) {
        const existingItem = cart.find(item => item.id === product.id);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price) || 0,
                image: product.image || 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=600&q=80',
                quantity: 1
            });
        }

        saveCart();
        renderCartDrawer();
        showToast(`<strong>"${product.name}"</strong> berhasil ditambahkan ke keranjang!`);
    }

    // Ubah Jumlah Item (Tambah/Kurang)
    function changeItemQuantity(productId, delta) {
        const item = cart.find(i => String(i.id) === String(productId));
        if (!item) return;

        item.quantity += delta;
        if (item.quantity <= 0) {
            cart = cart.filter(i => String(i.id) !== String(productId));
            showToast(`Item dihapus dari keranjang.`);
        }

        saveCart();
        renderCartDrawer();
    }

    // Hapus Satu Item dari Keranjang
    function removeCartItem(productId) {
        const item = cart.find(i => String(i.id) === String(productId));
        const itemName = item ? item.name : 'Produk';
        cart = cart.filter(i => String(i.id) !== String(productId));
        saveCart();
        renderCartDrawer();
        showToast(`<strong>"${itemName}"</strong> dihapus dari keranjang.`);
    }

    // Kosongkan Seluruh Keranjang
    function clearCart() {
        if (cart.length === 0) return;
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang belanja?')) {
            cart = [];
            saveCart();
            renderCartDrawer();
            showToast(`Keranjang belanja telah dikosongkan.`);
        }
    }

    // Buka dan Tutup Slide-Over Drawer
    function openCartDrawer() {
        renderCartDrawer();
        if (cartDrawer) cartDrawer.classList.add('active');
        if (cartDrawerOverlay) cartDrawerOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeCartDrawer() {
        if (cartDrawer) cartDrawer.classList.remove('active');
        if (cartDrawerOverlay) cartDrawerOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // ==========================================
    // 4. EVENT LISTENER KERANJANG
    // ==========================================
    if (cartBtn) {
        cartBtn.addEventListener('click', openCartDrawer);
    }

    if (cartCloseBtn) {
        cartCloseBtn.addEventListener('click', closeCartDrawer);
    }

    if (cartDrawerOverlay) {
        cartDrawerOverlay.addEventListener('click', closeCartDrawer);
    }

    if (cartClearBtn) {
        cartClearBtn.addEventListener('click', clearCart);
    }

    if (cartCheckoutBtn) {
        cartCheckoutBtn.addEventListener('click', () => {
            if (cart.length === 0) return;
            alert(`Terima kasih! Pesanan sejumlah ${cart.reduce((s, i) => s + i.quantity, 0)} produk akan diproses.`);
            clearCart();
            closeCartDrawer();
        });
    }

    // Delegasi Event untuk tombol di dalam Drawer (Qty +/-, Hapus)
    if (cartDrawerItems) {
        cartDrawerItems.addEventListener('click', (e) => {
            const btnPlus = e.target.closest('.btn-qty-plus');
            const btnMinus = e.target.closest('.btn-qty-minus');
            const btnRemove = e.target.closest('.cart-item-remove-btn');

            if (btnPlus) {
                const id = btnPlus.getAttribute('data-id');
                changeItemQuantity(id, 1);
            } else if (btnMinus) {
                const id = btnMinus.getAttribute('data-id');
                changeItemQuantity(id, -1);
            } else if (btnRemove) {
                const id = btnRemove.getAttribute('data-id');
                removeCartItem(id);
            }
        });
    }

    // Tangani klik tombol "Beli / Tambah ke Keranjang" pada kartu produk
    document.addEventListener('click', (e) => {
        const addBtn = e.target.closest('.btn-add-cart');
        if (addBtn && addBtn !== modalAddToCartBtn) {
            const card = addBtn.closest('.product-card');
            const id = addBtn.getAttribute('data-id') || (card ? card.getAttribute('data-id') : Date.now());
            const name = addBtn.getAttribute('data-name') || (card ? card.getAttribute('data-name') : 'Produk');
            const price = addBtn.getAttribute('data-price') || (card ? card.getAttribute('data-price') : 0);
            const image = card ? card.querySelector('.card-img')?.src : '';

            addToCart({
                id: id,
                name: name,
                price: parseFloat(price) || 0,
                image: image
            });
        }
    });

    // ==========================================
    // 5. TOAST FEEDBACK NOTIFICATION
    // ==========================================
    function showToast(messageHtml) {
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <i class="fa-solid fa-circle-check"></i>
            <span>${messageHtml}</span>
        `;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2800);
    }

    // ==========================================
    // 6. QUICK VIEW MODAL
    // ==========================================
    document.addEventListener('click', (e) => {
        const quickBtn = e.target.closest('.btn-quick-view');
        if (quickBtn) {
            const card = quickBtn.closest('.product-card');
            if (card) {
                const id = quickBtn.getAttribute('data-id') || card.getAttribute('data-id');
                const img = card.querySelector('.card-img')?.src || '';
                const category = card.querySelector('.card-category-text')?.textContent || '';
                const title = card.querySelector('.card-title')?.textContent || '';
                const priceText = card.querySelector('.card-price')?.textContent || '';
                const priceNum = card.getAttribute('data-price') || 0;
                const desc = card.querySelector('.card-desc')?.textContent || '';
                const stock = card.querySelector('.card-stock-chip')?.textContent.trim() || 'Stok Tersedia';

                if (modalImg) modalImg.src = img;
                if (modalCategory) modalCategory.textContent = category;
                if (modalTitle) modalTitle.textContent = title;
                if (modalPrice) modalPrice.textContent = priceText;
                if (modalDesc) modalDesc.textContent = desc;
                if (modalStock) modalStock.textContent = stock;

                activeModalProduct = {
                    id: id,
                    name: title,
                    price: priceNum,
                    image: img
                };

                if (quickViewModal) quickViewModal.classList.add('active');
            }
        }
    });

    if (modalAddToCartBtn) {
        modalAddToCartBtn.addEventListener('click', () => {
            if (activeModalProduct) {
                addToCart(activeModalProduct);
                if (quickViewModal) quickViewModal.classList.remove('active');
            }
        });
    }

    if (modalCloseBtn && quickViewModal) {
        modalCloseBtn.addEventListener('click', () => {
            quickViewModal.classList.remove('active');
        });
    }

    if (quickViewModal) {
        quickViewModal.addEventListener('click', (e) => {
            if (e.target === quickViewModal) {
                quickViewModal.classList.remove('active');
            }
        });
    }

    // ==========================================
    // 7. FILTER KATEGORI, PENCARIAN & SORTING
    // ==========================================
    function filterProducts() {
        let matchedCount = 0;

        productCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category') || '';
            const cardName = (card.getAttribute('data-name') || '').toLowerCase();
            const cardDesc = (card.querySelector('.card-desc')?.textContent || '').toLowerCase();

            const matchesCategory = currentCategory === 'all' || cardCategory.toLowerCase() === currentCategory.toLowerCase();
            const matchesSearch = !searchQuery || cardName.includes(searchQuery) || cardDesc.includes(searchQuery);

            if (matchesCategory && matchesSearch) {
                card.style.display = 'flex';
                matchedCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount) {
            visibleCount.textContent = matchedCount;
        }

        if (emptyState) {
            emptyState.style.display = matchedCount === 0 ? 'block' : 'none';
        }
    }

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentCategory = btn.getAttribute('data-category');
            filterProducts();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.trim().toLowerCase();
            if (searchClear) {
                searchClear.style.display = searchQuery.length > 0 ? 'block' : 'none';
            }
            filterProducts();
        });
    }

    if (searchClear) {
        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            searchQuery = '';
            searchClear.style.display = 'none';
            searchInput.focus();
            filterProducts();
        });
    }

    if (btnResetFilter) {
        btnResetFilter.addEventListener('click', () => {
            currentCategory = 'all';
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            if (searchClear) searchClear.style.display = 'none';

            categoryButtons.forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-category') === 'all');
            });

            if (sortSelect) sortSelect.value = 'default';
            filterProducts();
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            const sortVal = e.target.value;
            const sortedCards = [...productCards];

            if (sortVal === 'price-low') {
                sortedCards.sort((a, b) => Number(a.getAttribute('data-price')) - Number(b.getAttribute('data-price')));
            } else if (sortVal === 'price-high') {
                sortedCards.sort((a, b) => Number(b.getAttribute('data-price')) - Number(a.getAttribute('data-price')));
            } else if (sortVal === 'name-asc') {
                sortedCards.sort((a, b) => (a.getAttribute('data-name') || '').localeCompare(b.getAttribute('data-name') || ''));
            } else {
                sortedCards.sort((a, b) => Number(a.getAttribute('data-id')) - Number(b.getAttribute('data-id')));
            }

            sortedCards.forEach(card => {
                if (emptyState) productGrid.insertBefore(card, emptyState);
            });
        });
    }

    // Helper mencegah XSS pada rendering string
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Inisialisasi awal badge keranjang
    updateCartBadge();
});
