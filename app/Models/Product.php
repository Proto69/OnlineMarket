<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function characteristics()
    {
        return $this->hasMany(Characteristic::class)->get();
    }

    public function punishments()
    {
        return $this->hasMany(Punishment::class)->get();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->get();
    }

    public function images()
    {
        return $this->hasMany(Image::class)->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'description', 'image', 'price', 'quantity', 'bought_quantity', 'currency', 'active', 'user_id', 'seller_user_id', 'is_deleted', 'category', 'rating'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'price' => 'float',
        'quantity' => 'integer',
        'active' => 'boolean',
        'bought_quantity' => 'integer',
        'is_deleted' => 'boolean',
        'category' => 'integer',
        'rating' => 'float',
        'seller_user_id' => 'integer'
    ];

    public function getImageURL()
    {
        if ($this->image) {
            return url('storage/' . $this->image);
        }
        return "";
    }
}
