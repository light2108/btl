<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'section_id',
        'brand_id',
        'product_name',
        'product_code',
        'product_color',
        'product_price',
        'product_discount',
        'product_weight',
        'product_video',
        'main_image',
        'description',
        'wash_care',
        'fabric',
        'pattern',
        'sleeve',
        'fit',
        'occassion',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_featured',
        'status'
    ];
    public function section(){
        return $this->belongsTo('App\Models\Sections', 'section_id', 'id');
    }
    public function category(){
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
    public function brand(){
        return $this->belongsTo('App\Models\Brand', 'brand_id', 'id');
    }
    public function attributes(){
        return $this->hasMany('App\Models\Attr_Product', 'product_id', 'id');
    }
    public function images(){
        return $this->hasMany('App\Models\Products_images', 'product_id', 'id');
    }
    public static function getDiscountPrice($product_id){
        $proDetails=Product::select('product_discount', 'product_price', 'category_id')->where('id', $product_id)->first()->toArray();
        $catDetails=Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount']>0){
            $discount_price=$proDetails['product_price']-($proDetails['product_price']*$proDetails['product_discount']/100);
        }else if($catDetails['category_discount']>0){
            $discount_price=$proDetails['product_price']-($catDetails['category_discount']*$proDetails['product_price']/100);
        }else{
            $discount_price=0;
        }
        return $discount_price;
    }
    public static function getDiscountAttrPrice($product_id, $size){
        $proAttrPrice=Attr_Product::where(['product_id'=>$product_id, 'size'=>$size])->first()->toArray();
        $proDetails=Product::select('product_discount', 'product_price', 'category_id')->where('id', $product_id)->first()->toArray();
        $catDetails=Category::select('category_discount')->where('id', $proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount']>0){
            $discounted_price=$proAttrPrice['price']-($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount=$proAttrPrice['price']-$discounted_price;
        }else if($catDetails['category_discount']>0){
            $discounted_price=$proAttrPrice['price']-($catDetails['category_discount']*$proAttrPrice['price']/100);
            $discount=$proAttrPrice['price']-$discounted_price;
        }else{
            $discounted_price=$proAttrPrice['price'];
            $discount=0;
        }
        return array('product_price'=>$proAttrPrice['price'], 'discounted_price'=>$discounted_price, 'discount'=>$discount);
    }
}
