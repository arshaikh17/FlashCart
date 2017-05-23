<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_sales', function(Blueprint $table)
        {
            $table->increments('sale_id');
            $table->integer('store_id');
            $table->string('sale_name');
            $table->string('sale_tagline');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('sale_slug');
            $table->tinyInteger('status')->default(0);
            $table->string('discount')->default('0');
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
        Schema::dropIfExists('store_sales');
    }
}
