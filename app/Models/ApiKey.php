<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class ApiKey extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "name",
        "kuota",
        "key",
        "secure",
        "allowed_site"
    ];
}
