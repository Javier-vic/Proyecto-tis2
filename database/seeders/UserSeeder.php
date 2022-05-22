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
            'password' => Hash::make('12341234'),
        ]);
    }
}
