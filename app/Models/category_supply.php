<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category_supply extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_category'
    ];

    static $rules = [
        'name_category'          => 'required|string'               
    ];
    
    static  $messages = [
        'required'      => 'Este campo es obligatorio',
    ];

    public function supplies() {
        return $this->hasMany(supply::class, 'id_category_supplies');
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (category_supply $category_supply) {

            foreach ($category_supply->supplies as $supply)
            {
                $supply->delete();
            }
        });
    }
}
