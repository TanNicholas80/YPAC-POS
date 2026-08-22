<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminApprovalController extends Controller
{
    /**
     * Display a listing of WhatsApp customer transactions for Delivery & Order Tracking.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $deliveryStatus = $request->input('delivery_status', 'all');
        $search = $request->input('search');

        $query = Transaction::where('is_whatsapp', true)->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($deliveryStatus !== 'all') {
            $query->where('delivery_status', $deliveryStatus);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', '%' . $search . '%')
                  ->orWhere('customer_name', 'like', '%' . $search . '%');
            });
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('admin.approvals.index', compact('transactions', 'status', 'deliveryStatus', 'search'));
    }

    /**
     * Display details of a specific WhatsApp transaction (Tracking & Proof inspection).
     */
    public function show(Transaction $transaction)
    {
        if (!$transaction->is_whatsapp) {
            abort(404);
        }

        $transaction->load(['details.product', 'details.productVariant', 'user']);

        return view('admin.approvals.show', compact('transaction'));
    }

    /**
     * Update delivery status (Belum Dikirim -> Sedang Dikirim -> Sudah Terkirim).
     */
    public function updateDeliveryStatus(Request $request, Transaction $transaction)
    {
        if (!$transaction->is_whatsapp) {
            abort(404);
        }

        $request->validate([
            'delivery_status' => 'required|in:belum_dikirim,sedang_dikirim,sudah_terkirim',
        ]);

        $currentStatus = $transaction->delivery_status;
        $newDeliveryStatus = $request->input('delivery_status');

        // Hierarchy rule: belum_dikirim (1) -> sedang_dikirim (2) -> sudah_terkirim (3)
        $statusLevels = [
            'belum_dikirim' => 1,
            'sedang_dikirim' => 2,
            'sudah_terkirim' => 3,
        ];

        if (($statusLevels[$currentStatus] ?? 1) === 3) {
            return back()->withErrors(['delivery_status' => 'Transaksi yang sudah terkirim tidak dapat diubah lagi statusnya.']);
        }

        if (($statusLevels[$newDeliveryStatus] ?? 1) < ($statusLevels[$currentStatus] ?? 1)) {
            return back()->withErrors(['delivery_status' => 'Status pengiriman tidak dapat diubah mundur ke status sebelumnya.']);
        }

        $updateData = [
            'delivery_status' => $newDeliveryStatus,
        ];

        // If marked as 'sudah_terkirim', automatically set status to 'completed' if pending
        if ($newDeliveryStatus === 'sudah_terkirim' && $transaction->status === 'pending') {
            $updateData['status'] = 'completed';
            $updateData['user_id'] = Auth::id();
        }

        $transaction->update($updateData);

        return back()->with('success', 'Status pengiriman pesanan berhasil diperbarui!');
    }

    /**
     * Bulk update delivery status for selected transactions and return WA queue items.
     */
    public function bulkUpdateDeliveryStatus(Request $request)
    {
        $request->validate([
            'transaction_ids' => 'required|array|min:1',
            'transaction_ids.*' => 'exists:transactions,id',
            'delivery_status' => 'required|in:belum_dikirim,sedang_dikirim,sudah_terkirim',
        ]);

        $ids = $request->input('transaction_ids');
        $newStatus = $request->input('delivery_status');

        $statusLevels = [
            'belum_dikirim' => 1,
            'sedang_dikirim' => 2,
            'sudah_terkirim' => 3,
        ];
        $newLevel = $statusLevels[$newStatus] ?? 1;

        $transactions = Transaction::whereIn('id', $ids)->where('is_whatsapp', true)->get();

        $updatedCount = 0;
        $updatedIds = [];

        foreach ($transactions as $trx) {
            $currentLevel = $statusLevels[$trx->delivery_status] ?? 1;

            // Bypass if already completed (level 3) or trying to downgrade status
            if ($currentLevel === 3 || $newLevel < $currentLevel) {
                continue;
            }

            $updateData = [
                'delivery_status' => $newStatus,
            ];

            if ($newStatus === 'sudah_terkirim' && $trx->status === 'pending') {
                $updateData['status'] = 'completed';
                $updateData['user_id'] = Auth::id();
            }

            $trx->update($updateData);
            $updatedCount++;
            $updatedIds[] = $trx->id;
        }

        $transactions = Transaction::whereIn('id', $updatedIds)->get();
        $queueData = [];

        foreach ($transactions as $trx) {
            $queueData[] = [
                'id' => $trx->id,
                'invoice_number' => $trx->invoice_number,
                'customer_name' => $trx->customer_name,
                'customer_phone' => $trx->customer_phone,
                'delivery_status' => $trx->delivery_status,
                'whatsapp_url' => self::generateWhatsAppUrl($trx, $newStatus),
            ];
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $updatedCount . ' transaksi berhasil diperbarui!',
                'queue' => $queueData,
            ]);
        }

        return back()->with('bulk_success', $updatedCount . ' status transaksi berhasil diperbarui!')
                     ->with('wa_queue', $queueData);
    }

    /**
     * Helper to generate customized WhatsApp message URL for customer follow-up.
     */
    public static function generateWhatsAppUrl(Transaction $transaction, $statusOverride = null)
    {
        $phone = preg_replace('/[^0-9]/', '', $transaction->customer_phone ?? '');
        if (empty($phone)) {
            return null;
        }

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        $status = $statusOverride ?? $transaction->delivery_status;
        $name = $transaction->customer_name ?: 'Pelanggan';
        $invoice = $transaction->invoice_number;

        if ($status === 'sedang_dikirim') {
            $msg = "Halo Sdr/i {$name},\n\nPesanan Anda di KUBE YPAC dengan No. Invoice *{$invoice}* saat ini *SEDANG DIKIRIM* ke alamat Anda:\n📍 {$transaction->customer_address}\n\nMohon ditunggu kedatangan paket Anda ya. Terima kasih! 🙏";
        } elseif ($status === 'sudah_terkirim') {
            $msg = "Halo Sdr/i {$name},\n\nPesanan Anda di KUBE YPAC dengan No. Invoice *{$invoice}* telah *SUDAH TERKIRIM* sampai ke alamat tujuan.\n\nTerima kasih banyak telah berbelanja dan mendukung karya siswa disabilitas YPAC! 😊❤️";
        } else {
            $msg = "Halo Sdr/i {$name},\n\nKonfirmasi pesanan Anda di KUBE YPAC dengan No. Invoice *{$invoice}* saat ini sedang *DIPROSES & DISIAPKAN*.\n\nKami akan menginformasikan kembali setelah paket Anda dikirim. Terima kasih! 🙏";
        }

        return "https://wa.me/{$phone}?text=" . urlencode($msg);
    }

    /**
     * Approve payment proof & mark transaction completed manually if needed.
     */
    public function approve(Request $request, Transaction $transaction)
    {
        if (!$transaction->is_whatsapp) {
            abort(404);
        }

        if ($transaction->status !== 'pending') {
            return back()->withErrors(['status' => 'Transaksi ini sudah diproses.']);
        }

        $transaction->update([
            'status' => 'completed',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.approvals.index')->with('success', 'Transaksi berhasil dikonfirmasi dan disetujui.');
    }

    /**
     * Reject/Cancel a WhatsApp transaction.
     */
    public function reject(Transaction $transaction)
    {
        if (!$transaction->is_whatsapp) {
            abort(404);
        }

        if ($transaction->status !== 'pending') {
            return back()->withErrors(['status' => 'Transaksi ini sudah diproses.']);
        }

        // Restore stock
        $transaction->load('details');
        foreach ($transaction->details as $item) {
            if ($item->product_variant_id) {
                $v = ProductVariant::find($item->product_variant_id);
                if ($v) $v->increment('stock', $item->qty);
            } else {
                $p = Product::find($item->product_id);
                if ($p) $p->increment('stock', $item->qty);
            }
        }

        $transaction->update([
            'status' => 'cancelled',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.approvals.index')->with('success', 'Transaksi berhasil dibatalkan dan stok dikembalikan.');
    }
}
