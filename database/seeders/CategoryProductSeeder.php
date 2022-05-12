<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\category_product;


class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $producto = new category_product;
        $producto->name = 'Ramen';
        $producto->save();

        $producto = new category_product;
        $producto->name = 'Sushi';
        $producto->save();
    }
}
