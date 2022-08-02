<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class statusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('local_status')->insert([
            'opening' => '12:00 AM',
            'closing' => '12:00 PM',
            'status' => '0',
        ]);
    }
}
