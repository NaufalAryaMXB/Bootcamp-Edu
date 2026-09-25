/*
 * TUGAS 5 edu
 */
const products = [
    {
        id: 1,
        name: "Mechanical Keyboard Wireless RGB",
        price: 850000,
        description: "Keyboard mekanikal 75% layout dengan koneksi 3-mode (Bluetooth, 2.4G, Type-C) dan hot-swappable switches.",
        image: "https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=80",
        category: "Aksesoris",
        badge: "Best Seller",
        rating: 4.9,
        reviews: 142
    },
    {
        id: 2,
        name: "Smartwatch Ultra Pro AMOLED",
        price: 1250000,
        description: "Jam tangan pintar dengan layar Always-On AMOLED, sensor detak jantung 24/7, SpO2, dan baterai tahan 14 hari.",
        image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80",
        category: "Wearable",
        badge: "Populer",
        rating: 4.8,
        reviews: 98
    },
    {
        id: 3,
        name: "Wireless Noise-Cancelling Headphones",
        price: 1799000,
        description: "Headphone over-ear dengan Active Noise Cancelling (ANC) tingkat tinggi dan kualitas audio Hi-Res lossless.",
        image: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80",
        category: "Audio",
        badge: "Top Rated",
        rating: 5.0,
        reviews: 215
    },
    {
        id: 4,
        name: "Ergonomic Wireless Gaming Mouse",
        price: 450000,
        description: "Mouse nirkabel presisi tinggi dengan sensor optik 16000 DPI, ultra-lightweight, dan tombol makro terprogram.",
        image: "https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=600&q=80",
        category: "Aksesoris",
        badge: "Hemat",
        rating: 4.7,
        reviews: 87
    },
    {
        id: 5,
        name: "True Wireless Earbuds ANC",
        price: 699000,
        description: "TWS dengan driver dinamis 10mm, ketahanan air IPX5, mikrofon ganda jernih, dan low-latency gaming mode.",
        image: "https://images.unsplash.com/photo-1590658268037-6bf12165a8df?auto=format&fit=crop&w=600&q=80",
        category: "Audio",
        badge: "Baru",
        rating: 4.6,
        reviews: 64
    },
    {
        id: 6,
        name: "Portable External SSD 1TB NVMe",
        price: 1450000,
        description: "Solid State Drive eksternal super kencang dengan kecepatan transfer hingga 1050 MB/s dan bodi aluminium tangguh.",
        image: "https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?auto=format&fit=crop&w=600&q=80",
        category: "Gadget",
        badge: "Rekomendasi",
        rating: 4.9,
        reviews: 178
    },
    {
        id: 7,
        name: "Smart Fitness Band Waterproof",
        price: 380000,
        description: "Gelang kebugaran pintar dengan pelacak langkah, monitoring tidur, 30+ mode olahraga, dan tahan air hingga 50 meter.",
        image: "https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?auto=format&fit=crop&w=600&q=80",
        category: "Wearable",
        badge: "Promo",
        rating: 4.5,
        reviews: 52
    },
    {
        id: 8,
        name: "Webcam 4K Ultra HD Autofocus",
        price: 890000,
        description: "Kamera web resolusi 4K dengan built-in stereo microphone, lensa wide-angle, dan privacy cover terintegrasi.",
        image: "https://images.unsplash.com/photo-1587826080692-f439cd0b70da?auto=format&fit=crop&w=600&q=80",
        category: "Gadget",
        badge: "Pilihan",
        rating: 4.8,
        reviews: 93
    }
];

// ==============================================================================
// 2. HELPER FUNCTION: FORMAT RUPIAH
// ==============================================================================
function formatRupiah(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    }).format(amount);
}


const productContainer = document.getElementById('productContainer');
const emptyState = document.getElementById('emptyState');


function renderProducts(items) {
    
    productContainer.innerHTML = '';
    if (!items || items.length === 0) {
        emptyState.style.display = 'block';
        return;
    } else {
        emptyState.style.display = 'none';
    }

    items.forEach((product) => {
        const card = document.createElement('div');
        card.className = 'product-card';
        card.setAttribute('data-id', product.id);

        card.innerHTML = `
            <div class="product-img-wrapper">
                <span class="product-badge">${product.badge}</span>
                <span class="product-category-tag">${product.category}</span>
                <img 
                    src="${product.image}" 
                    alt="${product.name}" 
                    class="product-img" 
                    loading="lazy"
                    onerror="this.src='https://via.placeholder.com/600x450?text=Produk+EduStore'"
                >
            </div>
            <div class="product-body">
                <div class="product-rating">
                    <i class="fa-solid fa-star"></i>
                    <span>${product.rating}</span>
                    <span class="rating-score">(${product.reviews})</span>
                </div>
                <h3 class="product-title" title="${product.name}">${product.name}</h3>
                <p class="product-desc" title="${product.description}">${product.description}</p>
                <div class="product-footer">
                    <div class="price-container">
                        <span class="price-label">Harga</span>
                        <span class="product-price">${formatRupiah(product.price)}</span>
                    </div>
                    <button class="btn-buy" onclick="addToCart(${product.id})">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span>Beli</span>
                    </button>
                </div>
            </div>
        `;

        // Menambahkan elemen card ke dalam grid container
        productContainer.appendChild(card);
    });
}

const searchInput = document.getElementById('searchInput');
const filterButtons = document.querySelectorAll('.filter-btn');

let currentCategory = 'all';
let currentSearchQuery = '';

function applyFilterAndSearch() {
    let filtered = products;

    // Filter berdasarkan kategori
    if (currentCategory !== 'all') {
        filtered = filtered.filter(item => item.category === currentCategory);
    }

    // Filter berdasarkan query pencarian
    if (currentSearchQuery.trim() !== '') {
        const query = currentSearchQuery.toLowerCase();
        filtered = filtered.filter(item => 
            item.name.toLowerCase().includes(query) || 
            item.description.toLowerCase().includes(query)
        );
    }

    // Tampilkan ulang hasil filter dengan looping
    renderProducts(filtered);
}

// Event Listener: Filter Kategori
filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Toggle class active pada tombol
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        currentCategory = button.getAttribute('data-category');
        applyFilterAndSearch();
    });
});

// Event Listener: Search Bar Realtime
if (searchInput) {
    searchInput.addEventListener('input', (e) => {
        currentSearchQuery = e.target.value;
        applyFilterAndSearch();
    });
}

let cartCount = 0;
const cartCountElement = document.getElementById('cartCount');
const toastContainer = document.getElementById('toastContainer');

function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 1.1rem;"></i>
        <span>${message}</span>
    `;

    toastContainer.appendChild(toast);


    setTimeout(() => {
        toast.remove();
    }, 3000);
}

function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (product) {
        cartCount++;
        cartCountElement.textContent = cartCount;
        showToast(`<strong>${product.name}</strong> berhasil ditambahkan ke keranjang!`);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Jalankan looping pertama kali untuk menampilkan semua produk
    renderProducts(products);
});
