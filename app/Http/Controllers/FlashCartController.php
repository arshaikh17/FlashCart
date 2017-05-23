<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Store_product;
use App\User;
use App\Link_to_store;
use App\Store_order;
use App\Store_order_product;
use App\Store_log;
use App\Product_category;
use App\Product_category_identifier;
use App\View_product;
use App\Category;
use App\View_store;
use App\Flashcart_report;
use App\Flashcart_request;
use App\Flashcart_partner;

use Auth;
use View;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Input;

class FlashCartController extends Controller
{
    public function index()
    {
    	$search = "";
    	return view('flashcart.index', compact('search'));
    }

    public function stores()
    {
        $search = "";
        //$store_categories = $this->store_categories();

        $stores = Store::leftJoin('categories as c','stores.store_category','cat_id')
            ->leftJoin('store_employments as se','stores.store_id','se.store_id')
            ->leftJoin('store_brandmarks as sb','stores.store_id','sb.store_id')
            ->paginate(12);

       
        $store_categories = Category::all();

        return view('flashcart.stores.stores', compact('search', 'store_categories', 'stores'));
    }

    public function stores_by_category($category)
    {
        $search = "";
        //$store_categories = $this->store_categories();
        $category = clearString($category);
        $stores = Store::leftJoin('categories as c','stores.store_category','cat_id')
            ->leftJoin('store_employments as se','stores.store_id','se.store_id')
            ->leftJoin('store_brandmarks as sb','stores.store_id','sb.store_id')
            ->where('category_of_store','LIKE',$category)
            ->paginate(12);

       
        $store_categories = Category::all();

        return view('flashcart.stores.stores', compact('search', 'store_categories', 'stores','category'));
    }

    public function stores_by_search(Request $request)
    {
        //View_store::addAllToIndex();

        $search = clearString($request->store);
        $store_categories = Category::all();
         $stores = Store::leftJoin('categories as c','stores.store_category','cat_id')
            ->leftJoin('store_employments as se','stores.store_id','se.store_id')
            ->leftJoin('store_brandmarks as sb','stores.store_id','sb.store_id')
            ->leftJoin('store_details as sd', 'sd.store_id', 'stores.store_id')
            ->whereRaw('MATCH(store_name, sd.description, category_of_store) AGAINST (? IN BOOLEAN MODE)', array($search))
            ->get();
        /*$stores = View_store::search($request->store);
        $temp_stores = array();
        $count = 0;
        foreach($stores as $store)
        {

            $temp_stores[] = $store;
            
        }
        //dd($temp_products);
        $stores = array_unique($temp_stores);*/
        return view('flashcart.stores.stores', compact('search', 'store_categories', 'stores'));
    }

    public function find_products_by_category($category, $sub_cat = "")
    {
        $categories = product_category_identifier::all();
        $sub_categories = Product_category::join('product_category_identifiers as pci', 'identifier_id', 'pci_id')
            ->where('identifier','LIKE',$category)
            ->get();

        $iCat = $category;
        $subCat = $sub_cat;
        $search = "";
        if($sub_cat != "")
        {
            $type = 2;
            $products = Store_product::join('store_product_categories as spc', 'store_products.category_id', 'spc.id')
                ->join('product_categories as pc', 'spc.category_id', 'pc.id')
                ->join('product_category_identifiers as pci', 'pc.identifier_id', 'pci_id')
                ->leftJoin('store_sale_products as ssp', 'product_id', 'spc.id')
                ->leftJoin('store_sales as ss', 'ss.sale_id', 'ssp.sale_id')
                ->where('pc.category','LIKE', $sub_cat)
                ->paginate(12);
        }
        else
        {
            $type = 1;
            $products = Store_product::join('store_product_categories as spc', 'store_products.category_id', 'spc.id')
                ->join('product_categories as pc', 'spc.category_id', 'pc.id')
                ->join('product_category_identifiers as pci', 'pc.identifier_id', 'pci_id')
                ->leftJoin('store_sale_products as ssp', 'product_id', 'spc.id')
                ->leftJoin('store_sales as ss', 'ss.sale_id', 'ssp.sale_id')
                ->where('pci.identifier','LIKE', $category)
                ->paginate(12);
        }

        return view('flashcart.search.cat_search', compact('products', 'categories', 'sub_categories', 'subCat','iCat', 'search', 'type'));
    }

