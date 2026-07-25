@extends('layouts.app')

@section('title', 'Pembayaran Tunai - SIKAS YPAC')

@section('content')
<div class="flex-1 flex flex-col p-6 overflow-y-auto">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('sales.index') }}" class="flex items-center gap-2 text-[#0073E2] hover:text-blue-600 transition-colors font-bold text-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            <span class="text-lg">Pembayaran Tunai</span>
        </a>
    </div>

    <!-- Main Payment Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start max-w-5xl w-full mx-auto">
        
        <!-- Left Column: Total & Quick Denominations -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Total Card -->
            <div class="bg-[#0073E2] text-white rounded-3xl p-6 shadow-md shadow-blue-100 flex flex-col items-center justify-center text-center">
                <span class="text-xs opacity-75 font-semibold uppercase tracking-wider mb-1">Total Tagihan</span>
                <span class="text-3xl font-extrabold tracking-tight">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </span>
            </div>

            <!-- Denomination Container -->
            <div class="bg-white border border-gray-100 rounded-3xl p-6 space-y-4 shadow-sm">
                <h3 class="text-sm font-bold text-gray-800 text-center">Uang Pas / Denominasi Cepat</h3>
                
                <div class="space-y-3">
                    <!-- Uang Pas Button -->
                    <button type="button" onclick="setCashAmount({{ $total }})"
                        class="w-full py-4 bg-white border border-gray-100 hover:border-blue-200 hover:bg-blue-50/10 text-[#0073E2] font-bold rounded-2xl transition-all shadow-sm flex items-center justify-center gap-2 text-sm cursor-pointer">
                        Uang Pas
                    </button>

                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="setCashAmount(50000)"
                            class="py-3 border border-gray-100 hover:border-blue-200 hover:bg-blue-50/10 text-[#0073E2] font-bold rounded-xl bg-white text-xs transition-colors cursor-pointer">
                            Rp 50.000
                        </button>
                        <button type="button" onclick="setCashAmount(100000)"
                            class="py-3 border border-gray-100 hover:border-blue-200 hover:bg-blue-50/10 text-[#0073E2] font-bold rounded-xl bg-white text-xs transition-colors cursor-pointer">
                            Rp 100.000
                        </button>
                        <button type="button" onclick="setCashAmount(200000)"
                            class="py-3 border border-gray-100 hover:border-blue-200 hover:bg-blue-50/10 text-[#0073E2] font-bold rounded-xl bg-white text-xs transition-colors cursor-pointer">
                            Rp 200.000
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Tactile Input received details & Keypad -->
        <div class="lg:col-span-7 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col justify-between">
            <!-- Numeric displays -->
            <div class="space-y-4 mb-6">
                <!-- Display field -->
                <div class="border-b border-gray-100 pb-4">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Nominal Tunai (Diterima)</span>
                    <div class="flex items-baseline justify-between">
                        <span class="text-3xl font-extrabold text-[#0073E2]">Rp</span>
                        <span class="text-3xl font-extrabold text-[#0073E2] tracking-tight" id="display-amount">0</span>
                    </div>
                </div>

                <!-- Live calculations change -->
                <div class="flex justify-between items-center text-sm font-semibold text-gray-600">
                    <span>Kembalian:</span>
                    <span class="text-lg font-bold text-gray-900" id="change-amount-text">Rp 0</span>
                </div>
            </div>

            <!-- Custom 12-key POS Keypad Grid -->
            <div class="grid grid-cols-3 gap-3 mb-6">
                @for ($i = 1; $i <= 9; $i++)
                    <button type="button" onclick="pressKey('{{ $i }}')"
                        class="py-4 bg-white hover:bg-gray-50 active:scale-95 border border-gray-100 text-gray-800 font-bold rounded-2xl text-lg shadow-sm transition-all flex items-center justify-center cursor-pointer">
                        {{ $i }}
                    </button>
                @endfor
                
                <!-- Backspace Key -->
                <button type="button" onclick="pressKey('backspace')"
                    class="py-4 bg-white hover:bg-red-50 text-red-500 active:scale-95 border border-gray-100 font-bold rounded-2xl text-lg shadow-sm transition-all flex items-center justify-center cursor-pointer">
                    <i data-lucide="delete" class="w-6 h-6"></i>
                </button>

                <!-- Zero Key -->
                <button type="button" onclick="pressKey('0')"
                    class="py-4 bg-white hover:bg-gray-50 active:scale-95 border border-gray-100 text-gray-800 font-bold rounded-2xl text-lg shadow-sm transition-all flex items-center justify-center cursor-pointer">
                    0
                </button>

                <!-- Triple Zero Key -->
                <button type="button" onclick="pressKey('000')"
                    class="py-4 bg-white hover:bg-gray-50 active:scale-95 border border-gray-100 text-gray-800 font-bold rounded-2xl text-lg shadow-sm transition-all flex items-center justify-center cursor-pointer">
                    000
                </button>
            </div>

            <!-- Submit form -->
            <form action="{{ route('sales.checkout') }}" method="POST" id="cash-checkout-form">
                @csrf
                <input type="hidden" name="amount_paid" id="hidden-amount-paid" value="0">
                <button type="submit" id="btn-submit-cash" disabled
                    class="w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-2xl shadow-none cursor-not-allowed transition-all flex items-center justify-center gap-2 text-base cursor-pointer">
                    <span>Selesaikan Pembayaran</span>
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const totalBill = {{ $total }};
    let typedAmount = '';

    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    // Force/set direct amount (from shortcut buttons)
    function setCashAmount(amount) {
        typedAmount = amount.toString();
        updateDisplay();
    }

    // Capture custom keypad input
    function pressKey(key) {
        if (key === 'backspace') {
            typedAmount = typedAmount.slice(0, -1);
        } else {
            // Prevent leading zeros if empty
            if (typedAmount === '' && (key === '0' || key === '000')) {
                return;
            }
            typedAmount += key;
        }
        updateDisplay();
    }

    // Updates displays, parses values, and toggles checkout state
    function updateDisplay() {
        const displayVal = typedAmount === '' ? '0' : parseInt(typedAmount).toLocaleString('id-ID');
        document.getElementById('display-amount').innerText = displayVal;

        const val = parseInt(typedAmount) || 0;
        document.getElementById('hidden-amount-paid').value = val;

        const changeText = document.getElementById('change-amount-text');
        const submitBtn = document.getElementById('btn-submit-cash');

        if (val >= totalBill) {
            const change = val - totalBill;
            changeText.innerText = formatRupiah(change);
            changeText.className = "text-lg font-bold text-green-600";
            
            // Enable submit
            submitBtn.disabled = false;
            submitBtn.className = "w-full py-4 bg-[#0073E2] hover:bg-blue-600 active:scale-[0.98] text-white font-bold rounded-2xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 text-base cursor-pointer";
        } else {
            const deficit = totalBill - val;
            changeText.innerText = typedAmount === '' ? 'Rp 0' : "Kurang " + formatRupiah(deficit);
            changeText.className = "text-lg font-bold text-red-500";

            // Disable submit
            submitBtn.disabled = true;
            submitBtn.className = "w-full py-4 bg-gray-200 text-gray-400 font-bold rounded-2xl shadow-none cursor-not-allowed transition-all flex items-center justify-center gap-2 text-base cursor-pointer";
        }
    }
</script>
@endsection
