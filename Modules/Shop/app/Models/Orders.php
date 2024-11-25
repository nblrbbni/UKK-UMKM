<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Shop\Database\Factories\OrdersFactory;

class Orders extends Model
{
    use HasFactory;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'orders';
    protected $fillable = [
        'customer_id',
        'order_date',
        'total_amount',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'integer',
    ];

    protected $dates = ['deleted_at'];


    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'order_id');
    }

    public function deliveries()
    {
        return $this->hasMany(Deliveries::class, 'order_id');
    }

    public function scopeForCustomer($query, $customer)
    {
        return $query->where('customer_id', $customer->id);
    }

    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getTotalAmountAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function setTotalAmountAttribute($value)
    {
        $this->attributes['total_amount'] = is_string($value) ?
            (int) str_replace(['.', ','], '', $value) :
            $value;
    }
    // protected static function newFactory(): OrdersFactory
    // {
    //     // return OrdersFactory::new();
    // }

    public function deleteWithRelations()
    {
        $this->deliveries()->delete();

        $this->payments()->delete();

        $this->delete();
    }
}
