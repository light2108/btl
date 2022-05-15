<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guard='admin';
    protected $fillable=[
        'name', 'status', 'mobile', 'image', 'password', 'type', 'email'
    ];
    protected $hidden=[
        'password', 'remember_token'
    ];
}
