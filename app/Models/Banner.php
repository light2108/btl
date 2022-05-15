<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table='banners';
    protected $fillable=[
        'image',
        'status',
        'title',
        'alt',
        'link'
    ];
    public static function banner(){
        $banners=Banner::where('status', 1)->get();
        return $banners;
    }
}
