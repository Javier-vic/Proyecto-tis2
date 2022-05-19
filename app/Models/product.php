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
    public function category_products()
    {
        return $this->hasMany(category_product::class);


    }

    
    public function orders()
    {
    
        return $this->belongsToMany(order::class);    
    
    
    }
}
