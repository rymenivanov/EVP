<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('manufacturer_id')->unsigned()->index()->nullable();
            $table->string('title');
            $table->integer('speed')->nullable();
            $table->decimal('acceleration', 5, 2)->nullable();
            $table->integer('capacity')->nullable();
            $table->text('charging_time')->nullable();
            $table->integer('range');
            $table->uuid('hash');
            $table->softDeletes();

            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('makes');
    }
}
