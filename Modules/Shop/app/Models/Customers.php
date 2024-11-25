<?php

namespace Modules\Shop\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customers extends Authenticatable
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address1',
        'address2',
        'address3',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Orders::class, 'customer_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlists::class, 'customer_id');
    }

    public function product_reviews(): HasMany
    {
        return $this->hasMany(ProductReviews::class, 'customer_id');
    }
}
