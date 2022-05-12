<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permit', function (Blueprint $table) {
            $table->primary(['id_role','id_permit']);      
            $table->bigInteger('id_role')->unsigned();
            $table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
            $table->bigInteger('id_permit')->unsigned();
            $table->foreign('id_permit')->references('id')->on('permits');
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
        Schema::dropIfExists('role_permit');
        Schema::enableForeignKeyConstraints();
    }
}
