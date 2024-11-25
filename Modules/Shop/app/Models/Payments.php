<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Modules\Shop\Database\Factories\PaymentsFactory;

class Payments extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'payment_date',
        'payment_method',
        'amount',
    ];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    // protected static function newFactory(): PaymentsFactory
    // {
    //     // return PaymentsFactory::new();
    // }
}
