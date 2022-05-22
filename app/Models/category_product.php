<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category_product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function products()
    {
        return $this->belongsTo(product::class, 'products_id_category_product_foreign', 'id_category_product');
    }
}
