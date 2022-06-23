<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\map;

class mapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $producto = new map;
        $producto->direccion = 'Puren 596 Chillán, Ñuble';
        $producto->latitud = '-36.6138882';
        $producto->longitud = '-72.1053811';
        $producto->delivery_distance = '0';
        $producto->unit = 'kilometer';
        $producto->save();
    }
}
