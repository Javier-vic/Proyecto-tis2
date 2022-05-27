<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $producto = new product;
        $producto->stock         = '100';
        $producto->name_product   = 'Korukushi';
        $producto->description    = 'Deliciosa receta familiar que se remonta al 1893.';
        $producto->id_category_product = '1';
        $producto->price = '2500';
        $producto->image_product = 'uploads\noborrar.png';
        $producto->save();

        $producto = new product;
        $producto->stock         = '300';
        $producto->name_product   = 'Purusshi';
        $producto->description    = 'El sushi se hace con un arroz blanco y dulce, de grano corto, llamado arroz japonés; se adereza con vinagre de arroz, azúcar, sal, alga konbu (昆布) y vino de arroz nihonshū o mirin (日本酒) que en Occidente se conoce como sake, aunque en Japón sake se refiere a cualquier bebida alcohólica.';
        $producto->id_category_product = '2';
        $producto->price = '400';
        $producto->image_product = 'uploads\noborrar.png';
        $producto->save();
    }
}
