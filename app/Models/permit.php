<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permit extends Model
{
    use HasFactory;
    public function role(){
        
        return $this->belongsToMany('App\role');
    }

    public function products()
    {
    
        return $this->belongsToMany(product::class);    
    
    
    }
}
