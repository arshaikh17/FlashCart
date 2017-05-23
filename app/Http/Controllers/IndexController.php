<?php

namespace App\Http\Controllers;

use App\Store;
use App\Store_detail;
use App\link_to_store;
use App\User;
use App\User_detail;
use App\Store_brandmark;
use App\Store_employment;
use App\Product_category;
use App\Store_product;
use App\Store_product_category;
use App\store_sale;
use App\Store_sale_product;
use App\Header;
use App\Store_layout;
use App\Store_social_media;
use App\Store_product_area;
use App\Store_header;
use App\Store_banner;
use App\Store_footer;
use App\Store_category_panel;
use App\Store_single_product;
use App\Review;
use App\Store_policy;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class IndexController extends Controller
{
    public function check()
    {
        return view('index_store.store.home');
    }

	public function store($username)
	{
		$store = Store::leftJoin('store_details','stores.store_id','store_details.store_id')
			->leftJoin('store_brandmarks','stores.store_id','store_brandmarks.store_id')
			->leftJoin('store_employments','stores.store_id','store_employments.store_id')
			->where('stores.store_username','=',$username)
			->first();

		return $store;
	}

	public function categories($store_id)
	{
		$categories = Store_product_category::select('store_product_categories.id','category')
			->join('product_categories','store_product_categories.category_id','product_categories.id')
			->where('store_id','=',$store_id)
			->get();

		return $categories;
	}

	public function sales($store_id)
	{
		$sales = Store_sale::where('store_id','=',$store_id)
			->where('status','=','1')
			->get();

		return $sales;
	}

    public function layout($store_id)
    {
        $layout = Store_layout::select('spa.store_id', 'product_area_id', 'layout_id', 'header_id', 'banner_id', 'footer_id', 'category_panel_id', 'sale_area_id', 'policy_area_id')
            ->leftJoin('store_product_areas as spa', 'store_layouts.store_id', 'store_layouts.store_id')
            ->leftJoin('store_headers as sh', 'store_layouts.store_id', 'sh.store_id')
            ->leftJoin('store_footers as sf', 'store_layouts.store_id', 'sf.store_id')
            ->leftJoin('store_banners as sb', 'store_layouts.store_id', 'sb.store_id')
            ->leftJoin('store_category_panels as scp', 'store_layouts.store_id', 'scp.store_id')
            ->leftJoin('store_sale_areas as ssa', 'store_layouts.store_id', 'ssa.store_id')
            ->leftJoin('store_single_products as ssp', 'store_layouts.store_id', 'ssp.store_id')
            ->leftJoin('store_policy_areas as spp', 'store_layouts.store_id','spp.store_id')
            ->where('spa.store_id','=',$store_id)
            ->first();

        return $layout;
    }

    public function social($store_id)
    {
        $social = DB::table('store_social_medias')->where('store_id','=',$store_id)
            ->first();

        return $social;
    }


    public function get_store($username)
    {
    	$store = $this->store($username);

    	$categories = $this->categories($store->store_id);

    	$sales = $this->sales($store->store_id);

    	$search = "";

        $layout = $this->layout($store->store_id);

        $social = $this->social($store->store_id);

        $products = Store_product::select('store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username', 'store_sales.status as sale_status','spsc.sub_category','sale_slug')
                ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
                ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
                ->leftJoin('store_product_categories','store_product_categories.id','store_products.category_id')
                ->leftJoin('product_categories','product_categories.id','store_product_categories.category_id')
                ->leftJoin('stores','stores.store_id','store_products.store_id')
                ->leftJoin('store_product_sub_categories as spsc','store_products.sub_category','spsc_id')
                ->where('stores.store_id','=',$store->store_id)
                ->where('display','=',1)
                ->get();

    	return view('index_store.store.home', compact('store', 'search', 'categories', 'sales', 'layout', 'social', 'products'));
    }

    public function get_policies($username)
    {
        $store = $this->store($username);

        $categories = $this->categories($store->store_id);

        $sales = $this->sales($store->store_id);

        $search = "";

        $layout = $this->layout($store->store_id);

        $social = $this->social($store->store_id);

        $policies = Store_policy::where('store_id','=',$store->store_id)
            ->paginate(1);

        //dd($layout);
        
        return view('index_store.store.policies', compact('store', 'search', 'categories', 'sales', 'layout', 'social', 'policies'));
    }
    /*public function get_products_by_category($username, $category)
    {
    	$store = $this->store($username);

    	$categories = $this->categories($username);

    	$sales = $this->sales($username);

    	$search = "";

    	if($category == "" || $category == "all")
    	{
    		$products_categorywise = Store_product::select('store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username')
           		->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
            	->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
            	->leftJoin('store_product_categories','store_product_categories.id','store_products.category_id')
            	->leftJoin('product_categories','product_categories.id','store_product_categories.category_id')
            	->leftJoin('stores','stores.store_id','store_products.store_id')
            	->where('stores.store_username','=',$username)
            	->paginate(10);
    	}
    	else
    	{
			$products_categorywise = Store_product::select('store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username')
           		->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
	            ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
	            ->leftJoin('store_product_categories','store_product_categories.id','store_products.category_id')
	            ->leftJoin('product_categories','product_categories.id','store_product_categories.category_id')
	            ->leftJoin('stores','stores.store_id','store_products.store_id')
    	        ->where('stores.store_username','=',$username)
        	    ->where('product_categories.category','=',$category)
            	->paginate(10);
    	}
    	
    	return view('index.index', compact('store', 'search', 'categories', 'sales', 'products_categorywise'));
    }*/

    public function get_products($username)
    {
    	return "After orders for ".$username;
    }

    public function get_products_by_search(Request $request, $username, $category = "", $sub_cat="")
    {
    	$store = $this->store($username);

        $categories = $this->categories($store->store_id);

        $sales = $this->sales($store->store_id);

        $search = "";

        $layout = $this->layout($store->store_id);

        $social = $this->social($store->store_id);

    	$search = trim($request->product);

        if(($category != "" && $category != "all") && $sub_cat != "")
        {
            $products = Store_product::select('store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username', 'store_sales.status as sale_status','spsc.sub_category')
                ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
                ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
                ->leftJoin('store_product_categories','store_product_categories.id','store_products.category_id')
                ->leftJoin('product_categories','product_categories.id','store_product_categories.category_id')
                ->leftJoin('stores','stores.store_id','store_products.store_id')
                ->leftJoin('store_product_sub_categories as spsc','store_products.sub_category','spsc_id')
                ->where('stores.store_username','=',$username)
                ->where('product_categories.category','=',$category)
                ->where('spsc.sub_category','=',$sub_cat)
                ->paginate(12);

            return view('index_store.store.home', compact('store', 'search', 'categories', 'sales', 'layout', 'social', 'products'));

            //return view('index.products.search', compact('store', 'search', 'categories', 'sales', 'products_sub_categorywise'));
        }

    	if($category == "all" || $category == "")
    	{

    		$products = Store_product::select('store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username', 'store_sales.status as sale_status')
	           	->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
   	        	->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
       	    	->leftJoin('store_product_categories','store_product_categories.id','store_products.category_id')
            	->leftJoin('product_categories','product_categories.id','store_product_categories.category_id')
   	        	->leftJoin('stores','stores.store_id','store_products.store_id')
       	    	->where('stores.store_username','=',$username)
           		->paginate(12);

            return view('index_store.store.home', compact('store', 'search', 'categories', 'sales', 'layout', 'social', 'products'));

            //return view('index.products.search', compact('store', 'search', 'categories', 'sales', 'products_categorywise'));
   		}
   		else
   		{
			$products = Store_product::select('store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username', 'store_sales.status as sale_status')
           		->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
	            ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
    	        ->leftJoin('store_product_categories','store_product_categories.id','store_products.category_id')
        	    ->leftJoin('product_categories','product_categories.id','store_product_categories.category_id')
            	->leftJoin('stores','stores.store_id','store_products.store_id')
    	        ->where('stores.store_username','=',$username)
   	    	    ->where('product_categories.category','=',$category)
       	    	->paginate(12);

            return view('index_store.store.home', compact('store', 'search', 'categories', 'sales', 'layout', 'social', 'products'));
            //return view('index.products.search', compact('store', 'search', 'categories', 'sales', 'products_categorywise'));
   		}
   		

    	if($search == "")
    	{
    		$products = Store_product::select('store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username', 'store_sales.status as sale_status')
	           ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
    	        ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
        	    ->leftJoin('stores','stores.store_id','store_products.store_id')
	            ->where('stores.store_username','=',$username)
    	        ->paginate(12);

            return view('index_store.store.home', compact('store', 'search', 'categories', 'sales', 'layout', 'social', 'products'));

            //return view('index.products.search', compact('store', 'search', 'categories', 'sales', 'products_searchwise'));
    	}
    	else
    	{
            View_product::addAllToIndex();
        // the items were already added to elasticsearch so no need to add it again
        //What if there are new products? And new products are added every day How do I add them in elastic?
        $products = View_product::where('stores.store_username','=',$username)
        ->search($request->product);
        $search = $request->product;
    
        $initial = explode(' ', $search);
        $next = [];
        foreach($initial as $in){
            $next[] = "<b>".ucfirst($in)."</b>";
        }
        //return $products;
        $temp_products = array();
        $count = 0;
        foreach($products as $product)
        {
            $temp_products[] = $product;
        }
        //dd($temp_products);
        /*$products = array_unique($temp_products);
    		$products = Store_product::select('store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username', 'store_sales.status as sale_status')
	           ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
    	        ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
        	    ->leftJoin('stores','stores.store_id','store_products.store_id')
	            ->where('stores.store_username','=',$username)
            	->whereRaw('MATCH(product_name, product_desc) AGAINST (? IN BOOLEAN MODE)', array($search))
    	        ->paginate(12);*/

            return view('index_store.store.home', compact('store', 'search', 'categories', 'sales', 'layout', 'social', 'products', $search));
            //return view('index.products.search', compact('store', 'search', 'categories', 'sales', 'products_searchwise'));
    	}
    }

    public function get_product($username, $product_id,$slug="")
    {
        $store = $this->store($username);

        $categories = $this->categories($store->store_id);

        $sales = $this->sales($store->store_id);

        $search = "";

        $layout = $this->layout($store->store_id);

        $social = $this->social($store->store_id);

    	$slug = trim($slug);

    	if($slug == "")
    	{
    		return redirect()->back();	
    	}

    	$product = Store_product::select('product_code','product_desc','store_products.slug as product_slug','product_quantity', 'store_products.id as product_id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username', 'sale_slug', 'product_views', 'store_sales.status as sale_status', 'pc.category')
        	->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
	        ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
	        ->leftJoin('store_product_categories','store_product_categories.id','store_products.category_id')
	        ->leftJoin('product_categories','product_categories.id','store_product_categories.category_id')
	        ->leftJoin('stores','stores.store_id','store_products.store_id')
            ->leftJoin('store_product_categories as spc','store_products.category_id','spc.id')
            ->leftJoin('product_categories as pc','spc.category_id','pc.id')
            ->where('store_products.id','=',$product_id)
           	->first();

        $rating = Review::where('review_type','=',1)
            ->where('review_to','=',$product_id)
            ->get();
        $rate_count = count($rating);
        $stars = 0;
        $star_count = 0;
        if($rate_count > 0)
        {
            foreach($rating as $rate)
            {
                $stars = $stars + $rate->rating;
            }
            $star_count = $stars/$rate_count;
        }

        /*Store_product::where('id','=',$product->product_id)
        	->update(['product_views'=>('product_views']);*/
        $view = Store_product::where("id",'=',$product->product_id)->first();
        $view->product_views = $view->product_views + 1;
        $view->save();

        $search = $product->product_name;

        return view('index_store.store.single', compact('store', 'search', 'categories', 'sales', 'product', 'layout', 'social', 'rating', 'star_count'));

    }

    public function get_sales($username)
    {
    	$store = $this->store($username);

    	$categories = $this->categories($username);

    	$sales = $this->sales($username);

    	$search = "";

    	return view('index.sales.sales', compact('store', 'categories', 'sales', 'search'));
    }

    public function get_sale($username, $sale_id, $slug)
    {
    	$store = $this->store($username);

    	$categories = $this->categories($username);

    	$sales = $this->sales($username);

    	$search = "";

    	$sale = Store_sale::select('sale_name', 'sale_tagline', 'sale_id', 'stores.store_id', 'sale_slug', 'end_date','discount', 'store_sales.status as sale_status')
    		->join('stores','stores.store_id','store_sales.store_id')
    		->where('store_username','=',$username)
    		->where('sale_id', '=', $sale_id)
    		->first();

    	return view('index.sales.single', compact('store', 'categories', 'sales', 'search', 'sale'));
    }













}