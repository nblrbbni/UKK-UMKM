<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Shop\Database\Factories\WishlistsFactory;

class Wishlists extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'wishlists';
    protected $fillable = [
        'customer_id',
        'product_id'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    // protected static function newFactory(): WishlistsFactory
    // {
    //     // return WishlistsFactory::new();
    // }
}
