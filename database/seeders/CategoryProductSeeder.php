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

        $category_product = [
            'Ramen',
            'Yakisoba',
            'Gohan',
            'Yakimeshi',
            'Appetizers',
            'Gohan Katsu',
            'Tablas',
            'Postres',
        ];

        $category_product = array_map(function ($categoryProduct) {
            $producto = new category_product;
            $producto->name = $categoryProduct;
            $producto->save();
        }, $category_product);
    }
}
