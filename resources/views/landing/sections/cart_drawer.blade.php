<!-- Shopping Cart Slide-over Sidebar Drawer -->
<div id="cart-drawer-overlay" onclick="toggleCart(false)"
    class="fixed inset-0 bg-black/50 backdrop-blur-xs z-50 opacity-0 pointer-events-none transition-opacity duration-300">
</div>

<div id="cart-drawer"
    class="fixed top-0 right-0 bottom-0 w-full sm:w-96 md:w-[450px] bg-white shadow-2xl z-50 translate-x-full transition-transform duration-300 ease-out flex flex-col justify-between">
    <!-- Drawer Header -->
    <div class="p-6 border-b border-gray-100 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-2">
            <i data-lucide="shopping-bag" class="w-5 h-5 text-[#0073E2]"></i>
            <h2 class="text-lg font-extrabold text-gray-900">Keranjang Belanja</h2>
        </div>
        <button onclick="toggleCart(false)"
            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-xl transition-colors cursor-pointer">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <!-- Drawer Content (Scrollable Items) -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
        <!-- Empty State -->
        <div id="cart-empty-state"
            class="flex flex-col items-center justify-center h-full text-center space-y-4 py-8">
            <div
                class="w-16 h-16 rounded-2xl bg-blue-50 text-[#0073E2] flex items-center justify-center shadow-inner">
                <i data-lucide="shopping-cart" class="w-8 h-8"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 text-base">Keranjang Anda Kosong</h3>
                <p class="text-xs text-gray-400 mt-1 max-w-[200px]">Belum ada produk yang ditambahkan. Silakan pilih
                    produk favorit Anda!</p>
            </div>
            <button onclick="toggleCart(false)"
                class="px-5 py-2.5 bg-gray-50 hover:bg-blue-50 text-[#0073E2] hover:text-blue-700 font-bold text-xs rounded-xl border border-blue-100 transition-colors cursor-pointer">
                Mulai Belanja
            </button>
        </div>

        <!-- Cart Items Wrapper -->
        <div id="cart-items-list" class="space-y-4 hidden">
            <!-- Dynamically injected via JS -->
        </div>

        <!-- Checkout Customer Information Form -->
        <div id="cart-form-section" class="border-t border-gray-100 pt-6 space-y-4 hidden">
            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-1.5">
                <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                <span>Informasi Pemesan</span>
            </h3>
            <div class="space-y-3">
                <div>
                    <label for="customer-name"
                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama
                        Lengkap</label>
                    <input type="text" id="customer-name" placeholder="Masukkan nama lengkap Anda"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800">
                </div>
                <div>
                    <label for="customer-address"
                        class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alamat
                        Pengiriman & Catatan</label>
                    <textarea id="customer-address" rows="3"
                        placeholder="Tulis alamat lengkap pengiriman & catatan tambahan jika ada..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800 resize-none"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div id="cart-footer-section" class="p-6 border-t border-gray-100 space-y-4 bg-gray-50/50 flex-shrink-0 hidden">
        <div class="space-y-2">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500 font-semibold">Subtotal</span>
                <span id="cart-subtotal" class="font-extrabold text-gray-900">Rp 0</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500 font-semibold">PPN (10%)</span>
                <span id="cart-ppn" class="font-extrabold text-gray-900">Rp 0</span>
            </div>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-500 font-semibold">Ongkos Kirim</span>
                <span id="cart-shipping" class="font-extrabold text-gray-900">Rp 15.000</span>
            </div>
            <div class="border-t border-gray-200/60 my-2 pt-2 flex items-baseline justify-between">
                <span class="text-base font-extrabold text-gray-900">Total Pembayaran</span>
                <span id="cart-total" class="text-xl font-extrabold text-[#0073E2]">Rp 0</span>
            </div>
        </div>

        <!-- WhatsApp Checkout Trigger Button -->
        <button onclick="checkoutWhatsApp()"
            class="w-full py-4 bg-[#25D366] hover:bg-[#20ba5a] active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-green-100 hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2.5 text-base cursor-pointer">
            <i data-lucide="message-circle" class="w-5.5 h-5.5 fill-white"></i>
            <span>Checkout via WhatsApp</span>
        </button>
    </div>
</div>

<!-- Toast Notification for Adding to Cart -->
<div id="toast"
    class="fixed bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-900/95 backdrop-blur-xs text-white px-6 py-3.5 rounded-2xl shadow-xl z-50 text-sm font-semibold flex items-center gap-2 opacity-0 pointer-events-none transition-all duration-300">
    <i data-lucide="check-circle" class="w-5 h-5 text-green-400"></i>
    <span id="toast-message">Produk berhasil ditambahkan!</span>
</div>

