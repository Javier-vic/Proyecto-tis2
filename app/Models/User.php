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
        'name', 'email', 'password', 'id_role', 'address', 'phone'
    ];
    static $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        // 'id_role'=>'required',
        'address' => 'required',
        'phone' => 'required|lt:999999999|gt:0'
    ];
    static $messages = [
        'required' => 'El campo es obligatorio',
        'email' => 'No es un correo electrónico válido.',
        'lt' => 'El numero no existe',
        'gt' => 'No es un numero valido'
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
        return $this->hasOne(role::class, 'id', 'id_role');
    }

    //Relación many to many
    public function coupons()
    {
        return $this->belongsToMany('App\Models\coupon');
    }
}
