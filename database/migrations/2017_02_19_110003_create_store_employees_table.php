<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_employees', function(Blueprint $table)
        {
            $table->increments('se_id');
            $table->integer('emp_id');
            $table->integer('store_id');
            $table->tinyInteger('current')->default(1);
            $table->string('emp_salary');
            $table->string('emp_position')->default('Employee');
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
        Schema::dropIfExists('store_employees');
    }
}
