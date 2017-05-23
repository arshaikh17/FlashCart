<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_logs', function(Blueprint $table)
        {
            $table->increments('sl_id');
            $table->integer('store_id');
            $table->string('log');
            $table->integer('log_type');
            $table->integer('log_by');
            $table->integer('log_to');
            $table->string('log_linker');
            $table->tinyInteger('seen')->default(0);
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
        Schema::creatIfExists('store_logs');
    }
}
