<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class map extends Model
{
    use HasFactory;

    static $rules = [
        'direccion'          => 'required|string',

    ];
    static  $messages = [
        'required'      => 'Este campo es obligatorio',
    ];
}
