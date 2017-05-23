<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//RegisterController
//AJAX REQUESTS
Route::post('check_username', 'Auth\RegisterController@check_user_username');
Route::post('check_email', 'Auth\RegisterController@check_user_email');



//Auth::routes();
Route::get('/login', function()
{
	return redirect()->to('/user/login');
});
Route::get('/user/register', array('as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm'));
Route::post('/user/register', array('as' => 'register', 'uses' => 'Auth\RegisterController@register'));
Route::get('/user/login', array('as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm'));
Route::post('/user/login', array('as' => 'login', 'uses' => 'Auth\LoginController@login'));
Route::post('/user/logout','Auth\LoginController@logout');
//UserController
Route::group(['middleware' => 'auth'], function()
{
	Route::get('/user/home', 'UserController@index');
	Route::get('/user/stores', 'UserController@user_stores');
	Route::get('/user/stores/personal', 'UserController@personal_stores');
	Route::get('/user/stores/employeed', 'UserController@employeed_stores');
	Route::get('/user/settings/', 'UserController@settings');
	Route::get('/user/settings/address', 'UserController@address');
	//Route::get('/user/conversations', 'UserController@goto_messages');
	//Route::get('/user/conversations/{storeId}', 'UserController@get_conversations');
	Route::get('/user/messages', 'UserController@direct_messages');

	Route::get('/user/conversations/{storeId?}/{convoId?}', 'UserController@get_messages');
	
	Route::post('/user/conversations/send_message', 'UserController@send_message');
	Route::post('/user/messages/send_message', 'UserController@send_direct_message');
	Route::post('/user/messages/seen_messages', 'UserController@mark_messages_seen');
	Route::post('/user/settings/address/edit', 'UserController@edit_address');
	Route::post('/user/settings/picture/save', 'UserController@save_picture');
	Route::post('/user/settings/primary/save', 'UserController@save_primary_information');
});


//StoreController
Route::group(['middleware' => 'auth'], function()
{
	Route::get('/store','StoreController@index');
	Route::get('/redirect/store/{sid}/{uid}', 'StoreController@redirect_store');
	Route::get('/store/open', 'StoreController@create_store');

	Route::get('/store/logs', 'StorePrivilegedController@get_logs');

	Route::get('/store/orders/', 'StoreController@view_all_orders');
	Route::get('/store/orders/order/{orderId}', 'StoreController@get_order');
	Route::post('/store/orders/order/find','StoreController@find_order');
	Route::get('/store/orders/order/{orderId}/action/{action}', 'StoreController@order_action');

	Route::get('/store/products', 'StoreController@list_product');
	Route::get('/store/products/category/{category}', 'StoreController@list_product_by_categories');
	Route::get('/store/products/category/{category}/sub_category/{sub_cat}', 'StoreController@list_product_by_sub_categories');
	Route::get('/store/products/add', 'StoreController@add_product');
	Route::get('/store/products/edit/{id}', 'StoreController@edit_p');
	Route::post('/store/product/display', 'StoreController@display_product');

	Route::get('/store/sales', 'StoreController@list_sale');
	Route::get('/store/sales/add', 'StoreController@add_sale');
	Route::post('/store/sales/save_sale', 'StoreController@save_sale');
	Route::get('/store/sales/sale/{id}/products', 'StoreController@get_sale');
	Route::get('/store/sales/sale/{sale}/products/{product}/add', 'StoreController@add_into_sale');
	Route::get('/store/sales/sale/{sale}/products/{product}/remove', 'StoreController@remove_from_sale');
	Route::get('/store/sales/sale/{sale}/status/{status}', 'StoreController@update_sale_status');

	
	Route::get('/store/settings/details', 'StoreController@setting_details');
	Route::get('/store/settings/categories', 'StoreController@setting_categories');
	Route::get('/store/settings/brand', 'StoreController@setting_brand');
	Route::get('/store/settings/policies', 'StoreController@setting_policies');
	Route::get('/store/settings/policies/{policy}', 'StoreController@setting_policy');
	Route::get('/store/settings/employment', 'StoreController@setting_employment');
	Route::get('/store/settings/store_category', 'StoreController@setting_store_category');
	Route::get('/store/settings/payment', 'StoreController@payment_options');
	Route::get('/store/settings/social', 'StoreController@social_media');
	Route::post('/store/settings/social_media/save', 'StoreController@save_social_media');
	Route::post('/store/settings/edit_policy', 'StoreController@edit_policy');
	Route::post('/store/settings/update_store', 'StoreController@update_store');
	Route::post('/store/settings/save_details', 'StoreController@save_details');
	Route::post('/store/products/add_p', 'StoreController@add_p');
	Route::post('/store/products/edited_p/{id}', 'StoreController@save_edit_p');
	Route::post('/store/settings/add_category', 'StoreController@add_category');
	Route::post('/store/settings/categories/sub-categories/add', 'StoreController@add_sub_categories');
	Route::post('/store/settings/save_brand_mark', 'StoreController@save_brand_mark');
	Route::post('/store/settings/add_policy', 'StoreController@add_policy');
	Route::post('/store/settings/update_employment', 'StoreController@update_employment');
	Route::post('/store/settings/setting_employment_wages', 'StoreController@setting_employment_wages');
	Route::post('/store/settings/save_category', 'StoreController@save_store_category');
	Route::post('/store/settings/payment/save_payment', 'StoreController@save_payment_method');
	Route::post('/store/settings/payment/{id}/{pay_id}/edit', 'StoreController@save_payment_details');

	Route::post('/store/notifications/action/', 'AjaxController@notifications_action');
	Route::post('/store/logs/action/', 'AjaxController@logs_action');

	Route::group(['middleware'=>'privilege'], function()
	{
		Route::get('/store/settings/layout', 'StorePrivilegedController@build_layout');
		Route::post('/store/settings/layout/save/{section}', 'StorePrivilegedController@save_layout');


		Route::get('/store/conversations/archive/{convoId}', 'StoreServiceController@get_archive_conversation');
		//Route::get('/store/conversations', 'StoreServiceController@goto_messages');
		//Route::get('/store/conversations/{userId}', 'StoreServiceController@get_user_conversations');
		Route::get('/store/conversations/{userId?}/{convoId?}', 'StoreServiceController@get_conversation_messages');
		Route::post('/store/conversations/start_convo', 'StoreServiceController@start_conversation');
		Route::post('/store/conversations/send_message', 'StoreServiceController@send_message');
		Route::post('/store/conversations/actions/delete', 'StoreServiceController@delete_message');

		Route::get('/store/messages', 'StoreController@direct_messages');
		Route::post('/store/messages/send_message', 'StoreController@send_direct_message');
		Route::post('/store/messages/seen_messages', 'StoreController@mark_messages_seen');

		Route::get('/store/settings', 'StorePrivilegedController@settings');
		
		Route::get('/store/employment', 'StorePrivilegedController@employment_menu');
		Route::get('/store/employment/proposal/{proposal_id}', 'StorePrivilegedController@view_proposal');
		Route::get('/store/employment/proposal/{user_id}/{proposal_id}/{store_id}/action/{action}', 'StorePrivilegedController@proposal_action');
		Route::get('/store/employment/employees', 'StorePrivilegedController@get_all_employees');
		Route::get('/store/employment/employees/edit/{id}', 'StorePrivilegedController@edit_service');

		Route::post('/store/employment/proposal/proposal_action_full', 'StorePrivilegedController@proposal_action_full');
		Route::post('/store/employment/employees/edit/save', 'StorePrivilegedController@save_service');
	});
	

	//AJAX REQUESTS
	Route::post('save_store', 'StoreController@save_store');
	Route::post('check_store_username', 'StoreController@check_store_username');
	Route::post('check_store_email', 'StoreController@check_store_email');
	Route::post('check_store_name', 'StoreController@check_store_name');
	Route::post('add_category', 'StoreController@add_category');
	Route::post('check_code', 'StoreController@check_code');

});

