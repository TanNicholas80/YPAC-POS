@extends('layouts.app')

@section('title', 'Transaksi Penjualan - SIKAS YPAC')

@section('content')
<div class="flex-1 flex overflow-hidden">
    <!-- Left Section: Catalog -->
    <div class="flex-1 flex flex-col p-6 overflow-y-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Transaksi Penjualan</h1>
            <p class="text-sm text-gray-500 font-medium">Pilih produk untuk ditambahkan ke pesanan.</p>
        </div>

        <!-- Validation Errors / Alerts -->
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Category Filters -->
        <div class="flex items-center gap-3 mb-6 overflow-x-auto pb-3 w-full scrollbar-none flex-nowrap shrink-0">
            <button onclick="filterCategory('all')" id="btn-cat-all"
                class="category-btn px-6 py-2.5 rounded-full font-bold text-sm bg-[#0073E2] text-white transition-all shadow-sm flex items-center justify-center shrink-0 h-10 leading-none">
                Semua
            </button>
            @foreach($categories as $category)
                <button onclick="filterCategory('{{ $category->category_slug }}')" id="btn-cat-{{ $category->category_slug }}"
                    class="category-btn px-6 py-2.5 rounded-full font-bold text-sm bg-white border border-gray-100 text-gray-600 hover:bg-gray-50 transition-all flex items-center justify-center shrink-0 h-10 leading-none">
                    {{ $category->category_name }}
                </button>
            @endforeach
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-5" id="product-grid">
            @foreach($products as $product)
                <div class="product-card bg-white border border-gray-100 rounded-3xl p-4 flex flex-col justify-between hover:shadow-lg transition-all duration-300 relative group"
                     data-category="{{ $product->category->category_slug }}">
                    
                    <!-- Stock Alert -->
                    @if($product->stock <= 5)
                        <span class="absolute top-3 left-3 z-10 text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100 px-2 py-0.5 rounded-full">
                            Stok Tipis: {{ $product->stock }}
                        </span>
                    @endif

                    <div>
                        <!-- Product Visual / Placeholder -->
                        <div class="w-full aspect-square rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 mb-4 group-hover:scale-[1.02] transition-transform duration-200 overflow-hidden border border-gray-50">
                            @if($product->images->first())
                                <img src="{{ str_starts_with($product->images->first()->image_path, 'http') ? $product->images->first()->image_path : asset($product->images->first()->image_path) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                            @else
                                @if($product->category->category_slug === 'makanan')
                                    <i data-lucide="cookie" class="w-10 h-10"></i>
                                @elseif($product->category->category_slug === 'minuman')
                                    <i data-lucide="cup-soda" class="w-10 h-10"></i>
                                @else
                                    <i data-lucide="pen-tool" class="w-10 h-10"></i>
                                @endif
                            @endif
                        </div>

                        <!-- Info -->
                        <h3 class="font-bold text-gray-800 text-sm leading-snug group-hover:text-[#0073E2] transition-colors">
                            {{ $product->product_name }}
                        </h3>
                        <span class="text-xs text-gray-400 font-semibold block mt-0.5">
                            {{ $product->category->category_name }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <span class="font-extrabold text-[#0073E2] text-sm">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        
                        <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->product_name) }}', {{ $product->price }}, {{ $product->stock }}, '{{ $product->unit->unit_name ?? 'pcs' }}')"
                                class="w-8 h-8 rounded-full bg-[#0073E2] text-white flex items-center justify-center hover:bg-blue-600 hover:scale-105 active:scale-95 transition-all shadow-sm">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Right Section: Current Cart -->
    <div class="w-96 bg-white border-l border-gray-100 flex flex-col justify-between">
        <!-- Cart Header -->
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-gray-900 text-lg leading-tight">Pesanan Saat Ini</h2>
                <span class="text-xs text-gray-500 font-medium">Kasir: {{ Auth::user()->name }}</span>
            </div>
            <button onclick="clearCart()" class="text-gray-400 hover:text-red-500 transition-colors p-1.5 rounded-lg hover:bg-red-50">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Cart List -->
        <!-- Cart Scroll Container -->
        <div class="flex-1 overflow-y-auto p-6 relative">
            <!-- Empty Cart State -->
            <div id="cart-empty" class="absolute inset-0 flex flex-col items-center justify-center text-center text-gray-400 p-6">
                <i data-lucide="shopping-bag" class="w-12 h-12 mb-3 stroke-[1.5]"></i>
                <p class="text-sm font-semibold">Keranjang masih kosong</p>
                <p class="text-xs mt-1">Pilih produk di sebelah kiri.</p>
            </div>

            <!-- Cart List -->
            <div class="space-y-4" id="cart-list"></div>
        </div>

        <!-- Cart Summary & Actions -->
        <div class="p-6 border-t border-gray-50 bg-gray-50/50 space-y-4">
            <div class="space-y-2">
                <div class="flex justify-between text-sm text-gray-500 font-semibold">
                    <span>Subtotal</span>
                    <span id="cart-subtotal">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm text-gray-500 font-semibold">
                    <span>Pajak (10%)</span>
                    <span id="cart-tax">Rp 0</span>
                </div>
                <div class="border-t border-dashed border-gray-200 my-2"></div>
                <div class="flex justify-between text-lg font-bold text-gray-900">
                    <span>Total</span>
                    <span class="text-[#0073E2]" id="cart-total">Rp 0</span>
                </div>
            </div>

            <!-- Submit Form for Checkout -->
            <form action="{{ route('sales.payment') }}" method="POST" id="checkout-form">
                @csrf
                <div id="hidden-cart-inputs"></div>
                <input type="hidden" name="payment_method" id="cart-payment-method" value="">
                <button type="button" id="btn-pay" disabled onclick="openPaymentModal()"
                    class="w-full py-4 bg-[#0073E2] hover:bg-blue-600 disabled:bg-gray-200 disabled:text-gray-400 disabled:shadow-none disabled:cursor-not-allowed text-white font-bold rounded-2xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <span>Bayar Sekarang</span>
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Payment Method Modal -->
<div id="payment-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full border border-gray-100 shadow-2xl relative mx-4 animate-in fade-in zoom-in duration-200">
        <!-- Close Button -->
        <button onclick="closePaymentModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors p-1.5 rounded-lg hover:bg-gray-50 cursor-pointer">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>

        <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Pilih Metode Pembayaran</h3>
        <p class="text-xs text-gray-500 text-center mb-6">Silakan pilih metode pembayaran untuk melanjutkan.</p>

        <div class="space-y-3">
            <!-- Cash Selection -->
            <button type="button" onclick="submitWithPaymentMethod('cash')" 
                class="w-full p-4 border border-gray-105 hover:border-blue-200 hover:bg-blue-50/20 rounded-2xl flex items-center gap-4 transition-all duration-200 group text-left cursor-pointer">
                <div class="w-12 h-12 rounded-xl bg-gray-50 group-hover:bg-[#EAF2FC] flex items-center justify-center text-gray-500 group-hover:text-[#0073E2] transition-colors">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="font-bold text-gray-800 text-sm block">Uang Tunai</span>
                    <span class="text-[11px] text-gray-400">Bayar menggunakan uang tunai</span>
                </div>
            </button>

            <!-- QRIS Selection -->
            <button type="button" onclick="submitWithPaymentMethod('qris')" 
                class="w-full p-4 border border-gray-105 hover:border-blue-200 hover:bg-blue-50/20 rounded-2xl flex items-center gap-4 transition-all duration-200 group text-left cursor-pointer">
                <div class="w-12 h-12 rounded-xl bg-gray-50 group-hover:bg-[#EAF2FC] flex items-center justify-center text-gray-500 group-hover:text-[#0073E2] transition-colors">
                    <i data-lucide="qr-code" class="w-6 h-6"></i>
                </div>
                <div>
                    <span class="font-bold text-gray-800 text-sm block">QRIS Code</span>
                    <span class="text-[11px] text-gray-400">Scan QR / upload screenshot</span>
                </div>
            </button>
        </div>
    </div>
