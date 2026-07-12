@extends('layouts.app')

@section('title', 'Pembayaran - SIKAS YPAC')

@section('content')
<div class="flex-1 flex flex-col p-6 max-w-4xl mx-auto w-full overflow-y-auto">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('sales.index') }}" class="flex items-center gap-2 text-[#0073E2] hover:text-blue-600 transition-colors font-bold text-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            <span>Kembali ke Penjualan</span>
        </a>
    </div>

    <!-- Bill Total Card -->
    <div class="bg-white border border-gray-100 rounded-3xl p-8 mb-8 flex flex-col items-center justify-center text-center shadow-sm">
        <span class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-2">Total Tagihan</span>
        <span class="text-3xl md:text-4xl font-extrabold text-[#0073E2] tracking-tight">
            Rp {{ number_format($total, 0, ',', '.') }}
        </span>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Form Checkout -->
    <form action="{{ route('sales.checkout') }}" method="POST" id="payment-form" class="space-y-8">
        @csrf
        <input type="hidden" name="payment_method" id="selected_method" value="">

        <!-- Payment Method Selection -->
        <div class="space-y-4">
            <h3 class="text-base font-bold text-gray-800 text-center">Pilih Pembayaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Cash Option -->
                <button type="button" onclick="selectPaymentMethod('cash')" id="btn-method-cash"
                    class="bg-white border border-gray-100 hover:border-blue-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 group">
                    <div class="w-16 h-16 rounded-2xl bg-gray-50 group-hover:bg-[#EAF2FC] flex items-center justify-center text-gray-500 group-hover:text-[#0073E2] mb-4 transition-all" id="icon-method-cash">
                        <i data-lucide="banknote" class="w-8 h-8"></i>
                    </div>
                    <span class="font-bold text-gray-800 text-base mb-1">Uang Tunai</span>
                    <span class="text-xs text-gray-400 font-medium">Bayar di kasir</span>
                </button>

                <!-- QRIS Option -->
                <button type="button" onclick="selectPaymentMethod('qris')" id="btn-method-qris"
                    class="bg-white border border-gray-100 hover:border-blue-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 group">
                    <div class="w-16 h-16 rounded-2xl bg-gray-50 group-hover:bg-[#EAF2FC] flex items-center justify-center text-gray-500 group-hover:text-[#0073E2] mb-4 transition-all" id="icon-method-qris">
                        <i data-lucide="qr-code" class="w-8 h-8"></i>
                    </div>
                    <span class="font-bold text-gray-800 text-base mb-1">QRIS</span>
                    <span class="text-xs text-gray-400 font-medium">Scan kode QR</span>
                </button>
            </div>
        </div>

        <!-- Cash Form details (Hidden until 'cash' is clicked) -->
        <div id="cash-details" class="hidden bg-white border border-gray-100 rounded-3xl p-6 space-y-6 shadow-sm">
            <h4 class="font-bold text-gray-800 text-sm">Detail Pembayaran Tunai</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nominal input -->
                <div class="space-y-2">
                    <label for="amount_paid_input" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Uang Diterima</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">
                            Rp
                        </span>
                        <input type="number" id="amount_paid_input" name="amount_paid" placeholder="Masukkan nominal bayar"
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0073E2] focus:bg-white transition-all font-extrabold text-lg">
                    </div>
                </div>

                <!-- Live calculations change -->
                <div class="bg-gray-50 rounded-2xl p-5 flex flex-col justify-center">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kembalian</span>
                    <span class="text-2xl font-extrabold text-gray-900" id="change-text">Rp 0</span>
                </div>
            </div>

            <!-- Quick Cash Buttons -->
            <div class="space-y-2">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Uang Pas & Nominal Cepat</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="setQuickCash({{ $total }})" class="px-4 py-2 border border-gray-200 text-xs font-bold text-gray-600 rounded-xl bg-white hover:bg-gray-50 transition-colors">
                        Uang Pas
                    </button>
                    <button type="button" onclick="setQuickCash(10000)" class="px-4 py-2 border border-gray-200 text-xs font-bold text-gray-600 rounded-xl bg-white hover:bg-gray-50 transition-colors">
                        Rp 10.000
                    </button>
                    <button type="button" onclick="setQuickCash(20000)" class="px-4 py-2 border border-gray-200 text-xs font-bold text-gray-600 rounded-xl bg-white hover:bg-gray-50 transition-colors">
                        Rp 20.000
                    </button>
                    <button type="button" onclick="setQuickCash(50000)" class="px-4 py-2 border border-gray-200 text-xs font-bold text-gray-600 rounded-xl bg-white hover:bg-gray-50 transition-colors">
                        Rp 50.000
                    </button>
                    <button type="button" onclick="setQuickCash(100000)" class="px-4 py-2 border border-gray-200 text-xs font-bold text-gray-600 rounded-xl bg-white hover:bg-gray-50 transition-colors">
                        Rp 100.000
                    </button>
                </div>
            </div>
        </div>

        <!-- QRIS Details (Hidden until 'qris' is clicked) -->
        <div id="qris-details" class="hidden bg-white border border-gray-100 rounded-3xl p-6 flex flex-col items-center space-y-6 shadow-sm">
            <h4 class="font-bold text-gray-800 text-sm w-full text-left">Scan QRIS</h4>
            
            <!-- Mock QR Code -->
            <div class="p-4 border border-gray-100 bg-white rounded-2xl flex flex-col items-center">
                <!-- SVG QR Code visualization -->
                <svg width="200" height="200" viewBox="0 0 100 100" class="text-gray-900">
                    <rect width="100" height="100" fill="#ffffff"/>
                    <!-- Outline boxes (QR pattern style) -->
                    <rect x="5" y="5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="4"/>
                    <rect x="10" y="10" width="10" height="10" fill="currentColor"/>
                    <rect x="75" y="5" width="20" height="20" fill="none" stroke="currentColor" stroke-width="4"/>
                    <rect x="80" y="10" width="10" height="10" fill="currentColor"/>
                    <rect x="5" y="75" width="20" height="20" fill="none" stroke="currentColor" stroke-width="4"/>
                    <rect x="10" y="80" width="10" height="10" fill="currentColor"/>
                    <!-- Random QR dots -->
                    <rect x="35" y="15" width="6" height="6" fill="currentColor"/>
                    <rect x="50" y="10" width="6" height="6" fill="currentColor"/>
                    <rect x="40" y="30" width="12" height="6" fill="currentColor"/>
                    <rect x="15" y="45" width="6" height="12" fill="currentColor"/>
                    <rect x="30" y="50" width="6" height="6" fill="currentColor"/>
                    <rect x="55" y="45" width="18" height="6" fill="currentColor"/>
                    <rect x="45" y="60" width="6" height="18" fill="currentColor"/>
                    <rect x="75" y="40" width="12" height="12" fill="currentColor"/>
                    <rect x="80" y="65" width="12" height="6" fill="currentColor"/>
                    <rect x="85" y="80" width="10" height="10" fill="currentColor"/>
                    <rect x="45" y="85" width="6" height="6" fill="currentColor"/>
                    <rect x="60" y="75" width="6" height="12" fill="currentColor"/>
                </svg>
                <span class="text-xs text-gray-400 font-bold tracking-widest mt-3 uppercase">NMID : ID1234567890</span>
            </div>

            <div class="text-center max-w-sm">
                <span class="text-sm font-bold text-gray-800 block">Metode QRIS Terverifikasi</span>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                    Silakan scan kode QR di atas untuk melakukan pembayaran. Sistem akan memproses invoice secara otomatis.
                </p>
            </div>
            
            <div class="flex items-center gap-2 text-blue-600 bg-blue-50 px-4 py-2.5 rounded-full border border-blue-100 text-xs font-bold animate-pulse">
                <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                <span>Menunggu Pembayaran...</span>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" id="submit-payment" disabled
            class="w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-2xl shadow-none cursor-not-allowed transition-all flex items-center justify-center gap-2 text-base">
            <span>Selesaikan Pembayaran</span>
            <i data-lucide="check-circle" class="w-5 h-5"></i>
        </button>
    </form>
