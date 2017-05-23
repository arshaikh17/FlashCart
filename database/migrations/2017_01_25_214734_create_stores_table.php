<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function(Blueprint $table)
        {
            $table->increments('store_id');
            $table->string('store_name')->unique();
            $table->string('store_username')->unique();
            $table->string('store_email')->unique();
            $table->string('slug')->unique();
            $table->integer('store_category');
            $table->string('password');
            $table->string('secret_code');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE stores ADD FULLTEXT search(store_name)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
