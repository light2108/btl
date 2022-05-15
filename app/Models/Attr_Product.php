<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attr_Product extends Model
{
    use HasFactory;
    protected $table='product_attributes';
    protected $fillable=[
        'product_id',
        'size',
        'price',
        'stock',
        'sku',
        'status'
    ];
    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
