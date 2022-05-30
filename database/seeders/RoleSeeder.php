<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new role(['name_role'=>'Admin']);
        $role->save();
        for($i = 1; $i < 11 ; $i++){
            $role->permit()->attach($i);
        }
        $role = new role(['name_role'=>'User']);
        $role->save();
        
        $role = new role(['name_role'=>'Cocina']);
        $role->save();
        $role->permit()->attach([6,2,7]);
        
    }
}
