<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class Customer extends Authenticatable
class Customer extends Authenticatable
{
    use HasFactory;
    protected $guard = 'customer';
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $guarded = [];
}