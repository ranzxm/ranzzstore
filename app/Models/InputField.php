<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InputField extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "field_type",
        "is_required",
        "label_helper"
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
