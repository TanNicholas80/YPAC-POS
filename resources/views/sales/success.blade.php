@extends('layouts.app')

@section('title', 'Transaksi Berhasil - SIKAS YPAC')

@section('content')
<style>
    /* Styling specifically for printing receipts */
    @media print {
        aside {
            display: none !important;
        }
        main {
            background: white !important;
            padding: 0 !important;
        }
        .no-print {
            display: none !important;
        }
        .print-receipt-card {
            border: none !important;
            box-shadow: none !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
        }
    }
</style>

<div class="flex-1 flex flex-col items-center justify-center p-6 overflow-y-auto">
    <!-- Receipt Card -->
    <div class="w-full max-w-md bg-white border border-gray-100 rounded-3xl p-8 shadow-sm print-receipt-card flex flex-col items-center">
        
        <!-- Success Icon -->
        <div class="w-14 h-14 rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-4 no-print">
            <i data-lucide="check" class="w-8 h-8 stroke-[3]"></i>
        </div>

        <h2 class="text-xl font-bold text-gray-900 text-center mb-1">Transaksi Berhasil!</h2>
        <span class="text-xs text-gray-400 font-semibold mb-6 uppercase tracking-wider block text-center">SIKAS YPAC Store</span>

        <!-- Invoice Meta Details -->
        <div class="w-full border-t border-b border-dashed border-gray-200 py-4 space-y-2.5 text-xs text-gray-600 font-semibold mb-6">
            <div class="flex justify-between">
                <span>No. Invoice</span>
                <span class="text-gray-900 font-bold uppercase">{{ $transaction->invoice_number }}</span>
            </div>
            <div class="flex justify-between">
                <span>Waktu</span>
                <span class="text-gray-900 font-bold">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir</span>
                <span class="text-gray-900 font-bold">{{ $transaction->user->name ?? 'Kasir' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status</span>
                <span class="text-green-600 font-bold uppercase bg-green-50 px-2 py-0.5 rounded-full text-[10px] border border-green-100">Lunas</span>
            </div>
        </div>

        <!-- Items purchased -->
        <div class="w-full space-y-4 mb-6">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block">Daftar Produk</span>
            <div class="space-y-3">
                @foreach($transaction->details as $detail)
                    <div class="flex justify-between text-xs">
                        <div class="space-y-0.5">
                            <span class="font-bold text-gray-900 block leading-tight">{{ $detail->product->product_name ?? 'Produk Terhapus' }}</span>
                            <span class="text-gray-400 font-semibold">{{ $detail->qty }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                        </div>
                        <span class="font-extrabold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Price Breakdown -->
        <div class="w-full border-t border-gray-100 pt-4 space-y-2.5 text-xs text-gray-600 font-semibold">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span class="text-gray-900">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Pajak (10%)</span>
                <span class="text-gray-900">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
            </div>
            <div class="border-t border-dashed border-gray-100 my-1"></div>
            <div class="flex justify-between text-sm font-bold text-gray-900">
                <span>Total Belanja</span>
                <span class="text-[#0073E2]">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Metode Pembayaran</span>
                <span class="text-gray-900 uppercase font-bold">{{ $transaction->payment_method }}</span>
            </div>
            <div class="flex justify-between">
                <span>Jumlah Bayar</span>
                <span class="text-gray-900">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kembalian</span>
                <span class="text-green-600 font-extrabold">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer greeting -->
        <div class="w-full text-center mt-8 text-[11px] text-gray-400 font-semibold leading-relaxed border-t border-dashed border-gray-200 pt-4">
            Terima kasih atas kunjungan Anda!<br>
            SIKAS YPAC - Inklusif, Mandiri, Berdaya.
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-3 w-full max-w-sm mt-8 no-print">
        <!-- Print Button -->
        <button onclick="window.print()" 
            class="flex-1 py-3.5 px-6 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 font-bold rounded-2xl transition-all flex items-center justify-center gap-2 text-sm">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Cetak Struk</span>
        </button>

        <!-- New transaction Link -->
        <a href="{{ route('sales.index') }}" 
            class="flex-1 py-3.5 px-6 bg-[#0073E2] hover:bg-blue-600 text-white font-bold rounded-2xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 text-sm">
            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
            <span>Transaksi Baru</span>
        </a>
    </div>
</div>
@endsection
