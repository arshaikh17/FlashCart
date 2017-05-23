<?php

function days_difference($target_date_time)
{
    $hit = strtotime($target_date_time);
    $now = strtotime(date("Y-m-d H:m:s"));

    $days_raw= $hit - $now;
    $days=$days_raw/60/60/24;

    return $days;
}

function image_check($path, $image, $exceptionPath)
{
	$no_image = "noimagefound.jpg";
    if(!empty($image) && file_exists($path.$image) )
    {
        return $path.$image;
    }
    return $exceptionPath.$no_image;
}

function price_check($discount, $price, $saleId, $saleDiscount, $saleStatus)
{
	$discount = trim($discount);
	$price = trim($price);
	$saleId = trim($saleId);
	$saleDiscount = trim($saleDiscount);

	if(($saleId != 0 || $saleId != NULL) && $saleStatus == "1")
	{
		$new_price = $price - (($price/100)*$saleDiscount);
	}
	else
	{
		if(isset($discount) && $discount != 0)
		{
			$new_price = $price - (($price/100)*$discount);
		}
		else
		{
			$new_price = $price;
		}
	}
	
	return number_format($new_price);
}

function return_sale($saleId, $saleName, $productDiscount, $storeUsername)
{
	$saleId = trim($saleId);
	$saleName = trim($saleName);

	if($saleId != NULL && $saleId != "" && $saleId != 0)
	{
		$url = "<a href='/".$storeUsername."/sales/".$saleId."''>".$saleName."</a>";
		return $url."<br />";
	}
	else 
	{
		if(isset($productDiscount) && $productDiscount != 0)
		{
			return "@".number_format($productDiscount).'% off'."<br />";
		}
	}
}

function logStore($storeId, $log, $logBy)
{
	$log = new App\Store_log;
	$log->store_id = $storeId;
	$log->log = $log;
	$log->log_by = $logBy;
	$log->save();
}

function getStoreLogs($storeId)
{
	$logs = App\Store_log::where('store_id','=',$storeId)
		->where('seen','=',0)
		->get();

	return $logs;
}

function notifyStore($storeId,$type, $link)
{
	$notify = new App\Store_notification;
	$notify->store_id = $storeId;
	$notify->link_value = $link;
	$notify->type = $type;
	$notify->save();
}

function getStoreNotifications($storeId)
{
	$notifications_seen = array();
	$notifications_unseen = array();

	$notifications = App\Store_notification::where('store_id','=',$storeId)
		->get();

	foreach($notifications as $notification)
	{
		if($notification->type == 3)
		{
			if($notification->seen == 0)
			{
				$notifications_unseen[] = "<a href='/store/orders/order/".$notification->link_value."'>You have an order.</a>";
			}
			if($notification->seen == 1)
			{
				$notifications_seen[] = "<a href='/store/orders/order/".$notification->link_value."'>You have an order.</a>";
			}
		}
	}
	$notifications_array = array();
	$notifications_array['seen'] = $notifications_seen;
	$notifications_array['unseen'] = $notifications_unseen;

	return $notifications_array;
}

function notify($to, $from, $specific, $type, $link_type, $link)
{
	$notify = new App\Notification;
	$notify->to_id = $to;
	$notify->from_id = $from;
	$notify->to_specific = $specific;
	$notify->notification_type = $type;
	$notify->link_type = $link_type;
	$notify->link = $link;
	$notify->save();
}

function getNotifications($specific, $id, $username)
{
	$notifications_seen = array();
	$notifications_unseen = array();

	$notifications = App\Notification::where('to_specific','=',$specific)
		->where('to_id','=',$id)
		->get();

	foreach($notifications as $notification)
	{
		//if($notification->to_specific == 2) //To check whether it is for User or Store
		//{

			if($notification->link_type == 3) //To check what type of notification is, is it for order or employment or etc
			{
				if($notification->seen == 0) //To check whether it is seen
				{
					$notifications_unseen[] = "<a href='/store/orders/order/".$notification->link."'>You have an order, 
You have an order, Check</a> - ".date_format($notification->created_at, 'l, F dS - Y'). " at ". date_format($notification->created_at, 'g:ia')." - ".$notification->created_at->diffForHumans();

				}
				else if($notification->seen == 1)
				{
					$notifications_seen[] = "<a href='/store/orders/order/".$notification->link."'>You have an order, 
You have an order, Check</a> - ".date_format($notification->created_at, 'l, F dS - Y'). " at ". date_format($notification->created_at, 'g:ia')." - ".$notification->created_at->diffForHumans();

				}
			}
		//}
	}
	$notifications_array = array();
	$notifications_array['seen'] = $notifications_seen;
	$notifications_array['unseen'] = $notifications_unseen;

	return $notifications_array;
}

