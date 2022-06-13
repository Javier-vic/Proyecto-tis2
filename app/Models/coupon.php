<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class coupon extends Model
{
    use HasFactory, SoftDeletes;

    static $rules = [
        'code'          => 'required|string',
        'percentage'          => 'required|integer',
        'caducity'          => 'required|string',
        'emited'          => 'required|string',
        'quantity' => 'required|integer|gt:0|numeric'

    ];

    static $messages = [
        'required'      => ' Este campo es obligatorio',
        'numeric' => ' Solo se permiten números',
        'gt' => ' Solo se permiten números mayores a 0',
        'integer' => ' Solo se permiten números enteros',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\user');
    }
}
