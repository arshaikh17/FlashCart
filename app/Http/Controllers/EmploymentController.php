<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\User;
use App\Link_to_store;
use App\Store_detail;
use App\Store_brandmark;
use App\Store_employment;
use App\Store_employee;
use App\Category;
use App\Store_proposal;
use App\Store_order;
use App\View_store;

use Auth;
use Session;

class EmploymentController extends Controller
{
	public function store_categories()
	{
		$store_categories = Category::all();
		return $store_categories;
	}

	public function employment()
	{
		$search = "";
		//$store_categories = $this->store_categories();

    $stores = Store::leftJoin('categories as c','stores.store_category','cat_id')
      ->leftJoin('store_employments as se','stores.store_id','se.store_id')
      ->leftJoin('store_brandmarks as sb','stores.store_id','sb.store_id')
      ->where('se.status','=',1)
      ->get();
      //dd($stores);
		$store_categories = Category::all();

		return view('flashcart.employ.index', compact('search', 'store_categories', 'stores'));
	}

  public function stores_by_search(Request $request)
  {
        View_store::addAllToIndex();

        $search = clearString($request->store);
        $store_categories = Category::all();

        $stores = View_store::search($request->store);
        $temp_stores = array();
        $count = 0;
        foreach($stores as $store)
        {

            $temp_stores[] = $store;
            
        }
        //dd($temp_products);
        $stores = array_unique($temp_stores);
        return view('flashcart.employ.index', compact('search', 'store_categories', 'stores'));
    }

  public function get_employment_stores_by_category($category)
  {
    $search = "";
    //$store_categories = $this->store_categories();

    $stores = Store::join('categories as c','stores.store_category','cat_id')
      ->join('store_employments as se','stores.store_id','se.store_id')
      ->join('store_brandmarks as sb','stores.store_id','sb.store_id')
      ->where('category_of_store','=',$category)
      ->where('status','=',1)
      ->paginate(12);
    $store_categories = Category::all();

    return view('flashcart.employ.index', compact('search', 'store_categories', 'stores', 'category'));
  }

   	public function get_employment_stores(Request $request)
    {
    	$filter = $request->filter;
    	$search = $request->store;

        $user = Auth::user()->id;
        $employment_count = Link_to_store::where('user_id','=',$user)
            ->where('privilege','=','Employ')
            ->get();

		$store_categories = $this->store_categories();

        if($employment_count->count() == 3)
        {
            return "You are already employeed in three different stores. Cannot employ in any further";
        }
        else
        {
        	if($filter == "all")
    		  {
        		$employment_stores = Store::join('store_employments','stores.store_id','store_employments.store_id')
        			->join('store_brandmarks', 'stores.store_id','store_brandmarks.store_id')
            		->where('status','=','1')
	        		->paginate(10);
    		  }
        	if(isset($search))
        	{
				    if($filter == "name")
    			  {
    				  $employment_stores = Store::join('store_employments','stores.store_id','store_employments.store_id')
    					    ->join('store_brandmarks', 'stores.store_id','store_brandmarks.store_id')
            		  ->where('status','=','1')
            			->whereRaw("MATCH(store_name) AGAINST(? IN BOOLEAN MODE)", array($search))
	        			  ->paginate(10);
    			  }
    			   else if($filter == "email")
    			   {  
    				  $employment_stores = Store::join('store_employments','stores.store_id','store_employments.store_id')
    					   ->join('store_brandmarks', 'stores.store_id','store_brandmarks.store_id')
            			->where('status','=','1')
            			->where('store_email','=',$search)
	        			  ->paginate(10);
    			   }
    			   else if($filter == "username")
    			   {
    				    $employment_stores = Store::join('store_employments','stores.store_id','store_employments.store_id')
    					   ->join('store_brandmarks', 'stores.store_id','store_brandmarks.store_id')
            			->where('status','=','1')
            			->where('store_username','=',$search)
	        			->paginate(10);
    			   }
    			   else if(!isset($filter))
    			   {
    				    $employment_stores = Store::join('store_employments','stores.store_id','store_employments.store_id')
    					   ->join('store_brandmarks', 'stores.store_id','store_brandmarks.store_id')
            			->where('status','=','1')
	        			->paginate(10);
    			   }
        	}
        	else if(isset($request->category))
        	{
        		$category = trim($request->category);
        		$employment_stores = Store::join('categories','store_id','categories.cat_id')
        			->join('store_employments','stores.store_id','store_employments.store_id')
    				->join('store_brandmarks', 'stores.store_id','store_brandmarks.store_id')
            		->where('status','=','1')
            		->where('category_of_store','=',$category)
	        		->paginate(10);
        	}
          else if(!isset($request->category) && !isset($filter) &&  !isset($search))
          {
            $employment_stores = Store::join('store_employments','stores.store_id','store_employments.store_id')
              ->join('store_brandmarks', 'stores.store_id','store_brandmarks.store_id')
                ->where('status','=','1')
              ->paginate(10);
          }
        	
        }
        return view('flashcart.employ.employ', compact('employment_stores', 'category', 'store_categories', 'search'));
    }

