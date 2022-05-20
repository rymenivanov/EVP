<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_id')->unsigned()->index()->nullable();
            $table->integer('usage_id')->unsigned()->index()->nullable();
            $table->string('cost', 50);
            $table->integer('address_id')->unsigned()->index()->nullable();
            $table->integer('points')->default(1);
            $table->boolean('is_verified')->default(true);
            $table->uuid('hash');
            $table->integer('remote_id')->nullable();
            $table->uuid('remote_uuid');
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('status_id')->references('id')->on('status_types');
            // $table->foreign('usage_id')->references('id')->on('usage_types');
            // $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
}
