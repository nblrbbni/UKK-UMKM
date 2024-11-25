<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'subtotal'
    ];

    /**
     * Relationship with Products
     */
    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    /**
     * Relationship with Orders
     */
    public function orders()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    /**
     * Getter for subtotal with formatted display
     */
    public function getSubtotalAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    /**
     * Setter for subtotal to handle string and integer inputs
     */
    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = is_string($value) ?
            (int) str_replace(['.', ','], '', $value) :
            $value;
    }

    /**
     * Get the raw original subtotal value
     */
    public function getRawSubtotal()
    {
        return $this->getRawOriginal('subtotal');
    }
}
