<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_role','address','phone'
    ];
    static $rules = [
        'name' => 'required',
        'email' => 'required', 
        'password' => 'required',
        'id_role'=>'required',
        'address'=>'required',
        'phone' => 'required'
    ];
    static $messages = [
        'required' => 'El campo es obligatorio'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function role()
    {
        return $this->hasOne(role::class,'id','id_role');
    }

    //Relación many to many
    public function coupons()
    {
        return $this->belongsToMany('App\Models\coupon');
    }

    public function orders(){
        return $this->belongToMany('App\Models\order');
    }
}
