<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->string('dob');
            $table->timestamps();
        });

        Schema::create('store_details', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('store_id')->unique();
            $table->string('tagline');
            $table->text('description');
            $table->text('welcome_note');
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
        Schema::dropIfExists('user_details');
        Schema::dropIfExists('store_details');
    }
}
