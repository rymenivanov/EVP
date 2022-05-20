<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trip_id')->unsigned()->index()->nullable();
            $table->string('title');
            $table->string('lat');
            $table->string('lng');
            $table->string('details')->nullable();
            $table->uuid('hash');
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stops');
    }
}
