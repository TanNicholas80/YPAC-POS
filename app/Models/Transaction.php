<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['invoice_number', 'subtotal', 'tax', 'total', 'payment_method', 'amount_paid', 'change_amount', 'status', 'user_id', 'qris_image', 'qris_public_id', 'is_whatsapp', 'customer_name', 'customer_address', 'shipping_cost', 'payment_proof', 'payment_proof_public_id'])]
class Transaction extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'subtotal' => 'float',
            'tax' => 'float',
            'total' => 'float',
            'amount_paid' => 'float',
            'change_amount' => 'float',
            'shipping_cost' => 'float',
        ];
    }

    /**
     * Get the user (cashier/admin) who recorded the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the detailed items of the transaction.
     */
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetails::class, 'transaction_id');
    }
}
