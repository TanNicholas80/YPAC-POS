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
            <h3 class="font-bold text-gray-900 text-sm flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                    <i data-lucide="user" class="w-4 h-4 text-[#0073E2]"></i>
                    <span>Informasi Pemesan</span>
                </div>
            </h3>
            <div class="space-y-3.5">
                <!-- Nama Lengkap (Wajib) -->
                <div>
                    <label for="customer-name"
                        class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Nama Lengkap</span>
                        <span class="text-[10px] text-red-500 font-extrabold">(Wajib)</span>
                    </label>
                    <input type="text" id="customer-name" placeholder="Masukkan nama lengkap Anda" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-150 rounded-xl text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800">
                </div>

                <!-- Nomor WhatsApp (Wajib) -->
                <div>
                    <label for="customer-phone"
                        class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Nomor WhatsApp</span>
                        <span class="text-[10px] text-red-500 font-extrabold">(Wajib)</span>
                    </label>
                    <input type="tel" id="customer-phone" placeholder="Contoh: 081234567890" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-150 rounded-xl text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800">
                </div>

                <!-- Alamat Pengiriman (Wajib) -->
                <div>
                    <label for="customer-address"
                        class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Alamat Pengiriman</span>
                        <span class="text-[10px] text-red-500 font-extrabold">(Wajib)</span>
                    </label>
                    <textarea id="customer-address" rows="2" placeholder="Tulis alamat lengkap pengiriman (Jalan, No, RT/RW, Kecamatan, Kota)..." required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-150 rounded-xl text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800 resize-none"></textarea>
                </div>

                <!-- Catatan Tambahan (Opsional) -->
                <div>
                    <label for="customer-notes"
                        class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                        <span>Catatan Tambahan</span>
                        <span class="text-[10px] text-gray-400 font-bold">(Opsional)</span>
                    </label>
                    <textarea id="customer-notes" rows="2" placeholder="Catatan tambahan untuk pesanan/penjual..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-150 rounded-xl text-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-semibold text-gray-800 resize-none"></textarea>
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
            <div class="border-t border-gray-200/60 my-2 pt-2 flex items-baseline justify-between">
                <span class="text-base font-extrabold text-gray-900">Total Pembayaran</span>
                <span id="cart-total" class="text-xl font-extrabold text-[#0073E2]">Rp 0</span>
            </div>
            
            <!-- Shipping Estimation & Ongkir Disclaimer Box -->
            <div class="p-3 bg-amber-50/90 border border-amber-200 rounded-2xl space-y-1 text-left">
                <div class="flex items-center gap-1.5 text-amber-900 font-extrabold text-xs">
                    <i data-lucide="clock" class="w-4 h-4 text-amber-600 shrink-0"></i>
                    <span>Estimasi Pengiriman: 1 - 2 Minggu</span>
                </div>
                <p class="text-[11px] text-amber-800 font-medium leading-snug">
                    * Total di atas <strong>belum termasuk biaya Ongkos Kirim (Ongkir)</strong>.
                </p>
            </div>
        </div>

        <!-- Continue to Payment Modal Trigger -->
        <button onclick="openCustomerPaymentModal()"
            class="w-full py-4 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-blue-100 hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2.5 text-base cursor-pointer">
            <span>Lanjut ke Pembayaran</span>
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </button>
    </div>
</div>

<!-- Customer Payment Selection & Proof Upload Modal -->
<div id="customer-payment-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-gray-100 shadow-2xl relative animate-in fade-in zoom-in duration-200 my-8 space-y-5">
        <!-- Close Button -->
        <button onclick="closeCustomerPaymentModal()" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition-colors p-1.5 rounded-lg hover:bg-gray-50 cursor-pointer">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <div>
            <span class="text-xs font-bold text-[#0073E2] tracking-wider uppercase">Langkah 2 dari 2</span>
            <h3 class="text-xl font-extrabold text-gray-900 leading-tight">Pembayaran & Bukti Transfer</h3>
            <p class="text-xs text-gray-500 mt-1">Pilih metode pembayaran di bawah, lakukan transfer, lalu unggah bukti transaksi Anda.</p>
        </div>

        <!-- Shipping & Ongkir Disclaimer Box inside Modal -->
        <div class="bg-amber-50/90 border border-amber-200 p-3.5 rounded-2xl flex items-start gap-2.5 text-left">
            <i data-lucide="info" class="w-4.5 h-4.5 text-amber-600 shrink-0 mt-0.5"></i>
            <div class="text-[11px] text-amber-900 space-y-0.5 leading-snug">
                <span class="font-extrabold block">Catatan Pengiriman:</span>
                <p>1. Estimasi pengiriman produk karya siswa: <strong>1 - 2 Minggu</strong>.</p>
                <p>2. Biaya Subtotal & PPN 10% di atas <strong>belum termasuk biaya Ongkos Kirim (Ongkir)</strong>.</p>
            </div>
        </div>

        <!-- Total Summary Box -->
        <div class="bg-blue-50/60 border border-blue-100 p-4 rounded-2xl flex items-center justify-between">
            <div>
                <span class="text-xs text-gray-500 font-semibold block">Total yang Harus Dibayar:</span>
                <span id="modal-total-amount" class="text-xl font-extrabold text-[#0073E2]">Rp 0</span>
            </div>
            <div class="text-right text-[10px] text-gray-400 font-semibold">
                *(Sudah Termasuk PPN 10%)
            </div>
        </div>

        <!-- Payment Method Tabs -->
        <div class="space-y-3">
            <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block">Pilih Metode Pembayaran</label>
            
            <div class="grid grid-cols-2 gap-3">
                <!-- Bank Jateng Selection Option -->
                <button type="button" onclick="selectPaymentMethodTab('transfer_bank')" id="tab-btn-bank"
                    class="payment-method-tab p-3.5 border-2 border-[#0073E2] bg-blue-50/40 rounded-2xl flex flex-col items-center justify-center gap-1.5 transition-all cursor-pointer">
                    <i data-lucide="building-2" class="w-6 h-6 text-[#0073E2]"></i>
                    <span class="font-extrabold text-xs text-gray-800">Bank Jateng</span>
                </button>

                <!-- QRIS Selection Option -->
                <button type="button" onclick="selectPaymentMethodTab('qris')" id="tab-btn-qris"
                    class="payment-method-tab p-3.5 border-2 border-gray-150 bg-white rounded-2xl flex flex-col items-center justify-center gap-1.5 transition-all cursor-pointer hover:border-gray-300">
                    <i data-lucide="qr-code" class="w-6 h-6 text-gray-500"></i>
                    <span class="font-extrabold text-xs text-gray-800">QRIS Code</span>
                </button>
            </div>
        </div>

        <!-- Bank Transfer Information Card -->
        <div id="payment-info-bank" class="bg-gray-50 border border-gray-150 p-4 rounded-2xl space-y-3">
            <div class="flex items-center justify-between border-b border-gray-200/60 pb-2.5">
                <span class="text-xs font-bold text-gray-500">Nama Bank</span>
                <span class="text-xs font-extrabold text-gray-800">B Jateng (Bank Jateng)</span>
            </div>
            <div class="flex items-center justify-between border-b border-gray-200/60 pb-2.5">
                <span class="text-xs font-bold text-gray-500">No. Rekening</span>
                <div class="flex items-center gap-2">
                    <span id="bank-norek" class="text-sm font-extrabold text-[#0073E2]">2088049139</span>
                    <button type="button" onclick="copyNorek()" title="Salin No. Rekening" class="p-1 text-gray-400 hover:text-[#0073E2] transition-colors cursor-pointer">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500">Atas Nama</span>
                <span class="text-xs font-extrabold text-gray-800">YPAC Semarang</span>
            </div>
        </div>

        <!-- QRIS Information Card -->
        <div id="payment-info-qris" class="hidden bg-gray-50 border border-gray-150 p-4 rounded-2xl text-center space-y-3">
            <div class="w-36 h-36 mx-auto bg-white p-2 border border-gray-200 rounded-xl shadow-xs flex items-center justify-center">
                <i data-lucide="qr-code" class="w-24 h-24 text-gray-800"></i>
            </div>
            <p class="text-xs font-semibold text-gray-600">Scan QRIS menggunakan aplikasi E-Wallet (Gopay, OVO, Dana, ShopeePay) atau Mobile Banking Anda.</p>
        </div>

        <!-- Upload Proof Input -->
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-700 uppercase tracking-wider block">Unggah Bukti Transfer / Pembayaran <span class="text-red-500">*</span></label>
            <div class="relative">
                <input type="file" id="payment-proof-input" accept="image/*" onchange="previewProofImage(this)"
                    class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-[#0073E2] hover:file:bg-blue-100 transition-all cursor-pointer bg-gray-50 border border-gray-200 rounded-2xl">
            </div>
            <div id="proof-preview-container" class="hidden mt-2 relative w-24 h-24 rounded-xl overflow-hidden border border-gray-200">
                <img id="proof-preview-img" src="" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Submit Action Button -->
        <button type="button" id="btn-submit-order" onclick="submitOrderWithProof()"
            class="w-full py-4 bg-[#25D366] hover:bg-[#20ba5a] active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-green-100 hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2 text-base cursor-pointer">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span>Konfirmasi & Kirim Pesanan</span>
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
    let selectedPaymentMethod = 'transfer_bank';

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

    // Add Product / Variant to Cart
    function addToCart(id, name, price, image, qty = 1, variantId = null, variantName = null) {
        const cartKey = variantId ? `${id}_v${variantId}` : `${id}`;
        const existingItem = cart.find(item => item.cartKey === cartKey);

        if (existingItem) {
            existingItem.qty += qty;
        } else {
            cart.push({
                cartKey: cartKey,
                id: id,
                variantId: variantId,
                variantName: variantName,
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
    function updateQty(cartKey, delta) {
        const item = cart.find(item => item.cartKey === cartKey || item.id === cartKey);
        if (!item) return;

        item.qty += delta;

        if (item.qty <= 0) {
            cart = cart.filter(i => (i.cartKey || i.id) !== cartKey);
        }

        saveCart();
    }

    // Remove item from cart
    function removeFromCart(cartKey) {
        cart = cart.filter(i => (i.cartKey || i.id) !== cartKey);
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

        if (totalItemsCount > 0 && badge) {
            badge.textContent = totalItemsCount;
            badge.classList.remove('scale-0');
            badge.classList.add('scale-100');
        } else if (badge) {
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

                const itemKey = item.cartKey || item.id;
                const itemEl = document.createElement('div');
                itemEl.className = 'flex items-center gap-4 bg-[#F8FAFC] border border-gray-100 p-3 rounded-2xl';
                itemEl.innerHTML = `
                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-50 border border-gray-100 flex-shrink-0">
                        <img src="${item.image}" alt="${item.name}" class="object-cover w-full h-full" loading="lazy">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-gray-900 truncate leading-snug">${item.name}</h4>
                        <p class="text-xs text-gray-500 mt-0.5">${formatIDR(item.price)}</p>
                        
                        <div class="flex items-center gap-3 mt-2">
                            <button onclick="updateQty('${itemKey}', -1)" class="w-7 h-7 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-100 font-bold text-sm transition-colors cursor-pointer">-</button>
                            <span class="text-xs font-bold text-gray-800">${item.qty}</span>
                            <button onclick="updateQty('${itemKey}', 1)" class="w-7 h-7 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-100 font-bold text-sm transition-colors cursor-pointer">+</button>
                        </div>
                    </div>
                    <div class="text-right flex flex-col justify-between items-end h-16">
                        <button onclick="removeFromCart('${itemKey}')" class="p-1 text-gray-400 hover:text-red-500 transition-colors cursor-pointer" aria-label="Hapus item">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                        <span class="text-sm font-extrabold text-gray-900">${formatIDR(itemSubtotal)}</span>
                    </div>
                `;
                itemsList.appendChild(itemEl);
            });

            const tax = subtotal * 0.10;
            const total = subtotal + tax;

            subtotalText.textContent = formatIDR(subtotal);
            document.getElementById('cart-ppn').textContent = formatIDR(tax);
            totalText.textContent = formatIDR(total);

            if (document.getElementById('modal-total-amount')) {
                document.getElementById('modal-total-amount').textContent = formatIDR(total);
            }

            lucide.createIcons();
        }
    }

    // Payment Modal Functions
    function openCustomerPaymentModal() {
        const customerName = document.getElementById('customer-name').value.trim();
        const customerPhone = document.getElementById('customer-phone').value.trim();
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

        if (!customerPhone) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Silakan masukkan nomor WhatsApp Anda.',
                icon: 'warning',
                confirmButtonColor: '#0073E2',
                customClass: { popup: 'rounded-3xl' }
            });
            document.getElementById('customer-phone').focus();
            return;
        }

        if (!customerAddress) {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Silakan masukkan alamat pengiriman Anda.',
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

        const modal = document.getElementById('customer-payment-modal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeCustomerPaymentModal() {
        const modal = document.getElementById('customer-payment-modal');
        if (modal) modal.classList.add('hidden');
    }

    function selectPaymentMethodTab(method) {
        selectedPaymentMethod = method;
        const btnBank = document.getElementById('tab-btn-bank');
        const btnQris = document.getElementById('tab-btn-qris');
        const infoBank = document.getElementById('payment-info-bank');
        const infoQris = document.getElementById('payment-info-qris');

        if (method === 'transfer_bank') {
            btnBank.className = 'payment-method-tab p-3.5 border-2 border-[#0073E2] bg-blue-50/40 rounded-2xl flex flex-col items-center justify-center gap-1.5 transition-all cursor-pointer';
            btnQris.className = 'payment-method-tab p-3.5 border-2 border-gray-150 bg-white rounded-2xl flex flex-col items-center justify-center gap-1.5 transition-all cursor-pointer hover:border-gray-300';
            infoBank.classList.remove('hidden');
            infoQris.classList.add('hidden');
        } else {
            btnQris.className = 'payment-method-tab p-3.5 border-2 border-[#0073E2] bg-blue-50/40 rounded-2xl flex flex-col items-center justify-center gap-1.5 transition-all cursor-pointer';
            btnBank.className = 'payment-method-tab p-3.5 border-2 border-gray-150 bg-white rounded-2xl flex flex-col items-center justify-center gap-1.5 transition-all cursor-pointer hover:border-gray-300';
            infoQris.classList.remove('hidden');
            infoBank.classList.add('hidden');
        }
    }

    function copyNorek() {
        navigator.clipboard.writeText('2088049139');
        Swal.fire({
            title: 'Disalin!',
            text: 'Nomor Rekening Bank Jateng (2088049139) berhasil disalin.',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false,
            customClass: { popup: 'rounded-3xl' }
        });
    }

    function previewProofImage(input) {
        const container = document.getElementById('proof-preview-container');
        const img = document.getElementById('proof-preview-img');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            container.classList.add('hidden');
        }
    }

    // Submit Order with Payment Proof
    function submitOrderWithProof() {
        const customerName = document.getElementById('customer-name').value.trim();
        const customerPhone = document.getElementById('customer-phone').value.trim();
        const customerAddress = document.getElementById('customer-address').value.trim();
        const customerNotes = document.getElementById('customer-notes').value.trim();
        const proofInput = document.getElementById('payment-proof-input');

        if (!proofInput.files || proofInput.files.length === 0) {
            Swal.fire({
                title: 'Bukti Pembayaran Diperlukan',
                text: 'Silakan unggah foto/screenshot bukti transfer terlebih dahulu.',
                icon: 'warning',
                confirmButtonColor: '#0073E2',
                customClass: { popup: 'rounded-3xl' }
            });
            return;
        }

        const btn = document.getElementById('btn-submit-order');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> <span>Mengirim & Mengunggah...</span>`;
        if (window.lucide) lucide.createIcons();

        const formData = new FormData();
        formData.append('customer_name', customerName);
        formData.append('customer_phone', customerPhone);
        formData.append('customer_address', customerAddress);
        formData.append('customer_notes', customerNotes);
        formData.append('payment_method', selectedPaymentMethod);
        formData.append('payment_proof', proofInput.files[0]);

        cart.forEach((item, index) => {
            formData.append(`items[${index}][product_id]`, item.id);
            if (item.variantId) {
                formData.append(`items[${index}][product_variant_id]`, item.variantId);
            }
            formData.append(`items[${index}][qty]`, item.qty);
        });

        fetch('/checkout/whatsapp', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeCustomerPaymentModal();
                toggleCart(false);

                // Clear Cart
                cart = [];
                saveCart();

                // Reset Fields
                document.getElementById('customer-name').value = '';
                document.getElementById('customer-address').value = '';
                proofInput.value = '';
                document.getElementById('proof-preview-container').classList.add('hidden');

                // Show Success SweetAlert with direct WhatsApp action
                Swal.fire({
                    title: 'Pesanan & Bukti Pembayaran Diterima!',
                    html: `
                        <div class="space-y-3 text-left">
                            <p class="text-xs text-gray-600 text-center">Nomor Invoice Anda:</p>
                            <div class="bg-blue-50 p-2.5 rounded-xl text-center font-extrabold text-sm text-[#0073E2] border border-blue-100">${data.invoice_number}</div>
                            <p class="text-xs text-gray-500 text-center">Bukti transfer Anda telah berhasil kami terima. Silakan klik tombol di bawah untuk konfirmasi ke WhatsApp Admin agar pesanan segera diproses & dikirim!</p>
                        </div>
                    `,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#25D366',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: '<i class="fab fa-whatsapp"></i> Chat Admin WhatsApp',
                    cancelButtonText: 'Tutup',
                    customClass: { popup: 'rounded-3xl' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(data.whatsapp_url, '_blank');
                    }
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                title: 'Gagal!',
                text: err.message || 'Terjadi kesalahan saat mengunggah bukti pembayaran. Silakan coba lagi.',
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
