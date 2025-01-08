<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "description",
        "category_id",
        "provider_id",
        "icon",
        "is_available",
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product_denoms(): HasMany
    {
        return $this->hasMany(ProductDenom::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function product_promo(): HasOne
    {
        return $this->hasOne(ProductPromo::class);
    }

    public function input_fields(): HasMany
    {
        return $this->hasMany(InputField::class);
    }
}