    public function find_product(Request $request)
    {
        $categories = product_category_identifier::all();

        // to put the existing rproductins in elastic search;
        //View_product::deleteMapping();
        //View_product::addAllToIndex();
        // the items were already added to elasticsearch so no need to add it again
        //What if there are new products? And new products are added every day How do I add them in elastic?
        $search = clearString($request->product);
        /*if($search != "")
        {
            
        $products = View_product::search($search);
    
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

            /*if(count($temp_products) > 0)
            {
                //foreach($temp_products as $temp_product)
                //{
                    if($temp_products[$count]['product_id'] != $product['product_id'])
                    {
                        $temp_products[] = $product;
                    }
                //}
            }
            else
            {*/
                //$temp_products[] = $product;
            //}
            
        //}
        //dd($temp_products)
        //$products = array_unique($temp_products);
        if($search != "")
        {
        $type = 1;
        $products = Store_product::select('id as product_id','store_products.slug','store_products.id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username','product_quantity', 'store_sales.status as sale_status')
                ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
                ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
                ->leftJoin('stores','store_products.store_id','stores.store_id')
                ->whereRaw('MATCH(product_name, product_desc) AGAINST (? IN BOOLEAN MODE)', array($search))
                ->paginate(12);
        return view('flashcart.search.search', compact('products', 'search', 'initial','next', 'categories', 'type'));
        }
        else
        {
            $type = 2;
            $products =  $products = Store_product::select('id as product_id','store_products.slug','store_products.id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username','product_quantity', 'store_sales.status as sale_status')
                ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
                ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
                ->leftJoin('stores','store_products.store_id','stores.store_id')
                ->orderBy(DB::raw('RAND(50)'))
                ->paginate(12);
            return view('flashcart.search.search', compact('products', 'search', 'categories', 'type'));
        }
    	/*$search = trim($request->product);

        if($search != "" || $search != NULL)
        {

            $products = Store_product::select('id as product_id','store_products.slug','store_products.id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username','product_quantity', 'store_sales.status as sale_status')
                ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
                ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
                ->leftJoin('stores','store_products.store_id','stores.store_id')
                ->whereRaw('MATCH(product_name, product_desc) AGAINST (? IN BOOLEAN MODE)', array($search))
                ->paginate(12);
        }
        else
        {
            $products = Store_product::select('id as product_id','store_products.id', 'product_name', 'product_price', 'product_discount', 'product_views','product_image1','product_image2','product_image3','product_image4', 'store_name', 'store_products.store_id', 'store_sale_products.sale_id', 'sale_name', 'discount', 'store_username','product_quantity', 'store_sales.status as sale_status')
                ->leftJoin('store_sale_products','store_products.id','store_sale_products.product_id')
                ->leftJoin('store_sales', 'store_sale_products.sale_id','store_sales.sale_id')
                ->leftJoin('stores','store_products.store_id','stores.store_id')
                ->paginate(12);
        }

    	return view('flashcart.products',compact('products','search'));*/
    }

    public function review()
    {
        $search = "";
        $products = session('products');

        if($products != "")
        {
            foreach($products as $arr)
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

            //$stores = session('stores');

            /*$final_array = array();
            foreach($stores as $arr)
            {
                foreach($products as $arr2)
                {
                    if($arr == $arr2['store'])
                    {
                        $final_array[$arr]['product'][] = $arr2['product'];
                    }
                }
            }

            session()->put('order', $final_array);*/
            return view('flashcart.order.review');
        
        }
        else
        {
            return redirect()->back()->withErrors(['check'=>"Add products to your cart first."]);
        }
    }

    public function place(Request $request)
    {
        $order = array();
        $product_ids = array();
        $prices = array();
        $username = $request->s_value_u;
        $store_id = $request->s_value;

        $products = searchProductArrayByUsername(session('products'), $username);
        foreach($products as $product)
        {
            $details = getProductById($product['product']);
            $product_ids[] = $product['product'];
            
            $price = price_check($details->product_discount, $details->product_price, $details->sale_id, $details->discount, $details->sale_status);
            $prices[] = clearNumber($price);
        }
        $order['products'] = $product_ids;
        $order['prices'] = $prices;
        $order['quantities'] = $request->qty;
        $order['store'] = $store_id;
        $order['payment_id'] = $request->payment_method;
        if(Auth::user())
        {
            if($request->add_type == 1)
            {
                $order['address'] = $request->address_primary;
                $order['name'] = Auth::user()->name;
            }
            else if($request->add_type == 0)
            {
                $address = "House no. ".$request->address_secondary_hno.", Street ".$request->address_secondary_street." (".$request->address_secondary_street."/".$request->address_secondary_hno.")<br />".$request->address_secondary_area."<br />".$request->address_secondary_city.", ".$request->address_secondary_state." - ".$request->address_secondary_postal."<br />".$request->address_secondary_phone.", ".$request->address_secondary_mobile;
                $order['address'] = $address;
                $order['name'] = trim($request->order_name);
            }
            $order['user_id'] = Auth::user()->id;
        }
        else
        {
            $order['name'] = trim($request->order_name);
            $address = "House no. ".$request->address_guest_hno.", Street ". $request->address_guest_street." (".$request->address_guest_street."/".$request->address_guest_hno.")<br />".$request->address_guest_area."<br />".$request->address_guest_city.", ".$request->address_guest_state." - ".$request->address_guest_postal."<br />".$request->address_guest_phone.", ".$request->address_guest_mobile;
                $order['address'] = $address;

            $order['user_id'] = 0;
        }

        $invoice_count = Store_order::count();
        $invoice_id = session('user_type')."-".$invoice_count."-".rand(100,999)."-".rand(1000,9999)."-".date("Y");
        //$order = (object)$order;

        //dd($order);

        $store = Store::select('store_name','brand_logo', 'store_username')
            ->join('store_brandmarks','stores.store_id','store_brandmarks.store_id')
            ->where('stores.store_id','=',$store_id)
            ->first();

        $order['invoice_id'] = $invoice_id;

        session()->put($username, $order);

        //dd(session($username));
        
        return view('flashcart.order.place', compact('order', 'store', 'invoice_id', 'username'));

    }

