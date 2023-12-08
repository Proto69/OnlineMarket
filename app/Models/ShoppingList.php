<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyers_user_id', 'products_id'
    ];

    protected $casts = [
        'buyers_user_id' => 'integer',
        'products_id' => 'integer',
    ];
}
