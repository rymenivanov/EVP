<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('manufacturer_id')->unsigned()->index()->nullable();
            $table->integer('make_id')->unsigned()->index()->nullable();
            $table->uuid('hash');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            // $table->foreign('make_id')->references('id')->on('makes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
