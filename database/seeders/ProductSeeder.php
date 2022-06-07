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
        //RAMEN
        $producto = new product;
        $producto->stock         = '100';
        $producto->name_product   = 'Korukushi';
        $producto->description    = 'Pescado chino, arroz , korugumi , limón y sal.';
        $producto->id_category_product = '1';
        $producto->price = '2500';
        $producto->image_product = 'uploads\noborrar.png';
        $producto->save();

        $producto = new product;
        $producto->stock         = '100';
        $producto->name_product   = 'Pashoshi';
        $producto->description    = 'Pescado chino, arroz , korugumi , limón y sal.';
        $producto->id_category_product = '1';
        $producto->price = '4000';
        $producto->image_product = 'uploads\noborrar.png';
        $producto->save();
        //END RAMEN

        //YAKISOBA
        $producto = new product;
        $producto->stock         = '300';
        $producto->name_product   = 'Purusshi';
        $producto->description    = 'Arroz blanco, sushi , miel , atún y limón.';
        $producto->id_category_product = '2';
        $producto->price = '5000';
        $producto->image_product = 'uploads\noborrar.png';
        $producto->save();

        $producto = new product;
        $producto->stock         = '300';
        $producto->name_product   = 'Kolashi';
        $producto->description    = 'Arroz blanco, sushi , miel , atún y limón.';
        $producto->id_category_product = '2';
        $producto->price = '7000';
        $producto->image_product = 'uploads\noborrar.png';
        $producto->save();

        //END YAKISOBA

        //GOHAN
        $producto = new product;
        $producto->stock         = '300';
        $producto->name_product   = 'Plashuqui';
        $producto->description    = 'Jaiva, puré y especias.';
        $producto->id_category_product = '3';
        $producto->price = '2000';
        $producto->image_product = 'uploads\noborrar.png';
        $producto->save();

        $producto = new product;
        $producto->stock         = '300';
        $producto->name_product   = 'Corosi';
        $producto->description    = 'Tallarines con salsa boloñesa y queso rallado.';
        $producto->id_category_product = '3';
        $producto->price = '1500';
        $producto->image_product = 'uploads\noborrar.png';
        $producto->save();

        //END GOHAN
    }
}
