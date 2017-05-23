<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreUserMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_user_messages', function(Blueprint $table)
        {
            $table->increments('message_id');
            $table->integer('user_type');
            $table->integer('message_to');
            $table->string('message_title');
            $table->string('message_text');
            $table->tinyInteger('seen')->default(0);
            $table->integer('message_after');
            $table->tinyInteger('message_type');
            $table->integer('message_from');
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
        Schema::dropIfExists('store_user_messages');
    }
}
