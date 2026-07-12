<!-- Product Detail Modal -->
<div id="product-detail-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeProductDetail()"></div>

    <!-- Modal Content wrapper -->
    <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-2xl flex flex-col md:flex-row">
            <!-- Close button -->
            <button onclick="closeProductDetail()" class="absolute top-4 right-4 z-20 p-2 rounded-full bg-white/80 backdrop-blur-md shadow-sm border border-gray-100 text-gray-500 hover:text-gray-800 transition-all cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>

            <!-- Product Image Left -->
            <div class="w-full md:w-1/2 aspect-square md:aspect-auto bg-gray-50 border-r border-gray-100 relative">
                <img id="modal-product-image" src="" alt="Product Image" class="object-cover w-full h-full">
                <span id="modal-product-category" class="absolute top-4 left-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#0073E2] text-white shadow-sm">
                    Kategori
                </span>
            </div>

            <!-- Product Details Right -->
            <div class="w-full md:w-1/2 p-6 sm:p-8 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <h3 id="modal-product-name" class="font-extrabold text-gray-900 text-2xl leading-tight">
                        Nama Produk
                    </h3>
                    <div class="flex items-baseline gap-2">
                        <span id="modal-product-price" class="text-2xl font-extrabold text-[#0073E2]">
                            Rp 0
                        </span>
                        <span id="modal-product-unit" class="text-xs font-bold text-gray-400">
                            / pcs
                        </span>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Produk</h4>
                        <p id="modal-product-description" class="text-sm text-gray-500 leading-relaxed max-h-[150px] overflow-y-auto pr-2 scrollbar-thin">
                            Deskripsi produk...
                        </p>
                    </div>
                </div>

                <!-- Action Button in Modal -->
                <div class="pt-4 border-t border-gray-100">
                    <button id="modal-add-to-cart-btn" class="w-full py-3.5 bg-[#0073E2] hover:bg-blue-600 text-white font-bold rounded-2xl shadow-md shadow-blue-100 hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 text-sm cursor-pointer">
                        <i data-lucide="shopping-cart" class="w-4.5 h-4.5"></i>
                        <span>Tambah ke Keranjang</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openProductDetail(id, name, description, price, imageSrc, categoryName, unitName) {
        // Populate modal data
        document.getElementById('modal-product-image').src = imageSrc;
        document.getElementById('modal-product-image').alt = name;
        document.getElementById('modal-product-category').textContent = categoryName;
        document.getElementById('modal-product-name').textContent = name;
        document.getElementById('modal-product-price').textContent = 'Rp ' + Number(price).toLocaleString('id-ID');
        document.getElementById('modal-product-unit').textContent = '/ ' + (unitName || 'pcs');
        document.getElementById('modal-product-description').textContent = description || 'Produk orisinal karya KUBE YPAC.';
        
        // Setup cart button onclick handler
        const cartBtn = document.getElementById('modal-add-to-cart-btn');
        cartBtn.onclick = function() {
            addToCart(id, name, price, imageSrc);
            closeProductDetail();
        };

        // Show modal
        const modal = document.getElementById('product-detail-modal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Prevent background scrolling
        
        // Re-initialize Lucide Icons for modal icons
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function closeProductDetail() {
        const modal = document.getElementById('product-detail-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