</div>

<script>
    // State management for Cart
    let cart = {};

    function openPaymentModal() {
        const modal = document.getElementById('payment-modal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closePaymentModal() {
        const modal = document.getElementById('payment-modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function submitWithPaymentMethod(method) {
        document.getElementById('cart-payment-method').value = method;
        document.getElementById('checkout-form').submit();
    }

    // Filter by Category
    function filterCategory(categorySlug) {
        // Toggle buttons active class
        const buttons = document.querySelectorAll('.category-btn');
        buttons.forEach(btn => {
            btn.className = "category-btn px-6 py-2.5 rounded-full font-bold text-sm bg-white border border-gray-100 text-gray-600 hover:bg-gray-50 transition-all flex items-center justify-center shrink-0 h-10 leading-none";
        });

        const activeBtn = document.getElementById(`btn-cat-${categorySlug}`);
        if(activeBtn) {
            activeBtn.className = "category-btn px-6 py-2.5 rounded-full font-bold text-sm bg-[#0073E2] text-white transition-all shadow-sm flex items-center justify-center shrink-0 h-10 leading-none";
        }

        // Show/hide cards
        const cards = document.querySelectorAll('.product-card');
        cards.forEach(card => {
            if (categorySlug === 'all' || card.getAttribute('data-category') === categorySlug) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Add product to cart
    function addToCart(productId, name, price, stock, unit) {
        if (cart[productId]) {
            if (cart[productId].qty < stock) {
                cart[productId].qty += 1;
            } else {
                alert(`Stok maksimal untuk ${name} tercapai (Tersedia: ${stock})`);
            }
        } else {
            cart[productId] = {
                id: productId,
                name: name,
                price: price,
                qty: 1,
                stock: stock,
                unit: unit
            };
        }
        renderCart();
    }

    // Adjust quantity
    function updateQty(productId, delta) {
        if (!cart[productId]) return;

        const newQty = cart[productId].qty + delta;
        if (newQty <= 0) {
            delete cart[productId];
        } else if (newQty > cart[productId].stock) {
            alert(`Stok maksimal untuk ${cart[productId].name} tercapai (Tersedia: ${cart[productId].stock})`);
        } else {
            cart[productId].qty = newQty;
        }
        renderCart();
    }

    // Direct input quantity changer
    function changeQtyInput(productId, value) {
        if (!cart[productId]) return;
        let newQty = parseInt(value) || 1;
        if (newQty <= 0) {
            delete cart[productId];
        } else if (newQty > cart[productId].stock) {
            alert(`Stok maksimal untuk ${cart[productId].name} tercapai (Tersedia: ${cart[productId].stock})`);
            newQty = cart[productId].stock;
        }
        cart[productId].qty = newQty;
        renderCart();
    }

    // Remove item completely
    function removeItem(productId) {
        delete cart[productId];
        renderCart();
    }

    // Clear entire cart
    function clearCart() {
        if (Object.keys(cart).length === 0) return;
        cart = {};
        renderCart();
    }

    // Format Number to IDR Currency style
    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    // Re-render cart UI and calculations
    function renderCart() {
        const container = document.getElementById('cart-list');
        const emptyState = document.getElementById('cart-empty');
        const subtotalEl = document.getElementById('cart-subtotal');
        const taxEl = document.getElementById('cart-tax');
        const totalEl = document.getElementById('cart-total');
        const btnPay = document.getElementById('btn-pay');
        const hiddenInputsContainer = document.getElementById('hidden-cart-inputs');

        // Clear list container but keep empty state if needed
        container.innerHTML = '';
        hiddenInputsContainer.innerHTML = '';

        const itemKeys = Object.keys(cart);

        if (itemKeys.length === 0) {
            if (emptyState) {
                emptyState.style.display = 'flex';
            }
            subtotalEl.innerText = 'Rp 0';
            taxEl.innerText = 'Rp 0';
            totalEl.innerText = 'Rp 0';
            btnPay.disabled = true;
            return;
        }

        if (emptyState) {
            emptyState.style.display = 'none';
        }
        
        let subtotal = 0;
        let index = 0;

        itemKeys.forEach(id => {
            const item = cart[id];
            const itemSubtotal = item.price * item.qty;
            subtotal += itemSubtotal;

            // Append html for item card
            const itemHtml = `
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 space-y-3 relative">
                    <button onclick="removeItem(${item.id})" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-all flex items-center justify-center cursor-pointer">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                    <div class="flex justify-between items-start pr-9">
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm max-w-[150px] leading-tight">${item.name}</h4>
                            <span class="text-xs text-gray-400 font-semibold block mt-0.5">${formatRupiah(item.price)} / ${item.unit}</span>
                        </div>
                        <span class="font-extrabold text-gray-900 text-sm shrink-0">${formatRupiah(itemSubtotal)}</span>
                    </div>
                    <div class="flex items-center justify-between pt-1">
                        <span class="text-xs text-gray-500 font-bold">Jumlah</span>
                        <div class="flex items-center gap-3">
                            <button onclick="updateQty(${item.id}, -1)" 
                                    class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 active:scale-90 transition-all flex items-center justify-center">
                                <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                            </button>
                            <input type="number" min="1" max="${item.stock}" value="${item.qty}" onchange="changeQtyInput(${item.id}, this.value)"
                                class="w-12 text-center font-extrabold text-gray-800 bg-white border border-gray-200 rounded-lg py-0.5 focus:outline-none focus:ring-1 focus:ring-[#0073E2] text-xs">
                            <button onclick="updateQty(${item.id}, 1)" 
                                    class="w-7 h-7 rounded-full bg-[#0073E2] text-white hover:bg-blue-600 active:scale-90 transition-all flex items-center justify-center">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', itemHtml);

            // Append hidden input form fields
            const inputId = `<input type="hidden" name="items[${index}][product_id]" value="${item.id}">`;
            const inputQty = `<input type="hidden" name="items[${index}][qty]" value="${item.qty}">`;
            hiddenInputsContainer.insertAdjacentHTML('beforeend', inputId + inputQty);
            index++;
        });

        const tax = subtotal * 0.10;
        const total = subtotal + tax;

        subtotalEl.innerText = formatRupiah(subtotal);
        taxEl.innerText = formatRupiah(tax);
        totalEl.innerText = formatRupiah(total);
        btnPay.disabled = false;

        // Re-init lucide icons for dynamic items
        lucide.createIcons();
    }
</script>
@endsection
