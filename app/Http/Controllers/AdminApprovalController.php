<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminApprovalController extends Controller
{
    /**
     * Display a listing of WhatsApp transactions to approve/reject.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search');

        $query = Transaction::where('is_whatsapp', true)->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', '%' . $search . '%')
                  ->orWhere('customer_name', 'like', '%' . $search . '%');
            });
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('admin.approvals.index', compact('transactions', 'status', 'search'));
    }

    /**
     * Display details of a specific WhatsApp transaction.
     */
    public function show(Transaction $transaction)
    {
        if (!$transaction->is_whatsapp) {
            abort(404);
        }

        $transaction->load(['details.product', 'user']);

        return view('admin.approvals.show', compact('transaction'));
    }

    /**
     * Approve a WhatsApp transaction, upload proof of payment, input payment method, and decrement stock.
     */
    public function approve(Request $request, Transaction $transaction)
    {
        if (!$transaction->is_whatsapp) {
            abort(404);
        }

        if ($transaction->status !== 'pending') {
            return back()->withErrors(['status' => 'Transaksi ini sudah diproses.']);
        }

        $request->validate([
            'payment_method' => 'required|in:transfer_bank,qris',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $proofUrl = null;
        $proofPublicId = null;

        if ($request->hasFile('payment_proof')) {
            $supabase = new SupabaseStorageService();
            // Upload into a folder called 'payment_proofs'
            $proofUrl = $supabase->upload($request->file('payment_proof'), 'payment_proofs');
            if ($proofUrl) {
                $prefix = "https://".config('services.supabase.project_id').".supabase.co/storage/v1/object/public/".config('services.supabase.bucket')."/";
                $proofPublicId = str_replace($prefix, '', $proofUrl);
            } else {
                return back()->withErrors(['payment_proof' => 'Gagal mengunggah bukti pembayaran ke storage.']);
            }
        }

        try {
            DB::transaction(function () use ($transaction, $request, $proofUrl, $proofPublicId) {
                // Refresh transaction details and check stock
                $transaction->load('details.product');

                foreach ($transaction->details as $item) {
                    $product = Product::findOrFail($item->product_id);
                    if ($product->stock < $item->qty) {
                        throw new \Exception("Stok produk {$product->product_name} tidak mencukupi (Tersedia: {$product->stock}, Dipesan: {$item->qty}).");
                    }
                }

                // Decrement stock for all items
                foreach ($transaction->details as $item) {
                    $product = Product::findOrFail($item->product_id);
                    $product->decrement('stock', $item->qty);
                }

                // Complete transaction
                $transaction->update([
                    'status' => 'completed',
                    'payment_method' => $request->input('payment_method'),
                    'payment_proof' => $proofUrl,
                    'payment_proof_public_id' => $proofPublicId,
                    'amount_paid' => $transaction->total,
                    'change_amount' => 0,
                    'user_id' => Auth::id(), // cashier/admin ID who approved
                ]);
            });

            return redirect()->route('admin.approvals.index')->with('success', 'Transaksi berhasil disetujui dan stok gudang telah diperbarui.');

        } catch (\Exception $e) {
            // Clean up uploaded file if DB transaction fails
            if ($proofUrl) {
                $supabase = new SupabaseStorageService();
                $supabase->delete($proofUrl);
            }

            return back()->withErrors(['stock' => $e->getMessage()]);
        }
    }

    /**
     * Reject a WhatsApp transaction.
     */
    public function reject(Transaction $transaction)
    {
        if (!$transaction->is_whatsapp) {
            abort(404);
        }

        if ($transaction->status !== 'pending') {
            return back()->withErrors(['status' => 'Transaksi ini sudah diproses.']);
        }

        $transaction->update([
            'status' => 'cancelled',
            'user_id' => Auth::id(), // admin ID who rejected
        ]);

        return redirect()->route('admin.approvals.index')->with('success', 'Transaksi berhasil ditolak dan dibatalkan.');
    }
}
