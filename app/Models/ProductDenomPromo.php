<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDenomPromo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "discount",
        "kuota",
        "start",
        "end",
        "product_denom_id"
    ];

    public function product_denom(): BelongsTo
    {
        return $this->belongsTo(ProductDenom::class);
    }
}
