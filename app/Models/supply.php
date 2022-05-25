<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class supply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_supply',
        'unit_meassurement',
        'quantity',
        'id_category_supplies',
    ];

    static $rules = [
        'name_supply'          => 'required|string',           
        'unit_meassurement'          => 'required|string',           
        'quantity'          => 'required|string',           
        'id_category_supplies'          => 'required|string',           
    ];
    
    static  $messages = [
        'required'      => 'Este campo es obligatorio',
    ];

    public function category_supply() {
        return $this->belongsTo(category_supply::class, 'id_category_supplies');
    }
}
