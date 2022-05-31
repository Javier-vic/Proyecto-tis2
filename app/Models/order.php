<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_order',
  

    ];

    static $rules = [
        'name_order'          => 'required|string',
  
    ];

    static $rulesEdit = [
        'name_order'          => 'required|string',
        

    ];
    static  $messages = [
        'required'      => 'Este campo es obligatorio',
    ];

    public function products()
{
    return $this->belongsToMany(product::class,'products_orders');
}


}

