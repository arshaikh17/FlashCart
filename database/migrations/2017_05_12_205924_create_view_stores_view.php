<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewStoresView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE VIEW view_stores
AS
SELECT s.store_id,store_name,store_username,store_email,slug,s.created_at,store_category,cat_id,category_of_store,label,id,min_wage,max_wage,status,bm_id,brand_logo,brand_icon FROM stores as s
LEFT JOIN categories as c ON s.store_category = c.category_of_store
LEFT JOIN store_employments as se ON s.store_id = se.store_id
LEFT JOIN store_brandmarks as sb ON s.store_id = sb.store_id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_stores');
    }
}
