<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('address');
            $table->string('town', 100);
            $table->string('state', 100);
            $table->string('postcode', 15);
            $table->integer('country_id')->unsigned()->index()->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('lat');
            $table->string('lng');
            $table->uuid('hash');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
