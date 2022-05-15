<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table='coupons';
    protected $fillable=[
        'coupon_type',
        'coupon_option',
        'coupon_code',
        'categories',
        'user',
        'status',
        'coupon_amount',
        'amount',
        'expiry_date',
        'amount_type'
    ];
}
