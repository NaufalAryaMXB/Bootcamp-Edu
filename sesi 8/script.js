/**
 * ==========================================================
 * TUGAS SESI 8 - EDUSTORE FRONTEND INTERACTIVITY SCRIPT
 * Provides category filtering, real-time search, sorting,
 * quick view modal, and cart toast feedback.
 * ==========================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const categoryButtons = document.querySelectorAll('.filter-btn');
    const sortSelect = document.getElementById('sortSelect');
    const productGrid = document.getElementById('productGrid');
    const productCards = Array.from(document.querySelectorAll('.product-card'));
    const emptyState = document.getElementById('emptyState');
    const visibleCount = document.getElementById('visibleCount');
    const btnResetFilter = document.getElementById('btnResetFilter');
    const cartBadge = document.getElementById('cartBadge');
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
    let cartCount = 0;
    let activeModalProduct = null;

    // Filter & Search Handler
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

        // Update Counter
        if (visibleCount) {
            visibleCount.textContent = matchedCount;
        }

        // Toggle Empty State
        if (emptyState) {
            emptyState.style.display = matchedCount === 0 ? 'block' : 'none';
        }
    }

    // Category Button Click Listener
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            currentCategory = btn.getAttribute('data-category');
            filterProducts();
        });
    });

    // Search Input Listener
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.trim().toLowerCase();
            if (searchClear) {
                searchClear.style.display = searchQuery.length > 0 ? 'block' : 'none';
            }
            filterProducts();
        });
    }

    // Search Clear Button Listener
    if (searchClear) {
        searchClear.addEventListener('click', () => {
            searchInput.value = '';
            searchQuery = '';
            searchClear.style.display = 'none';
            searchInput.focus();
            filterProducts();
        });
    }

    // Reset Filter Button Listener
    if (btnResetFilter) {
        btnResetFilter.addEventListener('click', () => {
            currentCategory = 'all';
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            if (searchClear) searchClear.style.display = 'none';

            categoryButtons.forEach(btn => {
                if (btn.getAttribute('data-category') === 'all') {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            if (sortSelect) sortSelect.value = 'default';
            filterProducts();
        });
    }

    // Sorting Handler
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
                sortedCards.sort((a, b) => Number(a.querySelector('.btn-add-cart')?.getAttribute('data-id')) - Number(b.querySelector('.btn-add-cart')?.getAttribute('data-id')));
            }

            // Re-append sorted cards before emptyState
            sortedCards.forEach(card => productGrid.insertBefore(card, emptyState));
        });
    }

    // Add to Cart Feedback (Toast)
    function showToast(message) {
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <i class="fa-solid fa-circle-check"></i>
            <span>${message}</span>
        `;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 2800);
    }

    function addToCart(productName) {
        cartCount++;
        if (cartBadge) {
            cartBadge.textContent = cartCount;
            cartBadge.classList.add('bounce');
            setTimeout(() => cartBadge.classList.remove('bounce'), 300);
        }
        showToast(`"${productName}" berhasil ditambahkan ke keranjang!`);
    }

    // Listen for add to cart clicks
    document.addEventListener('click', (e) => {
        const addBtn = e.target.closest('.btn-add-cart');
        if (addBtn && addBtn !== modalAddToCartBtn) {
            const productName = addBtn.getAttribute('data-name') || 'Produk';
            addToCart(productName);
        }
    });

    // Quick View Modal
    document.addEventListener('click', (e) => {
        const quickBtn = e.target.closest('.btn-quick-view');
        if (quickBtn) {
            const card = quickBtn.closest('.product-card');
            if (card) {
                const img = card.querySelector('.card-img')?.src || '';
                const category = card.querySelector('.card-category-text')?.textContent || '';
                const title = card.querySelector('.card-title')?.textContent || '';
                const price = card.querySelector('.card-price')?.textContent || '';
                const desc = card.querySelector('.card-desc')?.textContent || '';
                const stock = card.querySelector('.card-stock-chip')?.textContent.trim() || 'Stok Tersedia';

                modalImg.src = img;
                modalCategory.textContent = category;
                modalTitle.textContent = title;
                modalPrice.textContent = price;
                modalDesc.textContent = desc;
                modalStock.textContent = stock;

                activeModalProduct = title;
                quickViewModal.classList.add('active');
            }
        }
    });

    if (modalAddToCartBtn) {
        modalAddToCartBtn.addEventListener('click', () => {
            if (activeModalProduct) {
                addToCart(activeModalProduct);
                quickViewModal.classList.remove('active');
            }
        });
    }

    if (modalCloseBtn) {
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
});