function sale_product_count($sale_id)
{
	$store_sale = new App\Store_sale;
	$count = $store_sale->join('store_sale_products','store_sales.sale_id','store_sale_products.sale_id')
		->where('store_sales.sale_id','=',$sale_id)
		->count();

	return $count;
}

function get_review_stars($type, $id)
{
	if($type == "product")
	{
		$reviews = App\Review::where('review_type','=',2)
			->where("review_to",'=',$id)
			->avg('rating');

		return (int) $reviews;
		
	}
}

function get_sale_products($saleId)
{
	$products = App\Store_product::join('store_sale_products','store_sale_products.product_id','store_products.id')
		->where('sale_id','=',$saleId)
		->get();

	return $products;
}

function get_cart_products($productArray)
{
	$products = array();

	$Array = $productArray;

	foreach($Array as $product)
	{
		$product = App\Store_product::select('store_products.id','product_discount','product_price', 'product_name', 'product_image1', 'store_sale_products.sale_id', 'discount','status')
			->leftJoin('store_sale_products','store_products.id', 'product_id')
			->leftJoin('store_sales','store_sales.sale_id','store_sale_products.sale_id')
			->where('id','=',$product)
			->first();

		$products[] = $product;	
		
	}
	//dd($products);
	return $products;
}

function toInt($str)
{
    return (int)preg_replace("/([^0-9\\.])/i", "", $str);
}

function clearNumber($str)
{
	return preg_replace("/([^0-9\\.])/i", "", $str);
}

function clearString($string)
{
	return trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($string))))));
}

function removeElementWithValue($array, $key, $value)
{
     foreach($array as $subKey => $subArray)
     {
          if($subArray[$key] == $value){
               unset($array[$subKey]);
          }
     }
     return $array;
}

function searchProductArrayByUsername($products,$storeName)
{
    $results =array();
    foreach($products as $product)
    {
        if(in_array($storeName,array_values($product)))
           $results[] = $product;    
    }
    return $results;
}

function getStoreNameByUsername($username)
{
	$store = App\Store::select('store_id','store_name')
		->where('store_username','=', $username)
		->first();

	return $store;
}

function returnStore($store_id)
{
	$store = App\Store::select('store_id','store_name')
		->where('store_id','=', $store_id)
		->first();

	return $store;
}

function getProductById($id)
{
	$product = App\Store_product::select('id as product_id','store_products.slug','store_products.id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username','product_quantity', 'store_sales.status as sale_status')
        ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
        ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
        ->leftJoin('stores','store_products.store_id','stores.store_id')
        ->where('id','=',$id)
        ->first();

    return $product;

}

function getUserAddressById($id)
{
	$user = App\User_address::select('name','house_no','street','area','city','state','postal','phone','mobile','mobile_2')
		->join('users', 'id', 'user_addresses.user_id')
		->where('id','=',$id)
		->first();

	return $user;
}

function getPaymentMethodsByUsername($username)
{
	$payments = App\Payment_option::select('spo_id', 'spo.pay_id', 'payment_name', 'account_name')
		->join('store_payment_options as spo', 'payment_options.pay_id', 'spo.pay_id')
		->join('stores','stores.store_id', 'spo.store_id')
		->where('store_username','=',$username)
		->get();

	return $payments;
}

function getPaymentMethodsBySpoId($spo_id)
{
	$payment = App\Payment_option::select('spo_id', 'spo.pay_id', 'payment_name', 'account_name')
		->join('store_payment_options as spo', 'payment_options.pay_id', 'spo.pay_id')
		->where('spo_id','=',$spo_id)
		->first();

	return $payment;
}

function removeFromSingleArraySession($name, $value)
{
	$a = session($name);
	for($i=0; $i<count($a); $i++)
	{
		if($a[$i] == $value)
		{
			unset($a[$i]);
		}
	}
	$a = array_values(array_filter($a));

	return session()->put($name, $a);
	//return session()->put($name, array_diff(session()->get('stores'), [$value]));
}

