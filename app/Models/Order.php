<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'buyers_user_id', 'id', 'is_paid', 'session_id', 'total_price', 'full_name', 'phone', 'address', 'is_delivered', 'is_sent'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'buyers_user_id' => 'integer',
        'total_price' => 'decimal:2',
        'is_paid' => 'boolean',
        'is_sent' => 'boolean',
        'is_delivered' => 'boolean',
    ];
}
