<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deliveries extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'deliveries';

    protected $fillable = [
        'order_id',
        'shipping_date',
        'tracking_code',
        'status'
    ];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public static function generateTrackingCode($order)
    {
        return 'ORD' . $order->id . date('ymd');
    }


    public static function calculateShippingDate($orderDate)
    {
        return now()->parse($orderDate)->addDays(2);
    }
}
