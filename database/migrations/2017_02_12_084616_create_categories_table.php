<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function(Blueprint $table)
        {
            $table->increments('cat_id');
            $table->string('category_of_store');
            $table->string('label');
            $table->timestamps();
        });

        DB::table('categories')->insert(
                array(

                    array('category_of_store' => 'Games', 'label' => 'fa fa-gamepad'),
                    array('category_of_store' => 'Computers', 'label' => 'fa fa-desktop'),
                    array('category_of_store' => 'General', 'label' => ''),
                    array('category_of_store' => 'Clothes', 'label' => '')
                )
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
