<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOrder extends Model
{
    use HasFactory;
    protected $table="check_order";
    protected $fillable=[
        'order_id',
        'status'
    ];

}
