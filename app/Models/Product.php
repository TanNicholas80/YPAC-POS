<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['category_id', 'unit_id', 'product_name', 'product_slug', 'description', 'product_story', 'price', 'stock', 'is_active'])]
class Product extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'float',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get the unit that owns the product.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitProduct::class, 'unit_id');
    }

    /**
     * Get the transaction details associated with the product.
     */
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetails::class, 'product_id');
    }

    /**
     * Get the images associated with the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    /**
     * Get the specifications associated with the product.
     */
    public function specifications(): HasMany
    {
        return $this->hasMany(SpecificationProduct::class, 'product_id');
    }
}
