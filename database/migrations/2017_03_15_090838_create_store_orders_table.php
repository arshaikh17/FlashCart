<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_orders', function(Blueprint $table)
        {
            $table->increments('so_id');
            $table->string('order_name');
            $table->integer('user_id');
            $table->integer('store_id');
            $table->tinyInteger('order_status');
            $table->integer('payment_method');
            $table->string('address_info');
            $table->string('invoice_id');
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
        Schema::dropIfExists('store_orders');
    }
}
