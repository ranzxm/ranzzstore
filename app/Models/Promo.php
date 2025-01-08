<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "discount"
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