</div>

<script>
    const totalBill = {{ $total }};

    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    // Toggle Payment Method view states
    function selectPaymentMethod(method) {
        // Set input value
        document.getElementById('selected_method').value = method;

        // Toggle button styling
        const btnCash = document.getElementById('btn-method-cash');
        const btnQris = document.getElementById('btn-method-qris');
        const iconCash = document.getElementById('icon-method-cash');
        const iconQris = document.getElementById('icon-method-qris');

        if (method === 'cash') {
            btnCash.className = "bg-white border-2 border-[#0073E2] rounded-3xl p-8 flex flex-col items-center justify-center text-center shadow-md shadow-blue-50/50 transition-all duration-300";
            iconCash.className = "w-16 h-16 rounded-2xl bg-[#EAF2FC] flex items-center justify-center text-[#0073E2] mb-4 transition-all";
            
            btnQris.className = "bg-white border border-gray-100 hover:border-blue-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 group";
            iconQris.className = "w-16 h-16 rounded-2xl bg-gray-50 group-hover:bg-[#EAF2FC] flex items-center justify-center text-gray-500 group-hover:text-[#0073E2] mb-4 transition-all";
            
            document.getElementById('cash-details').style.display = 'block';
            document.getElementById('qris-details').style.display = 'none';

            // Require amount paid validation on cash
            validateCashAmount();
        } else {
            btnQris.className = "bg-white border-2 border-[#0073E2] rounded-3xl p-8 flex flex-col items-center justify-center text-center shadow-md shadow-blue-50/50 transition-all duration-300";
            iconQris.className = "w-16 h-16 rounded-2xl bg-[#EAF2FC] flex items-center justify-center text-[#0073E2] mb-4 transition-all";
            
            btnCash.className = "bg-white border border-gray-100 hover:border-blue-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 group";
            iconCash.className = "w-16 h-16 rounded-2xl bg-gray-50 group-hover:bg-[#EAF2FC] flex items-center justify-center text-gray-500 group-hover:text-[#0073E2] mb-4 transition-all";
            
            document.getElementById('qris-details').style.display = 'flex';
            document.getElementById('cash-details').style.display = 'none';

            // QRIS automatically qualifies for payment submission
            enableSubmitButton();
        }
    }

    // Set Quick Nominal values
    function setQuickCash(amount) {
        document.getElementById('amount_paid_input').value = amount;
        validateCashAmount();
    }

    // Validate Cash Input math
    function validateCashAmount() {
        const inputVal = parseFloat(document.getElementById('amount_paid_input').value) || 0;
        const changeText = document.getElementById('change-text');
        
        if (inputVal >= totalBill) {
            const change = inputVal - totalBill;
            changeText.innerText = formatRupiah(change);
            changeText.className = "text-2xl font-extrabold text-green-600";
            enableSubmitButton();
        } else {
            const deficit = totalBill - inputVal;
            changeText.innerText = "Kurang " + formatRupiah(deficit);
            changeText.className = "text-2xl font-extrabold text-red-500";
            disableSubmitButton();
        }
    }

    // Enable submit
    function enableSubmitButton() {
        const btn = document.getElementById('submit-payment');
        btn.disabled = false;
        btn.className = "w-full py-4 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 text-base";
    }

    // Disable submit
    function disableSubmitButton() {
        const btn = document.getElementById('submit-payment');
        btn.disabled = true;
        btn.className = "w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-2xl shadow-none cursor-not-allowed transition-all flex items-center justify-center gap-2 text-base";
    }

    // Attach dynamic keyboard/input listener
    document.getElementById('amount_paid_input').addEventListener('input', validateCashAmount);
</script>
@endsection
