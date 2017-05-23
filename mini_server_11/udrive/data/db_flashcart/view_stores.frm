TYPE=VIEW
query=select `s`.`store_id` AS `store_id`,`s`.`store_name` AS `store_name`,`s`.`store_username` AS `store_username`,`s`.`store_email` AS `store_email`,`s`.`slug` AS `slug`,`s`.`created_at` AS `created_at`,`s`.`store_category` AS `store_category`,`c`.`cat_id` AS `cat_id`,`c`.`category_of_store` AS `category_of_store`,`c`.`label` AS `label`,`se`.`id` AS `id`,`se`.`min_wage` AS `min_wage`,`se`.`max_wage` AS `max_wage`,`se`.`status` AS `status`,`sb`.`bm_id` AS `bm_id`,`sb`.`brand_logo` AS `brand_logo`,`sb`.`brand_icon` AS `brand_icon` from (((`db_flashcart`.`stores` `s` left join `db_flashcart`.`categories` `c` on((`s`.`store_category` = `c`.`category_of_store`))) left join `db_flashcart`.`store_employments` `se` on((`s`.`store_id` = `se`.`store_id`))) left join `db_flashcart`.`store_brandmarks` `sb` on((`s`.`store_id` = `sb`.`store_id`)))
md5=875df423d63de77b26cdf26f6a79f136
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=2
with_check_option=0
revision=1
timestamp=2017-05-12 21:02:24
create-version=1
source=SELECT s.store_id,store_name,store_username,store_email,slug,s.created_at,store_category,cat_id,category_of_store,label,id,min_wage,max_wage,status,bm_id,brand_logo,brand_icon FROM stores as s\nLEFT JOIN categories as c ON s.store_category = c.category_of_store\nLEFT JOIN store_employments as se ON s.store_id = se.store_id\nLEFT JOIN store_brandmarks as sb ON s.store_id = sb.store_id