<!-- Client-Side Shopping Cart Script -->
<script>
    // Mobile Menu Toggle
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('mobile-menu-icon');
        menu.classList.toggle('hidden');

        if (menu.classList.contains('hidden')) {
            icon.setAttribute('data-lucide', 'menu');
        } else {
            icon.setAttribute('data-lucide', 'x');
        }
        lucide.createIcons();
    }

    // Cart State Management
    let cart = [];

    // Load cart from localStorage on page load
    document.addEventListener('DOMContentLoaded', () => {
        const savedCart = localStorage.getItem('kube_ypac_cart');
        if (savedCart) {
            try {
                cart = JSON.parse(savedCart);
            } catch (e) {
                cart = [];
            }
        }
        updateCartUI();
    });

    // Save cart to localStorage
    function saveCart() {
        localStorage.setItem('kube_ypac_cart', JSON.stringify(cart));
        updateCartUI();
    }

    // Open/Close Cart Drawer
    function toggleCart(isOpen) {
        const drawer = document.getElementById('cart-drawer');
        const overlay = document.getElementById('cart-drawer-overlay');

        if (isOpen) {
            drawer.classList.remove('translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            document.body.classList.add('overflow-hidden');
        } else {
            drawer.classList.add('translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Add Product to Cart
    function addToCart(id, name, price, image, qty = 1) {
        const existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            existingItem.qty += qty;
        } else {
            cart.push({
                id: id,
                name: name,
                price: parseFloat(price),
                image: image,
                qty: qty
            });
        }

        saveCart();
        showToast(`"${name}" berhasil ditambahkan ke keranjang!`);
    }

    // Update quantity of an item
    function updateQty(id, delta) {
        const item = cart.find(item => item.id === id);
        if (!item) return;

        item.qty += delta;

        if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== id);
        }

        saveCart();
    }

    // Remove item from cart
    function removeFromCart(id) {
        cart = cart.filter(i => i.id !== id);
        saveCart();
    }

    // Show Toast Notification
    function showToast(message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        toastMessage.textContent = message;
        toast.classList.remove('opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-[-8px]');

        setTimeout(() => {
            toast.classList.add('opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-[-8px]');
        }, 3000);
    }

    // Format number as IDR Currency
    function formatIDR(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(number);
    }

    // Update Cart Drawer UI
    function updateCartUI() {
        const badge = document.getElementById('cart-badge');
        const emptyState = document.getElementById('cart-empty-state');
        const itemsList = document.getElementById('cart-items-list');
        const formSection = document.getElementById('cart-form-section');
        const footerSection = document.getElementById('cart-footer-section');
        const subtotalText = document.getElementById('cart-subtotal');
        const totalText = document.getElementById('cart-total');

        const totalItemsCount = cart.reduce((sum, item) => sum + item.qty, 0);

        if (totalItemsCount > 0) {
            badge.textContent = totalItemsCount;
            badge.classList.remove('scale-0');
            badge.classList.add('scale-100');
        } else {
            badge.classList.remove('scale-100');
            badge.classList.add('scale-0');
        }

        if (cart.length === 0) {
            emptyState.classList.remove('hidden');
            itemsList.classList.add('hidden');
            formSection.classList.add('hidden');
            footerSection.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            itemsList.classList.remove('hidden');
            formSection.classList.remove('hidden');
            footerSection.classList.remove('hidden');

            itemsList.innerHTML = '';
            let subtotal = 0;

            cart.forEach(item => {
                const itemSubtotal = item.price * item.qty;
                subtotal += itemSubtotal;

                const itemEl = document.createElement('div');
                itemEl.className = 'flex items-center gap-4 bg-[#F8FAFC] border border-gray-100 p-3 rounded-2xl';
                itemEl.innerHTML = `
                    <!-- Product thumbnail -->
                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 flex-shrink-0">
                        <img src="${item.image}" alt="${item.name}" class="object-cover w-full h-full" loading="lazy">
                    </div>
                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-gray-900 truncate leading-snug">${item.name}</h4>
                        <p class="text-xs text-gray-500 mt-0.5">${formatIDR(item.price)}</p>
                        
                        <!-- Quantity adjuster -->
                        <div class="flex items-center gap-3 mt-2">
                            <button onclick="updateQty(${item.id}, -1)" class="w-7 h-7 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-100 font-bold text-sm transition-colors cursor-pointer">-</button>
                            <span class="text-xs font-bold text-gray-800">${item.qty}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="w-7 h-7 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-100 font-bold text-sm transition-colors cursor-pointer">+</button>
                        </div>
                    </div>
                    <!-- Delete and Subtotal -->
                    <div class="text-right flex flex-col justify-between items-end h-16">
                        <button onclick="removeFromCart(${item.id})" class="p-1 text-gray-400 hover:text-red-500 transition-colors cursor-pointer" aria-label="Hapus item">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                        <span class="text-sm font-extrabold text-gray-900">${formatIDR(itemSubtotal)}</span>
                    </div>
                `;
                itemsList.appendChild(itemEl);
            });

            const tax = subtotal * 0.10;
            const shipping = 15000;
            const total = subtotal + tax + shipping;

            subtotalText.textContent = formatIDR(subtotal);
            document.getElementById('cart-ppn').textContent = formatIDR(tax);
            document.getElementById('cart-shipping').textContent = formatIDR(shipping);
            totalText.textContent = formatIDR(total);

            lucide.createIcons();
        }
    }

    // WhatsApp Checkout Message Construction
    function checkoutWhatsApp() {
        const customerName = document.getElementById('customer-name').value.trim();
        const customerAddress = document.getElementById('customer-address').value.trim();

        if (!customerName) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Silakan masukkan nama lengkap Anda terlebih dahulu.',
                icon: 'warning',
                confirmButtonColor: '#0073E2',
                customClass: { popup: 'rounded-3xl' }
            });
            document.getElementById('customer-name').focus();
            return;
        }

        if (!customerAddress) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Silakan masukkan alamat pengiriman / catatan pesanan.',
                icon: 'warning',
                confirmButtonColor: '#0073E2',
                customClass: { popup: 'rounded-3xl' }
            });
            document.getElementById('customer-address').focus();
            return;
        }

        if (cart.length === 0) {
            Swal.fire({
                title: 'Keranjang Kosong',
                text: 'Keranjang belanja Anda kosong.',
                icon: 'info',
                confirmButtonColor: '#0073E2',
                customClass: { popup: 'rounded-3xl' }
            });
            return;
        }

        // Show loading state
        const btn = document.querySelector('button[onclick="checkoutWhatsApp()"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i data-lucide="loader-2" class="w-5.5 h-5.5 animate-spin"></i> <span>Memproses...</span>`;
        if (window.lucide) lucide.createIcons();

        const payload = {
            customer_name: customerName,
            customer_address: customerAddress,
            items: cart.map(item => ({
                product_id: item.id,
                qty: item.qty
            }))
        };

        fetch('/checkout/whatsapp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const whatsappNumber = '6281234567890';
                let message = `*PESANAN BARU - KUBE YPAC*\n`;
                message += `*Nomor Invoice:* ${data.invoice_number}\n`;
                message += `--------------------------------------\n`;
                message += `*Nama Pemesan:* ${customerName}\n`;
                message += `*Alamat / Catatan:* ${customerAddress}\n`;
                message += `--------------------------------------\n\n`;
                message += `*Detail Belanja:*\n`;

                cart.forEach((item, index) => {
                    const subtotal = item.price * item.qty;
                    message += `${index + 1}. *${item.name}* (${item.qty}x) @ ${formatIDR(item.price)}\n`;
                    message += `   Subtotal: ${formatIDR(subtotal)}\n`;
                });

                message += `\n--------------------------------------\n`;
                message += `*Subtotal:* ${formatIDR(data.subtotal)}\n`;
                message += `*PPN (10%):* ${formatIDR(data.tax)}\n`;
                message += `*Ongkos Kirim:* ${formatIDR(data.shipping_cost)}\n`;
                message += `--------------------------------------\n`;
                message += `*Total Pembayaran:* ${formatIDR(data.total)}\n`;
                message += `--------------------------------------\n\n`;
                message += `Mohon segera diproses ya admin. Terima kasih!`;

                const encodedText = encodeURIComponent(message);
                const waUrl = `https://wa.me/${whatsappNumber}?text=${encodedText}`;

                window.open(waUrl, '_blank');

                // Clear cart
                cart = [];
                saveCart();
                toggleCart(false);

                // Reset fields
                document.getElementById('customer-name').value = '';
                document.getElementById('customer-address').value = '';

                Swal.fire({
                    title: 'Pesanan Berhasil!',
                    text: 'Pesanan Anda berhasil dicatat dan sedang dialihkan ke WhatsApp. Silakan kirim chat tersebut untuk memproses pembayaran.',
                    icon: 'success',
                    confirmButtonColor: '#0073E2',
                    customClass: { popup: 'rounded-3xl' }
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                title: 'Gagal!',
                text: err.message || 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.',
                icon: 'error',
                confirmButtonColor: '#0073E2',
                customClass: { popup: 'rounded-3xl' }
            });
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
            if (window.lucide) lucide.createIcons();
        });
    }

    // Share Page Functionality
    function sharePage() {
        if (navigator.share) {
            navigator.share({
                title: 'KUBE YPAC - Produk Kreatif Karya Anak Disabilitas',
                text: 'Dukung kemandirian siswa disabilitas dengan berbelanja kerajinan dan kudapan lezat di KUBE YPAC.',
                url: window.location.href
            }).catch(err => {
                console.log('Error sharing:', err);
            });
        } else {
            const dummy = document.createElement('input');
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            Swal.fire({
                title: 'Disalin!',
                text: 'Tautan halaman berhasil disalin ke clipboard! Silakan bagikan ke teman-teman Anda.',
                icon: 'success',
                confirmButtonColor: '#0073E2',
                customClass: { popup: 'rounded-3xl' }
            });
        }
    }
</script>
