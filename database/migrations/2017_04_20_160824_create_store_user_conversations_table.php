<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreUserConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_user_conversations', function(Blueprint $table)
        {
            $table->increments('suc_id');
            $table->string('suc_title');
            $table->integer('suc_from');
            $table->integer('suc_to');
            $table->tinyInteger('suc_keep_alive')->default(1);
            $table->tinyInteger('seen')->default(0);
            $table->integer('starter');
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
        Schema::dropIfExists('store_user_conversations');
    }
}