    public function sign($username)
    {
        $username = trim($username);
        $signed = array();
        $signed = session($username);
        //$store = getStoreNameByUsername($signed['store']);
        $orderArray = array();

        $order = new Store_order;
        $orderArray['user_id'] = $signed['user_id'];
        $orderArray['order_name'] = $signed['name'];
        $orderArray['store_id'] = $signed['store'];
        $orderArray['payment_method'] = $signed['payment_id'];
        $orderArray['address_info'] = $signed['address'];
        $orderArray['invoice_id'] = $signed['invoice_id'];
        $orderArray['order_status'] = 2;
        $orderArray['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $invoice = $order->insertGetId($orderArray);

        $log_string = "New order '".$signed['invoice_id']."' by ".$signed['name'];
        $log = new Store_log;
        $log->store_id = $signed['store'];
        $log->log = $log_string;
        $log->log_type = 21;
        $log->log_by = $signed['user_id'];
        $log->log_linker = $signed['invoice_id'];
        $log->save();


        notifyStore($signed['user_id'],3,$signed['invoice_id']);

        $products = $signed["products"];
        $quantities = $signed['quantities'];
        $prices = $signed['prices'];

        for($i=0;$i<count($products); $i++)
        {
            $sop = new Store_order_product;
            $sop->order_id = $invoice;
            $sop->product_id = $products[$i];
            $sop->quantity = $quantities[$i];
            $sop->price = $prices[$i];
            $sop->save();
        }


        $stores = session('stores');
        $stores = array_values($stores);

        session()->put('stores', $stores);
        removeFromSingleArraySession('stores',$username);


        $m = session('products');
        $m = array_values(array_filter($m));

        for($i=0;$i<count($m);$i++)
        {
            if($m[$i]['store']==$username)
            {
                unset($m[$i]['store']);
                unset($m[$i]['product']);
            }
        }
        $m = array_values(array_filter($m));
        
        session()->put('products', $m);

        return redirect()->to('/order/review');
    }



    public function about_us()
    {
        return view('flashcart.html.about_us');
    }

    public function report()
    {
        return view('flashcart.service.report');
    }

    public function save_report(Request $request)
    {
        $name = clearString($request->name);
        $email = $request->email;
        $title = clearString($request->title);
        $description = clearString($request->description);
        $link = $request->link;

        $report = new Flashcart_report;
        $report->report_name = $name; 
        $report->report_email = $email;
        $report->report_title = $title;
        $report->report_description = $description;
        $report->report_link = $link;

        if($request->hasFile('support'))
        {
            $image = Input::file('support');

            $image_name = str_slug($title).'-'.time().'-'.$image->getClientOriginalName();

            $report->report_support = $image_name;

            $image->move(public_path().'/uploads/flashcart/reports/', $image_name);
        }

        $report->save();

        return redirect()->back();
    }

    public function request_feature()
    {
        return view('flashcart.service.request_feature');
    }

    public function save_feature(Request $request)
    {
        $name = clearString($request->name);
        $email = $request->email;
        $title = clearString($request->title);
        $description = clearString($request->description);
        $priority = clearString($request->priority);
        $link = $request->link;

        $requesting = new Flashcart_request;
        $requesting->request_title = $title;
        $requesting->request_email = $email;
        $requesting->request_description = $description;
        $requesting->request_priority = $priority;
        $requesting->request_link = $link;

        if($request->hasFile('support'))
        {
            $image = Input::file('support');

            $image_name = str_slug($title).'-'.time().'-'.$image->getClientOriginalName();

            $requesting->request_image = $image_name;

            $image->move(public_path().'/uploads/flashcart/requests/', $image_name);
        }

        $requesting->save();

        return redirect()->back();

    }

    public function partners()
    {
        $partners = Flashcart_partner::all();

        return view('flashcart.service.partners', compact('partners'));
    }























}
