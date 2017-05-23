<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_products', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('store_id');
            $table->string('product_code');
            $table->string('product_name');
            $table->string('product_desc');
            $table->integer('product_price')->default(0);
            $table->string('product_discount')->default(0);
            $table->integer('product_quantity')->default(0);
            $table->integer('category_id');
            $table->integer('product_views')->default(0);
            $table->string('product_image1');
            $table->string('product_image2');
            $table->string('product_image3');
            $table->string('product_image4');
            $table->integer('sub_category');
            $table->string('slug');
            $table->tinyInteger('display')->default(0);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE store_products ADD FULLTEXT search(product_name, product_desc)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_products');
    }
}
