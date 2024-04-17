<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating','comment', 'product_id', 'user_id', 'is_bought'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_id' => 'integer',
        'user_id' => 'integer',
        'rating' => 'integer',
        'is_bought' => 'boolean'
    ];
}
