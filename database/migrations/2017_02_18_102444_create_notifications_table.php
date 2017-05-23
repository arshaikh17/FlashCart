<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function(Blueprint $table)
        {
            $table->increments('notification_id');
            $table->integer('to_id')->nullable(false);
            $table->integer('from_id')->nullable(false);;
            $table->integer('to_specific');
            $table->integer('notification_type');
            $table->integer('link_type');
            $table->string('link');
            $table->string('seen')-default(0);
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
        Schema::dropIfExists('notifications');
    }
}
