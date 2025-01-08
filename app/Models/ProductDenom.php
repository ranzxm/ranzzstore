<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDenom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "type",
        "icon",
        "price",
        "is_available",
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function product_denom_promo(): HasOne
    {
        return $this->hasOne(ProductDenomPromo::class);
    }
}
