<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Shop\Database\Factories\UsersFactory;

class Users extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'aktif',
    ];


    // protected static function newFactory(): UsersFactory
    // {
    //     // return UsersFactory::new();
    // }
}
