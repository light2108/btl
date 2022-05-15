<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    protected $table='sections';
    protected $fillable=[
        'name',
        'status'
    ];
    public static function sections(){
        $getsections=Sections::with('categories')->where('status', 1)->get();
        // echo "<pre>"; print_r($getsections); die;
        // dd($getsections);
        return $getsections;
    }
    public function categories(){
        return $this->hasMany('App\Models\Category', 'section_id')->where(['parent_id'=>'0', 'status'=>1])->with('subcategories');
    }
}