    public function get_store($id, $slug)
   	{
   		$store_categories = $this->store_categories();

      $employees = Store_employee::join('stores as s', 's.store_id', 'store_employees.store_id')
        ->where('s.store_id','=',$id)
        ->get();

      $orders = Store_order::where('store_id','=',$id)
        ->where('order_status','=',1)
        ->get();

   		$store = Store::leftJoin('store_details','stores.store_id','store_details.store_id')
   			->leftJoin('store_brandmarks','stores.store_id','store_brandmarks.store_id')
   			->leftJoin('store_employments','stores.store_id','store_employments.store_id')
   			->leftJoin('categories','store_category','categories.cat_id')
   			->where('stores.store_id','=',$id)
   			->first(['stores.store_id','store_name','store_username','store_email','slug','category_of_store','tagline','store_details.description', 'min_wage','max_wage','brand_logo','brand_icon', 'label', 'store_employments.description AS emp_policy']);
   		
   		session(['employ_store' => $store->store_id]);

   		return view('flashcart.employ.store', compact('store','store_categories', 'employees', 'orders'));
   	}

   	public function apply()
   	{
   		if(session::get('employ_store') != NULL || session::get('employ_store') != "")
   		{
   			$store = Store::leftJoin('store_details','stores.store_id','store_details.store_id')
   			->leftJoin('store_brandmarks','stores.store_id','store_brandmarks.store_id')
   			->leftJoin('store_employments','stores.store_id','store_employments.store_id')
   			->leftJoin('categories','store_category','categories.cat_id')
   			->where('stores.store_id','=',session::get('employ_store'))
   			->first(['stores.store_id','store_name','store_username','store_email','slug','category_of_store','tagline','store_details.description', 'min_wage','max_wage','brand_logo','brand_icon', 'label', 'store_employments.description AS emp_policy']);

   			$store_check_ownership = Link_to_store::where('store_id','=',session::get('employ_store'))
   				->where('user_id','=',Auth::user()->id)
   				->first();
   				
   			$proposal_check = Store_proposal::where('user_id','=',Auth::user()->id)
   				->where('store_id','=',session::get('employ_store'))
   				->where('status','=','3')
   				->first();

        $employment_check = Store_employee::where('store_id','=',session::get('employ_store'))
          ->where('emp_id','=',Auth::user()->id)
          ->first();

   			$store_categories = $this->store_categories();

   			$user = User::select('name')
   			   	->where('id','=',Auth::user()->id)
   			   	->first();

   			if(isset($store_check_ownership->privilege) && $store_check_ownership->privilege == "Owner")
   			{
   				return view('flashcart.employ.apply', compact('store', 'store_categories','user','store_check_ownership'));
   			}

        if(count($employment_check))
        {
          return view('flashcart.employ.apply', compact('store', 'store_categories','user','employment_check'));
        }


   			

   			

   			if(isset($proposal_check))
   			{
   				return view('flashcart.employ.apply', compact('store', 'store_categories','user','proposal_check'));
   			}
   			
   			return view('flashcart.employ.apply', compact('store', 'store_categories','user'));
   		}
   		else
   		{
   			return redirect()->to('/employ/');
   		}

   	}

   	public function apply_form(Request $request)
   	{
   		$salary = trim($request->salary);

   		$employment = Store_employment::select('min_wage','max_wage')
   			->where('store_id','=',session::get('employ_store'))
   			->first();
   			
   			
   		 $min= trim($employment->min_wage);
   		$max = trim($employment->max_wage);

   		if(isset(Auth::user()->id))
   		{
   			if($salary >= $min && $salary <= $max)
   			{
   				$proposal = new Store_proposal;
   				$proposal->user_id = Auth::user()->id;
   				$proposal->store_id = session::get('employ_store');
   				$proposal->salary = $salary;
   				$proposal->message = $request->proposal;
   				$proposal->save();
   				
   				

   				$proposal_successful = 1;

   				return redirect()->back()->with(['proposal_successful' => 'you have successfully submitted your proposal. Please wait for their answer. Thank you!']);
   			}
   			else
   			{
   				return redirect()->back()->withErrors(['salary_error' => "You cannot propose your salary higher than store's policy"]);
   			}

   		}
   		else
   		{
   			return redirect()->to('/employ/');
   		}
   	}







}
