<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class permitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipe_permit = [
            'publicidad',
            'insumos',
            'ventas',
            'delivery',
            'trabajadores',
            'asistencia',
            'roles'
        ];
        $tipe_permit = array_map( function($permit){
            return[
                'tipe_permit' => $permit
            ];
        },$tipe_permit);
        DB::table('permits')->insert($tipe_permit);
    }
}
