<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashcartPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashcart_partners', function(Blueprint $table)
        {
            $table->increments('partner_id');
            $table->string('partner_name');
            $table->text('partner_description');
            $table->string('partner_brandmark');
            $table->string('partner_website');
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
        Schema::dropIfExists('flashcart_partners');
    }
}