Route::get('/abc/test/', 'AjaxController@test');



//FlashCartController
Route::get('/', 'FlashCartController@index');
Route::get('/stores', 'FlashCartController@stores');
Route::get('/stores/search', 'FlashCartController@stores_by_search');
Route::get('/stores/category/{category}', 'FlashCartController@stores_by_category');
Route::get('/product/search', 'FlashCartController@find_product');
Route::get('/category/{category}/{sub_cat?}', 'FlashCartController@find_products_by_category');
//Route::get('/product/{identifier_category}', 'FlashCartController@find_product');
Route::get('/order/review', 'FlashCartController@review');
Route::get('/order/sign/{username}', 'FlashCartController@sign');
Route::post('/order/place', 'FlashCartController@place');

Route::get('/about-us', 'FlashCartController@about_us');
Route::get('/report', 'FlashCartController@report');
Route::post('/report/save', 'FlashCartController@save_report');
Route::get('/request-feature/', 'FlashCartController@request_feature');
Route::post('/request-feature/save', 'FlashCartController@save_feature');
Route::get('/our-partners', 'FlashCartController@partners');


//EmploymentController
Route::group(['middleware' => 'auth'], function()
{
	Route::get('/employ', 'EmploymentController@employment');
	Route::get('/employ/stores/category/{category}', '
		EmploymentController@get_employment_stores_by_category');
	Route::get('/employ/stores/search', 'EmploymentController@stores_by_search');
	Route::get('/employ/search', 'EmploymentController@get_employment_stores');
	Route::get('/employ/store/{id}/{slug}', 'EmploymentController@get_store');
	Route::get('/employ/store/{id}/{slug}/apply', 'EmploymentController@apply');

	Route::post('/employ/apply_form', 'EmploymentController@apply_form');
});





//IndexController
Route::get('/mystore/{username}', 'IndexController@get_store');
Route::get('/mystore/{username}/product/{product_id}/{slug?}', 'IndexController@get_product');
Route::get('/mystore/{username}/products', 'IndexController@get_products');
Route::get('/mystore/{username}/products/search', 'IndexController@get_products_by_search');
Route::get('/mystore/{username}/category/{category?}', 'IndexController@get_products_by_search');
Route::get('/mystore/{username}/category/{category}/sub_cat/{sub_cat}', 'IndexController@get_products_by_search');
Route::get('/mystore/{username}/sales/', 'IndexController@get_sales');
Route::get('/mystore/{username}/sale/{sale_id}/{slug?}', 'IndexController@get_sale');
Route::get('/mystore/{username}/policies', 'IndexController@get_policies');







//Independent
Route::get('/store/{store}/product/{product}/add_to_cart', 'IndependentController@add_to_cart');
Route::get('/product/{product}/remove_from_cart', 'IndependentController@remove_from_cart');
Route::post('/review/{type}/{id}', 'IndependentController@review_save');
Route::get('/check/check', 'IndexController@check');
Route::get('/error/{error}', 'IndependentController@error');