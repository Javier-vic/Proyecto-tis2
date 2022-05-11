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
            $table->unsignedBigInteger('id_category_supply');
            $table->softDeletes();            
            $table->timestamps();
            $table->foreign('id_category_supply')->references('id')->on('category_supply');
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
