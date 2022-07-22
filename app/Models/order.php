<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class order extends Model
{
    use HasFactory, SoftDeletes;
    static $rules = [
        'name_order'          => 'required|string',
        'cantidad' => 'required|array|min:1',
        'cantidad.*' => 'required|gt:0|integer',
        'address' => 'required',
        'mail' => 'required',
        'number' => 'required|gt:0|integer',
        'payment_method' => 'required'

    ];
    static $messages = [
        'required'      => 'Este campo es obligatorio',
        'cantidad.required' => 'Debes seleccionar al menos un producto',
        'integer' => 'El número no puede ser decimal',
        'gt' => 'El número debe ser mayor a 0'
    ];

    protected $cast = ['listProducts' => 'array'];

    public function products()
    {
        return $this->belongsToMany(product::class, 'products_orders');
    }

    public function users()
    {
        return $this->belongToMany('App\Models\User');
    }
}
