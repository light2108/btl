<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;
    protected $table='carts';
    protected $fillable=[
        'session_id',
        'user_id',
        'quantity',
        'product_id',
        'size'
    ];
    public static function userCartItems(){
        if(Auth::check()){
            $userCartItems=Cart::with(['product'=>function($query){
                $query->select('id', 'category_id', 'product_name', 'product_code', 'product_price', 'product_discount', 'product_color', 'main_image');
            }])->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
        }else{
            $userCartItems=Cart::with(['product'=>function($query){
                $query->select('id', 'category_id', 'product_name', 'product_code', 'product_price', 'product_discount', 'product_color', 'main_image');
            }])->where('session_id', Session::get('session_id'))->orderBy('id', 'Desc')->get()->toArray();
        }
        return $userCartItems;
    }
    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
    public static function getProductAttrPrice($product_id, $size){
        $attrPrice=Attr_Product::select('price')->where(['product_id'=>$product_id, 'size'=>$size])->first()->toArray();
        return $attrPrice['price'];
    }

}
