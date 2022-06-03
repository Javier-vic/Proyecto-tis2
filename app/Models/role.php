<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_role',
        'permits'
    ];
    static $rules = [
        'name_role' => 'required',
        'permits' => 'required'
    ];
    static $message = [
        'permits.required' => 'Es obligatorio seleccionar a lo menos un permiso',
        'required' => 'Este campo es obligatorio',
    ];
    public function permit(){
        return $this->belongsToMany(permit::class,'role_permit','id_role','id_permit');
    }
}
