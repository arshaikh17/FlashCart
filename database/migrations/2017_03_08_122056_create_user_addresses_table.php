<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function(Blueprint $table)
        {
            $table->increments('ua_id');
            $table->integer('user_id');
            $table->string('house_no');
            $table->string('street');
            $table->string('area');
            $table->string('city');
            $table->string('state');
            $table->integer('postal');
            $table->string('phone');
            $table->string('mobile');
            $table->string('mobile_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
