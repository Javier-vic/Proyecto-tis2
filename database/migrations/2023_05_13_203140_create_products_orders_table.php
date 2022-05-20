<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_orders', function (Blueprint $table) {
            
            $table->primary(['id_product','id_order']);      
            $table->bigInteger('id_order')->unsigned();
            $table->foreign('id_order')->references('id')->on('orders');
            $table->bigInteger('id_product')->unsigned();
            $table->foreign('id_product')->references('id')->on('products');
           

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('products_orders');
        Schema::enableForeignKeyConstraints();
    }
}
