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
            $table->integer('id_role')->unsigned();
            $table->integer('id_permit')->unsigned();
            $table->foreign('id_role')->references('id_role')->on('roles');
            $table->foreign('id_permit')->references('id_permit')->on('permits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permit');
    }
}
