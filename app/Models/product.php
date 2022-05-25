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
        'stock'          => 'required|string',
        'description'          => 'required|string',
        'price'          => 'required|string',
        'id_category_product'          => 'required|string',
        'image_product' => 'required|file'

    ];
    static  $messages = [
        'required'      => 'Este campo es obligatorio',
    ];
    public function category_products()
    {
        return $this->hasMany(category_product::class);
    }


    public function orders()
    {

        return $this->belongsToMany(order::class);
    }
}
