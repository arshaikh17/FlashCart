<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashcartRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashcart_requests', function(Blueprint $table)
        {
            $table->increments('request_id');
            $table->string('request_title');
            $table->string('request_email');
            $table->text('request_description');
            $table->string('request_priority');
            $table->string('request_link');
            $table->string('request_image');
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
        Schema::dropIfExists('flashcart_requests');
    }
}
