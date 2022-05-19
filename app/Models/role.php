<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_role'
    ];
    public function permit(){
        return $this->belongsToMany(permit::class,'role_permit','id_role','id_permit');
    }
}
