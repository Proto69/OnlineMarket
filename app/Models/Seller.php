<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    public function products()
    {
        return $this->hasMany(Product::class)->get();
    }

    public function logs()
    {
        return $this->hasMany(Log::class)->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'account_id', 'balance', 'is_test'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'balance' => 'float',
        'is_test' => 'boolean',
    ];
}
