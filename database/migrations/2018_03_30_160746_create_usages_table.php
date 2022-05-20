<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usage_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->boolean('is_membership')->default(false);
            $table->boolean('is_pay_location')->default(false);
            $table->boolean('is_access_key')->default(false);
            $table->integer('remote_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usage_types');
    }
}
