<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products_Images extends Model
{
    use HasFactory;
    protected $table="products_images";
    protected $fillable=[
        'product_id',
        'image',
        'status'
    ];
}
