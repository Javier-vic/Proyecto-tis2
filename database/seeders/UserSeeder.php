<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::Create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'id_role' => '1',
            'phone' => 56912341234,
            'address'=> 'Example #123 pobl Example',
            'password' => Hash::make('12341234'),
        ]);
        User::Create([
            'name' => 'Test Trabajador',
            'email' => 'test2@gmail.com',
            'id_role'=> '3',
            'phone' => 56943214321,
            'address'=> 'Example2  #321 pobl Example 2',
            'password' => Hash::make('12341234'),
        ]);
        User::Create([
            'name' => 'Test comprador',
            'email' => 'test3@gmail.com',
            'id_role' => '2',
            'phone' => 56911112222,
            'address' => 'Example #221 pobl Example 3',
            'password' => Hash::make('12341234'),
        ]);
    }
}
