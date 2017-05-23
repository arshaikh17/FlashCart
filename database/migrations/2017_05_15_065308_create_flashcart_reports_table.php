<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashcartReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashcart_reports', function(Blueprint $table)
        {
            $table->increments('report_id');
            $table->string('report_name');
            $table->string('report_email');
            $table->string('report_title');
            $table->text('report_description');
            $table->string('report_link');
            $table->string('report_support');
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
        Schema::dropIfExists('flashcart_reports');
    }
}