function getSubCategories($id)
{
	$sub_category = App\Store_product_sub_category::join('store_product_categories', 'id', 'store_category_id')
		->where('store_category_id','=',$id)
		->get();

	return $sub_category;
}

function getOrderProducts($order)
{
	$products = App\Store_order_product::select('order_id','product_id','product_name','price','product_code','quantity')
		->join('store_products as sp','sp.id','store_order_products.product_id')
		->where('order_id','=',$order)
		->get();

	return $products;
}

function getMessage($user_type, $user_id, $message_after)
{
	$message = App\Store_user_message::where('user_type','=',$user_type)
		->where('message_to','=',$user_id)
		->get();

	return $message;
}
function getNextMessage($message_after)
{
	$message = App\Store_user_message::where('message_after','=',$message_after)
		->where('')
		->first();

	return $message;
}

function getUnseenMessages($storeId)
{
	$messages = App\Store_user_conversation::select('id','name','picture','suc_id','sucm_id','suc_title','sucm_message','suc_to','sucm.created_at','sucm_type')
		->join('store_user_conversation_messages as sucm','suc_id','conversation_id')
		->join('users','id','suc_to')
		->where('suc_from','=',$storeId)
		->where('sucm_type','=',1)
		->where('sucm.seen','=',0)
		->get();

	return $messages;
}

function getConversationMessages($convo_id, $store_id)
{
	$messages = App\Store_user_conversation_message::select('suc_id','sucm_id','sucm_type','suc_title','suc_to','suc_from','sucm_message','store_user_conversation_messages.seen','store_user_conversation_messages.created_at','store_user_conversation_messages.updated_at')
		->join('store_user_conversations as suc','suc_id','conversation_id')
		->where('conversation_id','=',$convo_id)
        ->where('suc_from','=',$store_id)
		->get();

	return $messages;
}

function setStatusSeen($convo_id)
{
	App\Store_user_conversation_message::where('conversation_id','=',$convo_id)
		->where('seen','=',0)
		->update(['seen'=>1]);
}

function returnUser($user_id)
{
	$user = App\User::select('id','name','picture')
		->where('id','=',$user_id)
		->first();

	return $user;
}

function getFirstLetters($string)
{
	$words = explode(" ", $string);
	$acronym = "";

	foreach ($words as $w) 
	{
 		$acronym .= $w[0];
	}

	return $acronym;
}

function diffForHumansShort($dateTime)
{
	$created_at = $dateTime->created_at->diffForHumans();
	$created_at = str_replace([' seconds', ' second'], ' sec', $created_at);
	$created_at = str_replace([' minutes', ' minute'], ' min', $created_at);
	$created_at = str_replace([' hours', ' hour'], ' h', $created_at);
	$created_at = str_replace([' months', ' month'], ' m', $created_at);
	if(preg_match('(years|year)', $created_at))
	{
		$created_at = $this->created_at->toFormattedDateString();
	}
	return $created_at;
}



































































//FlashCart Functions
function getIdentifiers()
{
	$identifier = App\Product_category_identifier::all();

	return $identifier;
}

function getCategories($identifier = "")
{
	if($identifier != "")
	{
		$categories = App\Product_category::where('identifier_id','=',$identifier)
			->get();
	}
	else if($identifier == "")
	{
		$categories = App\Product_category::all();
	}

	return $categories;
}

function getCategoryProducts($category)
{
	$products = App\Store_product::select('store_products.id as product_id', 'store_products.store_id', 'product_code', 'product_name', 'product_discount', 'product_price', 'store_products.category_id', 'product_image1','ss.sale_id','discount', 'product_quantity', 'sale_name', 'ss.status')
		->join('store_product_categories as spc', 'store_products.category_id', 'spc.id')
        ->join('product_categories as pc', 'spc.category_id', 'pc.id')
        ->join('product_category_identifiers as pci', 'pc.identifier_id', 'pci_id')
        ->leftJoin('store_sale_products as ssp', 'product_id', 'spc.id')
        ->leftJoin('store_sales as ss', 'ss.sale_id', 'ssp.sale_id')
        ->where('pci.identifier','LIKE', $category)
        ->groupBy('store_products.store_id')
        ->limit(10)
        ->get();

    return $products;
}