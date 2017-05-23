<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewProductsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
    {
        DB::statement('CREATE VIEW view_products
AS
SELECT id as product_id,sp.slug, product_name, product_price, 
product_discount, product_views,product_image1,product_image2,product_image3,product_image4, 
store_name, sp.store_id,
ssp.sale_id, sale_name, discount, store_username,product_quantity, ss.status as sale_status
FROM store_products AS sp
LEFT JOIN store_sale_products AS ssp ON sp.id = ssp.product_id
LEFT JOIN store_sales AS ss ON ssp.sale_id = ss.sale_id
INNER JOIN stores AS s ON sp.store_id = s.store_id
');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_products');
    }
}
