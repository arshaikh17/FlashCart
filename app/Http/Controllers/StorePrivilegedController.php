<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use Auth;
use App\User;
use App\Link_to_store;
use App\Store_detail;
use App\Store_style;
use App\Store_employment;
use App\Product_category;
use App\Store_product_category;
use App\Store_product;
use App\store_sale;
use App\store_sale_product;
use App\Store_policy;
use App\Category;
use App\Store_proposal;
use App\Store_employee;
use App\Store_log;
use App\Layout;
use App\Store_layout;
use App\Header;
use App\Store_header;

use Session;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class StorePrivilegedController extends Controller
{
	public function __construct()
	{
		$this->middleware('privilege');
	}

	public function store()
    {
        //$minutes = 30; // set here
        //return Cache::remember('users', $minutes, function () 
        //{
         return    $store = Store::join('link_to_stores', 'link_to_stores.store_id','=','stores.store_id')
                ->where('stores.store_id','=',session('store_id'))
                ->join('users','users.id','=','link_to_stores.user_id')
                ->where('users.id','=',session('user_id'))->first();
        //});
               
    }

    public function build_layout()
    {
        $store = $this->store();

        $layouts = Layout::all();
        $headers = Header::all();

        return view('store.layouts.build', compact('store', 'layouts', 'headers'));
    }

    public function save_layout(Request $request, $section)
    {
        $section = clearString($section);

        if($section == "layout")
        {
            Store_layout::where('store_id','=',session('store_id'))
                ->update(['layout_id'=>$request->layout]);
        }
        if($section == "header")
        {
            Store_header::where('store_id','=',session('store_id'))
                ->update(['header_id'=>$request->header]);
        }
        return redirect()->back();
    }

    public function employment_menu()
    {
        $store = $this->store();

        $employment = Store_employment::where('store_id','=',session::get('store_id'))
            ->first();

        $employment_list = Store_proposal::select('proposal_id', 'user_id','store_id','salary','message', 'name', 'email', 'picture', 'store_proposals.created_at')
            ->join('users','id','user_id')
            ->where('store_id','=',session::get('store_id'))
            ->where('status','=','3')
            ->get();

        return view('store.employment.employment', compact('store', 'employment', 'employment_list'));
    }

    public function proposal_action($user_id, $proposal_id, $store_id, $action)
    {
        if(session::get('store_id'))
        {
            $proposal_check = Store_proposal::where('user_id','=',$user_id)
                ->where('store_id','=',$store_id)
                ->where('proposal_id','=',$proposal_id)
                ->first();

            if($action == "accept")
            {
                $employment_check = Link_to_store::where('user_id','=',$user_id)
                    ->where('privilege', '=', 'Employee')
                    ->get();

                if($employment_check->count() >= 3)
                {
                    return redirect()->back()->withErrors(['check' => 'This employee is already employeed in 3 different stores.']);
                }
                else
                {
                    $employment_check_2 = Link_to_store::where('user_id','=',$user_id)
                        ->where('store_id', '=', $store_id)
                        ->where('privilege', '=', 'Employee')
                        ->first();

                    if($employment_check_2)
                    {
                        return redirect()->back()->withErrors(['check' => 'This employee is already employeed in your store.']);
                    }
                    else
                    {
                        Store_proposal::where('user_id','=',$user_id)
                            ->where('store_id','=',$store_id)
                            ->where('proposal_id','=',$proposal_id)
                            ->update(['status' => '1']);

                        $lts = new Link_to_store;
                        $lts->user_id = $user_id;
                        $lts->store_id = $store_id;
                        $lts->privilege = "Employee";
                        $lts->save();

                        $se = new Store_employee;
                        $se->emp_id = $user_id;
                        $se->store_id = session::get('store_id');
                        $se->save();

                        notify($user_id, $store_id, "store_user", 'accepted', "proposal_id", $proposal_id);

                        return redirect()->back()->with(['message'=>'Employee succefully hired']);
                    }
                }
                
            }
            else if($action == "decline")
            {
                Store_proposal::where('user_id','=',$user_id)
                    ->where('store_id','=',$store_id)
                    ->where('proposal_id','=',$proposal_id)
                    ->update(['status' => '0']);

                notify($user_id, $store_id, "store_user", 'declined', "proposal_id", $proposal_id);
            }
        }
    }

    public function view_proposal($proposal_id)
    {
        $store = $this->store();

        $proposal_check = Store_proposal::where('proposal_id', '=',$proposal_id)
            ->where('store_id','=',session::get('store_id'))
            ->first();
        if($proposal_check)
        {
            $user = Store_proposal::select('name', 'email', 'username', 'picture', 'user_details.*', 'store_proposals.*')
                ->leftJoin('users','id','store_proposals.user_id')
                ->leftJoin('user_details', 'store_proposals.user_id', 'user_details.user_id')
                ->where('proposal_id', '=',$proposal_id)
                ->first();

            $user_stores_owner = Link_to_store::join('stores','stores.store_id','link_to_stores.store_id')
                ->where('user_id', '=', $user->user_id)
                ->where('privilege', '=','Owner')
                ->get();

            $user_stores_employee = Link_to_store::join('stores','stores.store_id', 'link_to_stores.store_id')
                ->where('user_id', '=', $user->user_id)
                ->where('privilege', '=','Employee')
                ->get();

            return view('store.employment.proposal', compact('store', 'user', 'user_stores_owner', 'user_stores_employee'));
        }

        return redirect()->back();
    }

    public function proposal_action_full(Request $request)
    {
        $user_id = $request->user_id; 
        $proposal_id = $request->proposal_id;
        $store_id = $request->store_id;
        if(session::get('store_id'))
        {
            $proposal_check = Store_proposal::where('user_id','=',$user_id)
                ->where('store_id','=',$store_id)
                ->where('proposal_id','=',$proposal_id)
                ->first();

            $employment_check = Link_to_store::where('user_id','=',$user_id)
                ->where('privilege', '=', 'Employee')
                ->get();

            if($employment_check->count() >= 3)
            {
                return redirect()->back()->withErrors(['check' => 'This employee is already employeed in 3 different stores.']);
            }
             else
            {
                $employment_check_2 = Link_to_store::where('user_id','=',$user_id)
                    ->where('store_id', '=', $store_id)
                    ->where('privilege', '=', 'Employee')
                    ->first();

                if($employment_check_2)
                {
                    return redirect()->back()->withErrors(['check' => 'This employee is already employeed in your store.']);
                }
                else
                {
                    Store_proposal::where('user_id','=',$user_id)
                        ->where('store_id','=',$store_id)
                        ->where('proposal_id','=',$proposal_id)
                        ->update(['status' => '1']);

                    $lts = new Link_to_store;
                    $lts->user_id = $user_id;
                    $lts->store_id = $store_id;
                    $lts->privilege = "Employee";
                    $lts->save();

                    $se = new Store_employee;
                    $se->emp_id = $user_id;
                    $se->emp_salary = trim($request->emp_salary);
                    $se->emp_position = trim($request->emp_position);
                    $se->store_id = session::get('store_id');
                    $se->save();

                    notify($user_id, $store_id, "store_user", 'accepted', "proposal_id", $proposal_id);

                    return redirect()->to('/store/employment')->with(['message'=>'Employee succefully hired']);
                }
            }
        }
    }

    public function get_all_employees()
    {
        $store = $this->store();

        $employees = Store_employee::select('name', 'emp_id', 'emp_position','store_employees.created_at')
        	->join('users','users.id','store_employees.emp_id')
        	->where('store_employees.store_id','=',session::get('store_id'))
        	->get();

        return view('store.employment.employees', compact('store', 'employees'));
    }

    public function edit_service($id)
    {
    	$store = $this->store();

    	$employee_check = Store_employee::where('emp_id','=',$id)
    		->where('store_id','=',session::get('store_id'))
    		->first();

		if($employee_check)
		{
    		$employee = Store_employee::select('name', 'picture','store_employees.*')
    		->join('users','users.id','emp_id')
    		->first();

    		return view('store.employment.edit', compact('store', 'employee'));
		}	
    }

    public function save_service(Request $request)
    {
    	$id = $request->emp_id;

    	$employee_check = Store_employee::where('emp_id','=',$id)
    		->where('store_id','=',session::get('store_id'))
    		->first();

    	if($employee_check)
    	{
    		$sal = trim($request->emp_salary);
    		$pos = trim($request->emp_position);
    		Store_employee::where('emp_id','=',$id)
    		->where('store_id','=',session::get('store_id'))
    		->update(['emp_salary'=>$sal, 'emp_position'=>$pos]);

    		return redirect()->back()->with(['message'=>'Service edited succefully.']);
    	}

    	return redirect()->back()->withError(['check' => 'Something went wrong.']);
    }



//////////////////////////////STORE SETTINGS/////////////////////////////////////

    public function settings()
    {
        $store = $this->store();

        return view('store.settings.settings', compact('store','categories','details'));
    }

    public function get_logs()
    {
        $store = $this->store();

        $logs = Store_log::where('store_id', '=', session('store_id'))
            ->orderBy('sl_id','DESC')
            ->take(20)
            ->get();

        Store_log::where('store_id','=', session('store_id'))
            ->where('seen','=',0)
            ->update(['seen'=>1]);

        return view('store.logs.logs', compact('store', 'logs'));
    }









}
