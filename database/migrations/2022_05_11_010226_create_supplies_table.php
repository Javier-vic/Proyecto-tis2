<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->string('name_supply');
            $table->string('unit_meassurement');
            $table->float('quantity');
            $table->BigInteger('id_category_supplies')->unsigned();
            $table->softDeletes();            
            $table->timestamps();
            $table->foreign('id_category_supplies')->references('id')->on('category_supplies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplies');
    }
}
