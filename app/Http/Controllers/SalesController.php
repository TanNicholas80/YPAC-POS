<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\SupabaseStorageService;

class SalesController extends Controller
{
    /**
     * Display the POS dashboard catalog.
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->with(['category', 'unit'])
            ->get();
            
        $categories = ProductCategory::all();

        return view('sales.index', compact('products', 'categories'));
    }

    /**
     * Handle cart submission and redirect to appropriate payment view.
     */
    public function payment(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,qris',
        ]);

        $cartItems = $request->input('items');
        $paymentMethod = $request->input('payment_method');
        $processedItems = [];
        $subtotal = 0;

        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem['product_id']);
            if (!$product) continue;

            // Check if stock is sufficient
            if ($product->stock < $cartItem['qty']) {
                return back()->withErrors([
                    'stock' => "Stok produk {$product->product_name} tidak mencukupi (Tersedia: {$product->stock})."
                ]);
            }

            $itemSubtotal = $product->price * $cartItem['qty'];
            $subtotal += $itemSubtotal;

            $processedItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'price' => $product->price,
                'qty' => $cartItem['qty'],
                'subtotal' => $itemSubtotal,
            ];
        }

        $tax = $subtotal * 0.10; // Tax is 10%
        $total = $subtotal + $tax;

        // Store in session for safety during checkout
        session([
            'pending_transaction' => [
                'items' => $processedItems,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $paymentMethod,
            ]
        ]);

        if ($paymentMethod === 'cash') {
            return redirect()->route('sales.payment.cash');
        }

        return redirect()->route('sales.payment.qris');
    }

    /**
     * Render the dedicated Cash Payment view.
     */
    public function paymentCash()
    {
        $pending = session('pending_transaction');
        if (!$pending || $pending['payment_method'] !== 'cash') {
            return redirect()->route('sales.index')->withErrors(['cart' => 'Sesi transaksi tunai tidak ditemukan.']);
        }

        $total = $pending['total'];
        $subtotal = $pending['subtotal'];
        $tax = $pending['tax'];

        return view('sales.payment_cash', compact('total', 'subtotal', 'tax'));
    }

    /**
     * Render the dedicated QRIS Payment view.
     */
    public function paymentQris()
    {
        $pending = session('pending_transaction');
        if (!$pending || $pending['payment_method'] !== 'qris') {
            return redirect()->route('sales.index')->withErrors(['cart' => 'Sesi transaksi QRIS tidak ditemukan.']);
        }

        $total = $pending['total'];
        $subtotal = $pending['subtotal'];
        $tax = $pending['tax'];

        return view('sales.payment_qris', compact('total', 'subtotal', 'tax'));
    }

    /**
     * Process checkout transaction.
     */
    public function checkout(Request $request)
    {
        $pending = session('pending_transaction');
        if (!$pending) {
            return redirect()->route('sales.index')->withErrors(['cart' => 'Sesi transaksi kedaluwarsa. Silakan ulangi.']);
        }

        $paymentMethod = $pending['payment_method'];

        $request->validate([
            'amount_paid' => 'required_if:payment_method,cash|numeric|nullable',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $amountPaid = 0;
        $changeAmount = 0;
        $qrisImage = null;
        $qrisPublicId = null;

        if ($paymentMethod === 'cash') {
            $amountPaid = (float) $request->input('amount_paid');
            if ($amountPaid < $pending['total']) {
                return back()->withErrors([
                    'amount_paid' => 'Jumlah pembayaran tunai kurang dari total tagihan.'
                ]);
            }
            $changeAmount = $amountPaid - $pending['total'];
        } else {
            // QRIS automatically pays exactly the total
            $amountPaid = $pending['total'];
            $changeAmount = 0;

            // Handle QRIS payment proof upload
            if ($request->hasFile('payment_proof')) {
                $supabase = new SupabaseStorageService();
                $qrisImage = $supabase->upload($request->file('payment_proof'), 'qris_proofs');
                if ($qrisImage) {
                    $prefix = "https://".config('services.supabase.project_id').".supabase.co/storage/v1/object/public/".config('services.supabase.bucket')."/";
                    $qrisPublicId = str_replace($prefix, '', $qrisImage);
                }
            }
        }

        // Run DB Transaction for database safety
        $transaction = DB::transaction(function () use ($pending, $paymentMethod, $amountPaid, $changeAmount, $qrisImage, $qrisPublicId) {
            // 1. Generate unique invoice number
            $invoiceNumber = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // 2. Create Transaction header
            $trx = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'subtotal' => $pending['subtotal'],
                'tax' => $pending['tax'],
                'total' => $pending['total'],
                'payment_method' => $paymentMethod,
                'amount_paid' => $amountPaid,
                'change_amount' => $changeAmount,
                'qris_image' => $qrisImage,
                'qris_public_id' => $qrisPublicId,
                'status' => 'completed',
                'user_id' => Auth::id(),
            ]);

            // 3. Create Transaction details & decrease product stock
            foreach ($pending['items'] as $item) {
                TransactionDetails::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Decrement stock
                $product = Product::findOrFail($item['product_id']);
                $product->decrement('stock', $item['qty']);
            }

            return $trx;
        });

        // Clear pending transaction session
        session()->forget('pending_transaction');

        return redirect()->route('sales.success', $transaction->id);
    }

    /**
     * Display the successful transaction receipt.
     */
    public function success(Transaction $transaction)
    {
        $transaction->load(['details.product', 'user']);
        return view('sales.success', compact('transaction'));
    }
}
