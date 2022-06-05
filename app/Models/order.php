<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    public function products()
{
    return $this->belongsToMany(product::class,'products_orders');
}

    public function users(){
        return $this->belongToMany('App\Models\User');
    }


}

