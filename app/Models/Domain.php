<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name', 'expires_at', 'user_id'];

    protected $casts = [
        'expires_at' => 'date',
    ];
}
