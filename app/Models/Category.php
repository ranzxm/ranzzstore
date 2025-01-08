<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "icon",
        "description"
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function providers(): BelongsToMany
    {
        return $this->belongsToMany(Provider::class, 'category_provider', 'category_id', 'provider_id');
    }
}
