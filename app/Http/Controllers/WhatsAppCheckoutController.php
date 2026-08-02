<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WhatsAppCheckoutController extends Controller
{
    /**
     * Handle the request when a customer checks out via Online Payment & Proof Upload.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_address' => 'required|string',
            'customer_notes' => 'nullable|string',
            'payment_method' => 'required|in:qris,transfer_bank',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_variant_id' => 'nullable|exists:product_variants,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $customerName = $request->input('customer_name');
        $customerPhone = $request->input('customer_phone');
        $customerAddress = $request->input('customer_address');
        $customerNotes = $request->input('customer_notes');
        $paymentMethod = $request->input('payment_method');
        $cartItems = $request->input('items');

        // Handle Payment Proof Upload to Supabase Storage
        $proofUrl = null;
        $proofPublicId = null;

        if ($request->hasFile('payment_proof')) {
            $supabase = new SupabaseStorageService();
            $proofUrl = $supabase->upload($request->file('payment_proof'), 'payment_proofs');
            if ($proofUrl) {
                $prefix = "https://" . config('services.supabase.project_id') . ".supabase.co/storage/v1/object/public/" . config('services.supabase.bucket') . "/";
                $proofPublicId = str_replace($prefix, '', $proofUrl);
            } else {
                return response()->json([
                    'message' => 'Gagal mengunggah bukti pembayaran. Silakan coba lagi.'
                ], 422);
            }
        }

        $processedItems = [];
        $subtotal = 0;

        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem['product_id']);
            if (!$product || !$product->is_active) {
                return response()->json([
                    'message' => "Produk tidak aktif atau tidak ditemukan."
                ], 422);
            }

            $variant = null;
            if (!empty($cartItem['product_variant_id'])) {
                $variant = ProductVariant::find($cartItem['product_variant_id']);
            }

            $price = $variant ? $variant->price : $product->price;
            $stock = $variant ? $variant->stock : $product->stock;
            $name = $product->product_name . ($variant ? " ({$variant->variant_name})" : "");

            if ($stock < $cartItem['qty']) {
                return response()->json([
                    'message' => "Stok produk {$name} tidak mencukupi (Tersedia: {$stock})."
                ], 422);
            }

            $itemSubtotal = $price * $cartItem['qty'];
            $subtotal += $itemSubtotal;

            $processedItems[] = [
                'product_id' => $product->id,
                'product_variant_id' => $variant ? $variant->id : null,
                'variant_name' => $variant ? $variant->variant_name : null,
                'product_name' => $name,
                'price' => $price,
                'qty' => $cartItem['qty'],
                'subtotal' => $itemSubtotal,
            ];
        }

        $tax = $subtotal * 0.10; // 10% PPN
        $shipping = 0; // Ongkos Kirim Dihapus
        $total = $subtotal + $tax;

        try {
            $transaction = DB::transaction(function () use ($customerName, $customerPhone, $customerAddress, $customerNotes, $paymentMethod, $proofUrl, $proofPublicId, $processedItems, $subtotal, $tax, $shipping, $total) {
                // Generate WhatsApp unique invoice number
                $invoiceNumber = 'TRX-WA-' . date('Ymd') . '-' . strtoupper(Str::random(5));

                $trx = Transaction::create([
                    'invoice_number' => $invoiceNumber,
                    'is_whatsapp' => true,
                    'customer_name' => $customerName,
                    'customer_phone' => $customerPhone,
                    'customer_address' => $customerAddress,
                    'customer_notes' => $customerNotes,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping_cost' => $shipping,
                    'total' => $total,
                    'payment_method' => $paymentMethod,
                    'payment_proof' => $proofUrl,
                    'payment_proof_public_id' => $proofPublicId,
                    'status' => 'pending',
                    'delivery_status' => 'belum_dikirim',
                    'user_id' => null, // Guest buyer
                ]);

                foreach ($processedItems as $item) {
                    TransactionDetails::create([
                        'transaction_id' => $trx->id,
                        'product_id' => $item['product_id'],
                        'product_variant_id' => $item['product_variant_id'],
                        'variant_name' => $item['variant_name'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Decrement stock
                    if (!empty($item['product_variant_id'])) {
                        $v = ProductVariant::find($item['product_variant_id']);
                        if ($v) $v->decrement('stock', $item['qty']);
                    } else {
                        $p = Product::find($item['product_id']);
                        if ($p) $p->decrement('stock', $item['qty']);
                    }
                }

                return $trx;
            });

            // Construct WhatsApp Message
            $paymentMethodLabel = $paymentMethod === 'qris' ? 'QRIS Code' : 'Transfer Bank Jateng (2088049139 a.n YPAC Semarang)';
            $whatsappNumber = '6289682010990';

            $msg = "*PESANAN BARU - KUBE YPAC*\n";
            $msg .= "*Nomor Invoice:* {$transaction->invoice_number}\n";
            $msg .= "--------------------------------------\n";
            $msg .= "*Nama Pemesan:* {$customerName}\n";
            $msg .= "*No. WhatsApp:* {$customerPhone}\n";
            $msg .= "*Alamat Pengiriman:* {$customerAddress}\n";
            if ($customerNotes) {
                $msg .= "*Catatan Tambahan:* {$customerNotes}\n";
            }
            $msg .= "*Metode Pembayaran:* {$paymentMethodLabel}\n";
            $msg .= "*Status Bukti Bayar:* Sudah Diunggah di Website\n";
            $msg .= "--------------------------------------\n\n";
            $msg .= "*Detail Belanja:*\n";

            foreach ($processedItems as $index => $item) {
                $msg .= ($index + 1) . ". *" . $item['product_name'] . "* (" . $item['qty'] . "x) @ Rp " . number_format($item['price'], 0, ',', '.') . "\n";
                $msg .= "   Subtotal: Rp " . number_format($item['subtotal'], 0, ',', '.') . "\n";
            }

            $msg .= "\n--------------------------------------\n";
            $msg .= "*Subtotal:* Rp " . number_format($subtotal, 0, ',', '.') . "\n";
            $msg .= "*PPN (10%):* Rp " . number_format($tax, 0, ',', '.') . "\n";
            $msg .= "--------------------------------------\n";
            $msg .= "*Total Pembayaran:* Rp " . number_format($total, 0, ',', '.') . "\n";
            $msg .= "*(Belum termasuk biaya Ongkos Kirim / Ongkir)*\n";
            $msg .= "*(Estimasi Pengiriman: 1 - 2 Minggu)*\n";
            $msg .= "--------------------------------------\n\n";
            $msg .= "Halo Admin, saya telah melakukan pemesanan dan berhasil mengunggah bukti pembayaran. Mohon segera diproses dan dikirim ya. Terima kasih!";

            $waUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($msg);

            return response()->json([
                'success' => true,
                'invoice_number' => $transaction->invoice_number,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'whatsapp_url' => $waUrl,
                'whatsapp_message' => $msg,
            ]);

        } catch (\Exception $e) {
            if ($proofUrl) {
                $supabase = new SupabaseStorageService();
                $supabase->delete($proofUrl);
            }
            return response()->json([
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}
