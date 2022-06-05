<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stock',
        'name_product',
        'description',
        'image_product',
        'id_category_product'

    ];

    static $rules = [
        'name_product'          => 'required|string',
        'stock'          => 'required|numeric|gt:0|integer',
        'description'          => 'required|string',
        'price'          => 'required|numeric|gt:0|integer',
        'id_category_product'          => 'required|string',
        'image_product' => 'required|file'

    ];

    static $rulesEdit = [
        'name_product'          => 'required|string',
        'stock'          => 'required|numeric|gt:0|integer',
        'description'          => 'required|string',
        'price'          => 'required|numeric|gt:0|integer',
        'id_category_product'          => 'required|string',

    ];
    static  $messages = [
        'required'      => ' Este campo es obligatorio',
        'numeric' => ' Solo se permiten números',
        'gt' => ' Solo se permiten números mayores a 0',
        'integer' => ' Solo se permiten números enteros',
    ];
    public function category_products()
    {
        return $this->hasMany(category_product::class);
    }


    public function orders()
    {

        return $this->belongsToMany(order::class, 'products_orders');
    }
}
