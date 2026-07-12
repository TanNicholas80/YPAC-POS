<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WhatsAppCheckoutController extends Controller
{
    /**
     * Handle the AJAX request when a user checks out via WhatsApp.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $customerName = $request->input('customer_name');
        $customerAddress = $request->input('customer_address');
        $cartItems = $request->input('items');

        $processedItems = [];
        $subtotal = 0;

        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem['product_id']);
            if (!$product) continue;

            if (!$product->is_active) {
                return response()->json([
                    'message' => "Produk {$product->product_name} tidak aktif."
                ], 422);
            }

            if ($product->stock < $cartItem['qty']) {
                return response()->json([
                    'message' => "Stok produk {$product->product_name} tidak mencukupi (Tersedia: {$product->stock})."
                ], 422);
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

        $tax = $subtotal * 0.10; // 10% PPN
        $shipping = 15000; // Flat shipping rate
        $total = $subtotal + $tax + $shipping;

        $transaction = DB::transaction(function () use ($customerName, $customerAddress, $processedItems, $subtotal, $tax, $shipping, $total) {
            // Generate WhatsApp unique invoice number
            $invoiceNumber = 'TRX-WA-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $trx = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'is_whatsapp' => true,
                'customer_name' => $customerName,
                'customer_address' => $customerAddress,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'total' => $total,
                'payment_method' => null, // filled upon admin approval
                'status' => 'pending', // pending approval
                'user_id' => null, // guest buyer
            ]);

            foreach ($processedItems as $item) {
                TransactionDetails::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return $trx;
        });

        return response()->json([
            'success' => true,
            'invoice_number' => $transaction->invoice_number,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_cost' => $shipping,
            'total' => $total,
        ]);
    }
}
