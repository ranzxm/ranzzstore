<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "order_trx_id",
        "phone_number",
        "total_amount",
        "product_id",
        "discount",
        "voucher_code",
        "is_paid"
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
