<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type', 'product', 'quantity', 'value', 'sellers_user_id', 'order_id', 'is_paid', 'is_delivered', 'is_sent'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'value' => 'float',
        'quantity' => 'integer',
        'order_id' => 'integer',
        'sellers_user_id' => 'integer',
        'is_paid' => 'boolean',
        'is_sent' => 'boolean',
        'is_delivered' => 'boolean', 
    ];
}
