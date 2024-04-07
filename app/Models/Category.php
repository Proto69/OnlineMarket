<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class)->get();
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'products_count', 'is_accepted', 'general_category', 'id', 'main_category'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'products_count' => 'integer',
        'is_accepted' => 'boolean',
        'id' => 'integer',
        'main_category' => 'integer'
    ];
}
