<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $fillable=[
        'name',
        'mobile',
        'email',
        'address',
        'user_id',
        'grand_total',
        'coupon_code',
        'coupon_amount',
        'shipping_charges',
        'order_status',
    ];
    public function order_product(){
        return $this->hasMany('App\Models\Order_Product', 'order_id', 'id');
    }
    public function check_order(){
        return $this->hasMany('App\Models\CheckOrder', 'order_id', 'id');
    }
}
