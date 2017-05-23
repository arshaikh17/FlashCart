<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\User;
use App\Link_to_store;
use App\Store_detail;
use App\Store_brandmark;
use App\Store_employment;
use App\Category;
use App\Store_proposal;
use App\Review;
use App\Store_product;

use Auth;
use Session;

class IndependentController extends Controller
{

	public function review_save($type, $id, Request $request)
	{

		if($type == "product")
		{
			$review = new Review;
			$review->review_type = 1;
			$review->review_name = clearString($request->review_name);
			$review->review = clearString($request->review_review);
			$review->rating = $request->rating;
			$review->review_title = clearString($request->review_title);
			$review->review_to = clearString($id);
				
			$review->save();
		}
		return redirect()->back();
	}

	public function add_to_cart($store, $product)
    {
    	if(Auth::user())
	    {
   			session()->put('user_type',Auth::user()->id);
   		}
    	else
   		{
   			session()->put('user_type', '0');
   		}


      $productArray = array();
      $productArray['store'] = $store;
      $productArray['product'] = $product;

      if(session('products') !="")
      {
        foreach(session('products') as $products)
        {
          if(in_array($product, $products))
          {
            return redirect()->back()->withErrors(['check' => "You already have added this product in your cart. You can specify quantity once you proceed to Order."]);
          }
        }

      }

      session()->push('products', $productArray);
      return redirect()->back()->with('message', 'Added to cart.');
    }

    public function remove_from_cart($product)
    {
      $a = session('products');
      $b = array();
      $b = removeElementWithValue($a, "product", $product);
      session()->put('products', $b);
      return redirect()->back()->with('message', 'Removed from cart.');
    }

    public function populate_orders()
    {
          $full_array = session('products');

    
      foreach($full_array as $arr)
      {
        if(session('stores') == NULL)
        {
          session()->push('stores', $arr['store']);
        }
        else if(!in_array($arr['store'], session('stores')))
        {
          session()->push('stores', $arr['store']);
        }
      }

      $stores = session('stores');

      for($i=0; $i<count($stores); $i++)
      {
        foreach($full_array as $arr)
        {
        //dd($stores[$i]);
        //dd($arr['store']);
          if($arr['store'] === $stores[$i])
          {
            if(session($stores[$i]) == NULL)
            {
              session()->push($stores[$i], $arr['product']);
            }
            else if(!in_array($arr['product'], session($stores[$i])))
            {
              session()->push($stores[$i], $arr['product']);
            }
          }
        }
      }
      dd(session('stores'));
      return session('ali_store');
    }

    

    public function place_order(Request $request)
    {
      return $request->qty;
    }

    public function error($error)
    {
      $error = clearString($error);

      if($error == 404)
      {
        return view('errors.404');
      }
    }

}