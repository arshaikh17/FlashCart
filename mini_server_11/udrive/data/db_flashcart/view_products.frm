TYPE=VIEW
query=select `sp`.`id` AS `product_id`,`sp`.`slug` AS `slug`,`sp`.`product_name` AS `product_name`,`sp`.`product_price` AS `product_price`,`sp`.`product_discount` AS `product_discount`,`sp`.`product_views` AS `product_views`,`sp`.`product_image1` AS `product_image1`,`sp`.`product_image2` AS `product_image2`,`sp`.`product_image3` AS `product_image3`,`sp`.`product_image4` AS `product_image4`,`s`.`store_name` AS `store_name`,`sp`.`store_id` AS `store_id`,`ssp`.`sale_id` AS `sale_id`,`ss`.`sale_name` AS `sale_name`,`ss`.`discount` AS `discount`,`s`.`store_username` AS `store_username`,`sp`.`product_quantity` AS `product_quantity`,`ss`.`status` AS `sale_status` from (((`db_flashcart`.`store_products` `sp` left join `db_flashcart`.`store_sale_products` `ssp` on((`sp`.`id` = `ssp`.`product_id`))) left join `db_flashcart`.`store_sales` `ss` on((`ssp`.`sale_id` = `ss`.`sale_id`))) join `db_flashcart`.`stores` `s` on((`sp`.`store_id` = `s`.`store_id`)))
md5=7a91f3ad9506540dce4092ba901d0218
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
revision=1
timestamp=2017-05-11 16:04:43
create-version=1
source=SELECT id as product_id,sp.slug, product_name, product_price, \nproduct_discount, product_views,product_image1,product_image2,product_image3,product_image4, \nstore_name, sp.store_id,\nssp.sale_id, sale_name, discount, store_username,product_quantity, ss.status as sale_status\nFROM store_products AS sp\nLEFT JOIN store_sale_products AS ssp ON sp.id = ssp.product_id\nLEFT JOIN store_sales AS ss ON ssp.sale_id = ss.sale_id\nINNER JOIN stores AS s ON sp.store_id = s.store_id
