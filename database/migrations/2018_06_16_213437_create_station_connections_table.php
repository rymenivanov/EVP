<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_connections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('station_id')->unsigned()->index()->nullable();
            $table->integer('connection_id')->unsigned()->index()->nullable();
            $table->integer('level_id')->unsigned()->index()->nullable();
            $table->integer('current_id')->unsigned()->index()->nullable();
            $table->decimal('power_kw', 10, 2);
            $table->decimal('amps', 10, 2);
            $table->decimal('voltage', 10, 2);

            $table->foreign('station_id')->references('id')->on('stations');
            $table->foreign('connection_id')->references('id')->on('connections');
            $table->foreign('current_id')->references('id')->on('currents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('station_connections');
    }
}
