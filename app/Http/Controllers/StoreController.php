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
use App\Store_product_sub_category;
use App\Store_product;
use App\store_sale;
use App\store_sale_product;
use App\Store_policy;
use App\Category;
use App\Store_brandmark;
use App\Store_proposal;
use App\Store_employee;
use App\Payment_option;
use App\Store_payment_option;
use App\Store_layout;
use App\Store_header;
use App\Store_banner;
use App\Store_product_area;
use App\Store_category_panel;
use App\Store_order;
use App\Store_order_product;
use App\Store_log;
use App\Store_social_media;
use App\Store_user_message;
use App\Store_user_conversation;
use App\Store_user_conversation_message;
use App\Store_sale_area;
use App\Store_single_product;


use Session;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

session_regenerate_id();

class StoreController extends Controller
{
    public function redirect_store($store, $user)
    {
        if(Auth::user())
        {
            if(session('store_id') == "")
            {
                $store = Store::join('link_to_stores', 'link_to_stores.store_id','=','stores.store_id')
                    ->where('stores.store_id','=',$store)
                    ->join('users','users.id','=','link_to_stores.user_id')
                    ->where('users.id','=',$user)->first();

                if(count($store) == 1)
                {
                    session(['store_name' => $store->store_name]);
                    session(['store_id' => $store->store_id]);
                    session(['user_id' => $store->id]);
                    session(['privilege' => $store->privilege]);

                    $category_check = Store::select('store_category')
                        ->where('store_id','=',session::get('store_id'))
                        ->first();


                    if(!isset($category_check->store_category) || $category_check->store_category == 0)
                    {
                        return redirect()->to('/store')->withErrors(['category_check' => "You haven't set up category of this store. Your store will not be listed if it is not set. Please go to <a href='/store/settings/store_category'>SETTINGS</a> to set up."]);                    
                    }
                    else
                    {
                        return redirect()->to('/store');
                    }
                }
                else
                {
                    return redirect()->to("/user/home");
                }
            }
            else
            {
                return redirect()->to("/store");
            }
        }
        else
        {
            return redirect()->to('/user/login');
        }
    }

    public function store()
    {

        //$minutes = 30; // set here
        //return Cache::remember('users', $minutes, function () 
        //{
         return $store = Store::join('link_to_stores', 'link_to_stores.store_id','=','stores.store_id')
                ->where('stores.store_id','=',session('store_id'))
                ->join('users','users.id','=','link_to_stores.user_id')
                ->where('users.id','=',session('user_id'))->first();
        //});
               
    }

    public function index()
    {
        $store = $this->store();

        $new_orders = Store_order::where('store_id','=',session('store_id'))
            ->whereNull('updated_at')
            ->get();

        $logs = Store_log::where('store_id','=',session('store_id'))
            ->where('seen','=',0)
            ->get();

        $users_of_store = Link_to_store::where('store_id','=',session('store_id'))
            ->get();

        $users = array();
        foreach($users_of_store as $user)
        {
            $user_info = User::select('id','name','picture')
                ->where('id','=',$user->user_id)
                ->first();

            if($user_info->id != Auth::user()->id)
            {
                $user_array = array();

                $user_array['user_id'] = $user->user_id;
                $user_array['user_name'] = $user_info->name;
                $user_array['user_picture'] = $user_info->picture;
                $users[] = $user_array;
            }
        }

        /*$new_messages = Store_user_message::where('user_type','=',1)
            ->where('message_type','=',1)
            ->where('seen','=',0)
            ->where('message_to','=',session('store_id'))
            ->count();*/

        $unseen_conversations_messages = getUnseenMessages(session('store_id'));
        $unseen_conversations = array();
        $unseen_messages = array();
        foreach($unseen_conversations_messages as $ucm)
        {
            if(!in_array($ucm->suc_id, $unseen_conversations))
            {
                $unseen_conversations[] = $ucm->suc_id;
            }
            if($ucm->sucm_type == 1)
            {
                $unseen_messages[] = $ucm->sucm_message;
            }
        }
        return view('store.index', compact('store', 'new_orders', 'logs', 'users','unseen_conversations','unseen_messages'));
    }

    public function add_product()
    {
        $store = $this->store();

        $categories = Store_product_category::join('product_categories','store_product_categories.category_id','=','product_categories.id')
            ->where('store_product_categories.store_id','=',session('store_id'))
            ->get(["store_product_categories.id","product_categories.category"]);

        //dd($categories);

        return view('store.products.add', compact('store','categories'));
    }

    public function add_sale()
    {
        $store = $this->store();
    
        return view('store.sales.add', compact('store'));
    }

    public function setting_details()
    {
        $store = $this->store();

        $details = Store_detail::where('store_id','=',session::get('store_id'))
            ->first();

        return view('store.settings.details', compact('details','store'));
    }

    public function setting_categories()
    {
        $store = $this->store();

        $categories = Store_product_category::select('product_categories.id', 'category', 'store_product_categories.id as spc_id')
            ->join('product_categories','store_product_categories.category_id','=','product_categories.id')
            ->where('store_product_categories.store_id','=',session('store_id'))
            ->get();

        $exclusive_categories = Product_category::leftJoin('store_product_categories', function ($join) 
        {
            $join->on('store_product_categories.category_id', '=', 'product_categories.id');
            $join->on('store_product_categories.store_id', '=', \DB::raw(session('store_id')));
        })
        ->whereNull('store_product_categories.category_id')
        ->get(["product_categories.id","product_categories.category"]);

        return view('store.settings.categories', compact('categories','exclusive_categories','store'));
 
    }

    public function add_category(Request $request)
    {
        $category_existence = Store_product_category::where('store_id','=',session::get('store_id'))
            ->where('category_id','=',$request->new_category)
            ->first();

        if(!$category_existence)
        {
            $spc  = new Store_product_category;
            $spc->store_id = session::get('store_id');
            $spc->category_id = $request->new_category;
            $spc->save();

            return redirect()->back()->with('message',"Category saved");
        }
        else
        {
            return redirect()->back()->withErrors(['check'=>"Category already there"]);
        }
    }

    public function check_code(Request $request)
    {
        $request_code = trim($request->code);
        if(isset($request_code))
        {

            $code = Store_product::where('product_code','=',$request_code)
            ->first();
        
            if($code)
            {
                return['error'=>'yes'];
            }
            else
            {
                return ['error'=>'no'];
            }
        }
        else
        {
            return ['error'=>'Please enter code'];
        }
    }

    public function add_sub_categories(Request $request)
    {
        $sub_category = clearString($request->sub_category);
        $check_sub = Store_product_sub_category::where('sub_category','=',$sub_category)
            ->where('store_category_id','=',$request->sub_category_for)
            ->count();

        if($check_sub > 0)
        {
            return redirect()->back()->withErrors(['check'=>$sub_category." is already present under the category you have selected."]);
        }
        else
        {
            $sub_cat = new Store_product_sub_category;
            $sub_cat->store_id = session('store_id');
            $sub_cat->store_category_id = $request->sub_category_for;
            $sub_cat->sub_category = $sub_category;
            $sub_cat->save();

            return redirect()->back()->with('message','Sub category '.$sub_category.' is successfully added.');
        }
    }

    public function setting_brand()
    {
        $store = $this->store();

        $brand = Store_brandmark::where('store_id','=',session('store_id'))
            ->first();

        return view('store.settings.brand',compact('store','brand'));
    }

    public function setting_policies()
    {
        $store = $this->store();

        $policies = Store_policy::where('store_id','=',session::get('store_id'))
            ->get();

        return view('store.settings.policies', compact('store', 'policies'));
    }

    public function setting_policy($policy)
    {
        $store = $this->store();

        $policy = Store_policy::where('policy_id','=',$policy)
            ->where('store_id','=',session::get('store_id'))
            ->first();

        $policies = Store_policy::where('store_id','=',session::get('store_id'))
            ->get();

        return view('store.settings.policy',compact('store','policy','policies'));
    }

    public function edit_policy(Request $request)
    {
        $new_title = trim($request->title);
        $policy = Store_policy::where('policy_title','LIKE',$new_title)
            ->first();
            
        if(isset($policy))
        {
            return redirect()->back()->withErrors(['Policy with this title already exists in your store.']);
        }
        else
        {
            Store_policy::where('policy_id','=',$request->policy)
                ->where('store_id','=',session::get('store_id'))
                ->update(['policy_title' => $new_title, 'policy_content' => $request->policy_content]);
            return redirect()->back()->withErrors(['Saved Successfully']);
        }
    }

    public function setting_employment()
    {
        $store = $this->store();

        $employment = Store_employment::where('store_id','=',session::get('store_id'))
            ->first();
        //return $employment;
        return view('store.settings.employment',compact('store','employment'));
    }

    public function update_employment(Request $request)
    {

        if($request->emp_val == 0)
        {
            Store_employment::where('store_id','=',session::get('store_id'))
                ->update(['status' => '1']);

            return redirect()->back()->withErrors(['check'=>'Employment Opened']);
        }
        if($request->emp_val == 1)
        {
            Store_employment::where('store_id','=',session::get('store_id'))
                ->update(['status' => '0']);
        
            return redirect()->back()->withErrors(['check'=>'Employment Closed']);
        }
    }

    public function setting_employment_wages(Request $request)
    {
        $min = (int)$request->min_wage;
        $max = (int)$request->max_wage;
        Store_employment::where('store_id','=',session::get('store_id'))
            ->update(['min_wage'=>$min, 'max_wage'=>$max]);

        return redirect()->back()->with('message','Settings saved');
    }

    public function setting_store_category()
    {
        $store = $this->store();
        $category = "";
        $category = Store::select('store_category', 'category_of_store')
            ->join('categories','store_category','categories.cat_id')
            ->where('store_id','=',session::get('store_id'))
            ->first();
        $all_category = Category::all();

        return view('store.settings.store_category', compact('store','category', 'all_category'));
    }

    public function save_store_category(Request $request)
    {
        Store::where('store_id','=',session::get('store_id'))
            ->update(['store_category'=>$request->store_category]);

        return redirect()->back()->with('message', 'You have successfully set up category of your store');
    }

    public function payment_options()
    {
        $store = $this->store();

        $left_payment_options = Payment_option::all();

        $store_payment_options = Store_payment_option::join('payment_options','payment_options.pay_id','store_payment_options.pay_id')
            ->where("store_id",'=',session::get('store_id'))
            ->orderBy('payment_name')
            ->get();

        /*$left_payment_options = Payment_option::select('payment_options.pay_id', 'payment_name')
            ->leftJoin('store_payment_options', 'payment_options.pay_id','store_payment_options.pay_id')
            ->whereNull('store_id')
            ->get();
        */
        return view('store.settings.payment', compact('store', 'payment_options', 'store_payment_options', 'left_payment_options'));
    }

    public function save_payment_method(Request $request)
    {
        if($request->payment_type == 1)
        {
            $acc_name = trim($request->ep_account_name);
            $acc_number = trim($request->ep_account_number);

            if($acc_name == "" || $acc_number == "")
            {
                return redirect()->back()->withErrors(['check' => "Please fill all the fields of Easy Paisa form"]);
            }
            else
            {
                $check_ep = Store_payment_option::where('account_number','=',$acc_number)
                    ->where('pay_id', $request->payment_type)
                    ->where('store_id','=',session::get('store_id'))
                    ->count();

                if($check_ep == 1)
                {
                    return redirect()->back()->withErrors(['check' => "Easy Paisa already in your database."]);
                }
                else
                {
                    $pay = new Store_payment_option;
                    $pay->account_name = $acc_name;
                    $pay->account_number = $acc_number;
                    $pay->pay_id = $request->payment_type;
                    $pay->store_id = session::get('store_id');
                    $pay->save();
                    return redirect()->back()->with(['message' => "Easy Paisa set up successfully."]);
                }
            }
        }
        else if($request->payment_type == 2)
        {
            $acc_name = trim($request->ba_account_name);
            $acc_number = trim($request->ba_account_number);
            $bank = trim($request->ba_bank_name);
            $branch = trim($request->ba_bank_branch);

            if($acc_name == "" || $acc_number == "" || $bank == "" || $branch == "")
            {
                return redirect()->back()->withErrors(['check' => "Please fill all the fields of Bank Account form"]);
            }
            else
            {
                $check_ba = Store_payment_option::where('account_number','=',$acc_number)
                    ->where('pay_id', $request->payment_type)
                    ->where('bank_name', '=', $request->ba_bank_name)
                    ->where('store_id','=',session::get('store_id'))
                    ->count();

                if($check_ba == 1)
                {
                    return redirect()->back()->withErrors(['check' => "Bank Account already in your database."]);
                }
                else
                {
                    $pay = new Store_payment_option;
                    $pay->account_name = $acc_name;
                    $pay->account_number = $acc_number;
                    $pay->pay_id = $request->payment_type;
                    $pay->bank_name = $request->ba_bank_name;
                    $pay->bank_branch = $request->ba_bank_branch;
                    $pay->store_id = session::get('store_id');
                    $pay->save();
                    return redirect()->back()->with(['message' => "Bank Account set up successfully."]);
                }
            }
        }
        else if($request->payment_type == 3)
        {
            $acc_name = trim($request->ublo_account_name);
            $acc_number = trim($request->ublo_account_number);

            if($acc_name == "" || $acc_number == "")
            {
                return redirect()->back()->withErrors(['check' => "Please fill all the fields of UBL Omni form"]);
            }
            $check_ublo = Store_payment_option::where('account_number','=',$acc_number)
                ->where('pay_id', $request->payment_type)
                ->where('store_id','=',session::get('store_id'))
                ->count();

            if($check_ublo == 1)
            {
                return redirect()->back()->withErrors(['check' => "UBL Omni already in your database."]);
            }
            else
            {
                $pay = new Store_payment_option;
                $pay->account_name = $acc_name;
                $pay->account_number = $acc_number;
                $pay->pay_id = $request->payment_type;
                $pay->store_id = session::get('store_id');
                $pay->save();
                return redirect()->back()->with(['message' => "UBL Omni set up successfully."]);
            }
        }
        else if($request->payment_type == 4)
        {
            $check_cod = Store_payment_option::where('pay_id', $request->payment_type)
                ->where('store_id','=',session::get('store_id'))
                ->count();

            if($check_cod == 1)
            {
                return redirect()->back()->withErrors(['check' => "You already have Cash On Deliver method available."]);
            }
            else
            {
                $pay = new Store_payment_option;
                $pay->pay_id = $request->payment_type;
                $pay->store_id = session::get('store_id');
                $pay->save();
                return redirect()->back()->with(['message' => "Cash On Deliver method set up successfully."]);
            }
        }
    }

    public function save_payment_details(Request $request, $id, $pay_id)
    {
        $check_option = Store_payment_option::where('spo_id','=',$id)
            ->where('pay_id','=',$pay_id)
            ->where('store_id','=',session::get('store_id'))
            ->count();

        if($check_option == 1)
        {
            if($pay_id == 1 || $pay_id == 3)
            {
                $acc_name = trim($request->edit_account_name);
                $acc_number = trim($request->edit_account_number);

                Store_payment_option::where('spo_id','=',$id)
                    ->where('pay_id','=',$pay_id)
                    ->where('store_id','=',session::get('store_id'))
                    ->update(['account_name'=>$acc_name, 'account_number'=>$acc_number]);

                return redirect()->back()->with(['message'=>"Information edited successfully."]);
            }
            else if($pay_id == 2)
            {
                $acc_name = trim($request->edit_account_name);
                $acc_number = trim($request->edit_account_number);
                $bank_name = trim($request->edit_bank_name);
                $bank_branch = trim($request->edit_bank_branch);

                Store_payment_option::where('spo_id','=',$id)
                    ->where('pay_id','=',$pay_id)
                    ->where('store_id','=',session::get('store_id'))
                    ->update(['account_name'=>$acc_name, 'account_number'=>$acc_number, 'bank_name'=>$bank_name, 'bank_branch'=>$bank_branch]);

                return redirect()->back()->with(['message'=>"Information edited successfully."]);
            }
            return redirect()->back()->withErrors(['check'=>"Ops! Something went wrong!"]);
        }

        return redirect()->back()->withErrors(['check'=>"Ops! Something went wrong!"]);
    }

    public function social_media()
    {
        $store = $this->store();

        $social = Store_social_media::where('store_id','=',session('store_id'))
            ->first();

        return view('store.settings.social_media', compact('store', 'social'));
    }

    public function save_social_media(Request $request)
    {
        $facebook = trim($request->social_facebook);
        $google = trim($request->social_google);
        $twitter = trim($request->social_twitter);

        Store_social_media::where('store_id','=',session('store_id'))
            ->update(['facebook'=>$facebook, 'google_plus'=>$google, 'twitter'=>$twitter]);

        return redirect()->back()->with('message', 'Settings saved SUCCESSFULLY!');
    }







    public function save_details(Request $request)
    {
        Store_detail::where('store_id','=',session::get('store_id'))
            ->update(['tagline'=>$request->tagline, 'description'=>$request->description, 'welcome_note'=>$request->welcome_note]);

        return redirect()->back();
    }

    public function save_brand_mark(Request $request)
    {

        if($request->hasFile('brand_mark_logo'))
        {
            $logo_file = Input::file('brand_mark_logo');

            $logo = session::get('store_id')."-".Auth::user()->id."-".$logo_file->getClientOriginalName();

            $logo_file->move(public_path().'/uploads/store/brand_marks/logo/',$logo);

            Store_brandmark::where('store_id','=',session::get('store_id'))
                ->update(['brand_logo'=>$logo]);
        }

        if($request->hasFile('brand_mark_icon'))
        {
            $icon_file = Input::file('brand_mark_icon');

            $icon = session::get('store_id').'-'.Auth::user()->id.'-'.$icon_file->getClientOriginalName();

            $icon_file->move(public_path().'/uploads/store/brand_marks/icon/',$icon);

            Store_brandmark::where('store_id','=',session::get('store_id'))
                ->update(['brand_icon' => $icon]);
        }
        //return session::get('store_id')."-".Auth::user()->id."-".$logo_file->getClientOriginalName();
       return redirect()->back();
    }

    public function add_policy(Request $request)
    {
        $policy = new Store_policy;
        $policy->store_id = session::get('store_id');
        $policy->policy_title = $request->title;
        $policy->policy_content = $request->policy_content;
        $slug = str_slug($request->title);
        $policy->policy_slug = $slug;
        $policy->save();

        return redirect()->back();
    }



    public function view_all_orders()
    {
        $store = $this->store();

        $orders = Store_order::where('store_id','=',session('store_id'))
            ->get();
        //dd($orders);

        return view('store.orders.orders', compact('store','orders'));
    }

    public function get_order($orderId)
    {
        $store = $this->store();

        $orderId = trim($orderId);

        $order = Store_order::where('store_id','=',session('store_id'))
            ->where('invoice_id','=',$orderId)
            ->first();

        if($order != "")
        {
            $payment = Store_payment_option::join('payment_options as po','po.pay_id','store_payment_options.pay_id')
            ->where('spo_id','=',$order->payment_method)
            ->first();
        }
        else
        {
            $payment = "";
        }
        /*$order_products = Store_order_product::where('order_id','=',$order->so_id)
            ->get();*/

        

        return view('store.orders.order', compact('store','order','order_products','payment'));
    }

    public function find_order(Request $request)
    {
        $store = $this->store();

        $orderId = trim($request->order_q);

        $order = Store_order::where('store_id','=',session('store_id'))
            ->where('invoice_id','=',$orderId)
            ->first();

        if($order != "")
        {
            $payment = Store_payment_option::join('payment_options as po','po.pay_id','store_payment_options.pay_id')
                ->where('spo_id','=',$order->payment_method)
                ->first();

            $url = '/store/orders/order/'.$order->invoice_id;

            return redirect()->to($url)->with(compact('store','order','order_products','payment'));
            //return view('store.orders.order', compact('store','order','order_products','payment'));
        }
        $payment = "";
        $url = '/store/orders/order/'.$request->order_q;
        return redirect()->to($url)->with(compact('store','order','order_products','payment'));
        //return view('store.orders.order', compact('store','order','order_products','payment'));
    }

    public function order_action($orderId, $action)
    {
        $order_check = Store_order::where('so_id','=',$orderId)
            ->where('store_id','=',session('store_id'))
            ->first();

        if(count($order_check) == 1)
        {
            if($action == 1)
            {
                Store_order::where('so_id','=',$orderId)
                    ->update(['order_status'=>1]);

                $log_string = "Order '".$order_check->invoice_id."' status updated to 'ACCEPTED'";
                $log = new Store_log;
                $log->store_id = session('store_id');
                $log->log = $log_string;
                $log->log_type = 21;
                $log->log_by = Auth::user()->id;
                $log->log_linker = $order_check->invoice_id;
                $log->save();

                return redirect()->back()->with('message','Order successfully marked as ACCEPTED');
            }
            else if($action == 0)
            {
                Store_order::where('so_id','=',$orderId)
                    ->update(['order_status'=>0]);

                $log_string = "Order '".$order_check->invoice_id."' status updated to 'DECLINED'";
                $log = new Store_log;
                $log->store_id = session('store_id');
                $log->log = $log_string;
                $log->log_type = 22;
                $log->log_by = Auth::user()->id;
                $log->log_linker = $order_check->invoice_id;
                $log->save();

                return redirect()->back()->withErrors(['check'=>'Order successfully marked as REJECTED']);
            }
        }
        else
        {
            return redirect()->back()->withErrors(['check'=>'Oops! Something went wrong']);
        }
    }






    public function list_product()
    {
        $store = $this->store();

        $categories = Store_product_category::join('product_categories','store_product_categories.category_id','=','product_categories.id')
            ->where('store_product_categories.store_id','=',session('store_id'))
            ->get(['product_categories.category','store_product_categories.id']);

        $list = Store_product::where('store_id','=',session::get('store_id'))
            ->orderBy('product_code')
            ->paginate(10);

        $key = 0;
        $key_category = "";

        $key_sub_category = "";

        return view('store.products.list', compact('store','categories','list','key','key_category', 'key_sub_category'));
    }

    public function list_product_by_categories($category)
    {
        $store = $this->store();

        $categories = Store_product_category::join('product_categories','store_product_categories.category_id','=','product_categories.id')
            ->where('store_product_categories.store_id','=',session('store_id'))
            ->get(['product_categories.category','store_product_categories.id']);

        $list = Store_product::where('store_id','=',session::get('store_id'))
            ->where('store_products.category_id','=',$category)
            ->orderBy('product_code')
            ->paginate(10);

        $key = 1;

        $key_category = Store_product_category::join('product_categories as pc','store_product_categories.category_id','pc.id')
            ->where('store_product_categories.id','=',$category)
            ->first();

        $key_sub_category = "";

        return view('store.products.list', compact('store','categories','list','key','key_category', 'key_sub_category'));
    }
    
    public function list_product_by_sub_categories($category, $sub_cat)
    {
        $store = $this->store();

        $categories = Store_product_category::join('product_categories','store_product_categories.category_id','=','product_categories.id')
            ->where('store_product_categories.store_id','=',session('store_id'))
            ->get(['product_categories.category','store_product_categories.id']);

        $list = Store_product::join('store_product_sub_categories as spsc', 'store_products.sub_category', 'spsc_id')
            ->where('category_id', '=', $category)
            ->where('store_products.store_id','=',session::get('store_id'))
            ->where('spsc_id','=',$sub_cat)
            ->orderBy('product_code')
            ->paginate(10);

        $key = 2;

        $key_category = Store_product_category::join('product_categories as pc','store_product_categories.category_id','pc.id')
            ->where('store_product_categories.id','=',$category)
            ->first();

        $key_sub_category = Store_product_sub_category::where('store_category_id','=',$category)
            ->first();

        return view('store.products.list', compact('store','categories','list','key','key_category', 'key_sub_category'));
    }


    public function add_p(Request $request)
    {
        $product = new Store_product;   
        $product->store_id = session::get('store_id');
        $product->product_code = clearString($request->product_code);
        $product->product_name = clearString($request->product_name);
        $product->product_desc = clearString($request->product_desc);
        $product->product_price = clearString($request->product_price);
        $product->product_discount = clearString($request->product_discount);
        $product->product_quantity = clearString($request->product_quantity);
        $product->category_id = ($request->product_category);
        $product->slug = str_slug(trim($request->product_name));
        $product->sub_category = clearString($request->product_sub_category);
        
        $timestamp = time();
        if($request->hasFile('product_image1'))
        {
            $image1 = Input::file('product_image1');
            $product_image1 = '1-'.$timestamp.'-'.session::get('store_id').'-'.Auth::user()->id.'-'.clearString($image1->getClientOriginalName());
            $product->product_image1 = $product_image1;
            $image1->move(public_path().'/uploads/store/products/',$product_image1);
        }
        else
        {
            $product->product_image1 = "no_image.png";
        }

        if($request->hasFile('product_image2'))
        {
            $image2 = Input::file('product_image2');
            $product_image2 = '2-'.$timestamp.'-'.session::get('store_id').'-'.Auth::user()->id.'-'. clearString($image2->getClientOriginalName());
            $product->product_image2 = $product_image2;
            $image2->move(public_path().'/uploads/store/products/',$product_image2);
        }
        else
        {
            $product->product_image2 = "no_image.png";
        }

        if($request->hasFile('product_image3'))
        {
            $image3 = Input::file('product_image3');
            $product_image3 = '3-'.$timestamp.'-'.session::get('store_id').'-'.Auth::user()->id.'-'. clearString($image3->getClientOriginalName());
            $product->product_image3 = $product_image3;
            $image3->move(public_path().'/uploads/store/products/',$product_image3);
        }
        else
        {
            $product->product_image3 = "no_image.png";
        }

        if($request->hasFile('product_image4'))
        {
            $image4 = Input::file('product_image4');
            $product_image4 = '4-'.$timestamp.'-'.session::get('store_id').'-'.Auth::user()->id.'-'. clearString($image4->getClientOriginalName());
            $product->product_image4 = $product_image4;
            $image4->move(public_path().'/uploads/store/products/',$product_image4);
        }
        else
        {
            $product->product_image4 = "no_image.png";
        }
        $product->save();

        $product_id = Store_product::where('product_code', '=', $request->product_code)
            ->first();

        $log_string = "New product '".$request->product_name."' was added";
        $log = new Store_log;
        $log->store_id = session('store_id');
        $log->log = $log_string;
        $log->log_type = 3;
        $log->log_by = Auth::user()->id;
        $log->log_linker = $product_id->id;
        $log->save();

        return redirect()->back()->with('message',"Product added successfully.");
    }

    public function edit_p($id)
    {
        $store = $this->store();

        $check_product = Store_product::where('id','=',$id)
            ->where('store_id','=',session('store_id'))
            ->count();
        if($check_product == 1)
        {

            $product = Store_product::select('store_products.id','product_name','product_price','product_code','product_discount','product_quantity','product_desc','category','store_product_categories.category_id','product_image1','product_image2','product_image3','product_image4', 'display')
                ->join('store_product_categories','store_product_categories.id','=','store_products.category_id')
                ->join('product_categories','product_categories.id','=','store_product_categories.category_id')
                ->where('store_products.id','=',$id)
                ->where('store_products.store_id','=',session('store_id'))
                ->first();

            $categories = Store_product_category::select('store_product_categories.id','category')
                ->join('product_categories','store_product_categories.category_id','=','product_categories.id')
                ->where('store_product_categories.store_id','=',session('store_id'))
                ->get();

            //    return $product['product_name'];
            return view('store.products.edit', compact('product','store','categories'));
        }
        else
        {
            return redirect()->back()->withErrors(['check'=>"An error has occured please try again."]);
        }
    }

    public function save_edit_p($id, Request $request)
    {
        $check_product = Store_product::where('id','=',$id)
            ->where('store_id','=',session('store_id'))
            ->first();
        if(count($check_product) == 1)
        {
            $product = Store_product::where('id','=',$id)
                ->where('store_id','=',session::get('store_id'))
                ->first(); 
            $product->product_code = clearString($request->product_code);
            $product->product_name = clearString($request->product_name);
            $product->product_desc = clearString($request->product_desc);
            $product->product_price = clearString($request->product_price);
            $product->product_discount = clearString($request->product_discount);
            $product->product_quantity = clearString($request->product_quantity);
            $product->category_id = clearString($request->product_category);
            $product->slug = str_slug(trim($request->product_name));
            $product->sub_category = clearString($request->product_sub_category);

            $timestamp = time();
            if($request->hasFile('product_image1'))
            {
                $image1 = Input::file('product_image1');
                $product_image1 = '1-'.$timestamp.'-'.session::get('store_id').'-'.Auth::user()->id.'-'. clearString($image1->getClientOriginalName());
                $product->product_image1 = $product_image1;
                $image1->move(public_path().'/uploads/store/products/',$product_image1);
            }

            if($request->hasFile('product_image2'))
            {
                $image2 = Input::file('product_image2');
                $product_image2 = '2-'.$timestamp.'-'.session::get('store_id').'-'.Auth::user()->id.'-'. clearString($image2->getClientOriginalName());
                $product->product_image2 = $product_image2;
                $image2->move(public_path().'/uploads/store/products/',$product_image2);
            }

            if($request->hasFile('product_image3'))
            {
                $image3 = Input::file('product_image3');
                $product_image3 = '3-'.$timestamp.'-'.session::get('store_id').'-'.Auth::user()->id.'-'. clearString($image3->getClientOriginalName());
                $product->product_image3 = $product_image3;
                $image3->move(public_path().'/uploads/store/products/',$product_image3);
            }

            if($request->hasFile('product_image4'))
            {
                $image4 = Input::file('product_image4');
                $product_image4 = '4-'.$timestamp.'-'.session::get('store_id').'-'.Auth::user()->id.'-'. clearString($image4->getClientOriginalName());
                $product->product_image4 = $product_image4;
                $image4->move(public_path().'/uploads/store/products/',$product_image4);
            }
            $product->save();

            $log_string = "Product '".$check_product->product_name."' was edited";
            $log = new Store_log;
            $log->store_id = session('store_id');
            $log->log = $log_string;
            $log->log_type = 31;
            $log->log_by = Auth::user()->id;
            $log->log_linker = $check_product->id;
            $log->save();

            return redirect()->back()->with('message','Products edited successfully.');
        }
        else
        {
            return redirect()->back()->withErrors(['check'=>"An error has occured please try again."]);
        }

    }

    public function list_sale()
    {
        $store = $this->store();

        $sales = Store_sale::where('store_id','=',session::get('store_id'))
            ->paginate(10);

        return view('store.sales.list', compact('store','sales'));
    }

    public function save_sale(Request $request)
    {  
        $discount = $request->sale_discount;
        $sale = new Store_sale;
        $sale->store_id = session::get('store_id');
        $sale->sale_name = $request->sale_name;
        $sale->sale_tagline = $request->sale_tagline;
        $sale->start_date = $request->sale_start_date;
        $sale->end_date = $request->sale_end_date;
        $sale->discount = $discount;
        $sale->sale_slug = str_slug($request->sale_name);

        if($discount >= 1 && $discount <= 99)
        {
            $sale->save();
            $sale_id = $sale->id;
            $url = "/store/sales/sale/".$sale_id."/products";
            return redirect()->to($url);
        }
        else
        {
            return redirect()->back()->withErrors(['check'=>"Discount must be from 1% to 99%."]);
        }
    }

    public function get_sale($id)
    {
        $store  = $this->store();

        $sale_id = $id;

        $sale = Store_sale::where('sale_id','=',$id)
            ->where('store_id','=',session('store_id'))
            ->first();

        $sale_products = Store_sale_product::join('store_products','store_sale_products.product_id','=','store_products.id')
                        ->where('store_products.store_id','=',session::get('store_id'))
                        ->where('store_sale_products.sale_id','=',$id)
                        ->get();

        $nosaleproducts = Store_product::select('store_products.id','store_products.product_name')
            ->leftJoin('store_sale_products',function($join){
             $join->on('store_products.id','=','store_sale_products.product_id');})
            ->whereNull('store_sale_products.sale_id')
            ->where('store_products.store_id','=',session::get('store_id'))
            ->get();


        return view('store.sales.sale', compact('store','sale_id','sale','nosaleproducts','sale_products'));
    }

    public function add_into_sale($sale, $product)
    {
        //Check if store id and sale id is matching
        $sale_product_id = NULL;
        $store_product = NULL;
        $store_verification = Store_sale::where('sale_id','=',$sale)
                            ->where('store_id','=',session::get('store_id'))
                            ->get();

        $sale_store_id = $store_verification[0]->store_id; 

        $product_verfication = Store_product::where('id','=',$product)
            ->where('store_id','=',session::get('store_id'))
            ->first(['id']);
        if(isset($product_verfication))
        {
            $store_product = $product_verfication->id;
        }

        //Check if product is in the store_sale_productlist.
        $sale_product_verfication = Store_sale_product::select()
                                ->where('product_id','=',$product)
                                ->where('sale_id','=',$sale)
                                ->first();
                                //dd($product_verfication);
        if(isset($sale_product_verfication['product_id']))
        {
            $sale_product_id = $sale_product_verfication['product_id'];
        }
        $ssp = new Store_sale_product;
        $ssp->sale_id = $sale;
        $ssp->product_id = $product;


        if(session::get('store_id') == $sale_store_id)
        {
            if($store_product != NULL)
            {
                if($sale_product_id == NULL)
                {

                    $ssp->save();
                }
            }
        }

        $url = '/store/sales/sale/'.$sale.'/products';

        return redirect()->to($url);
    }

    public function remove_from_sale($sale, $product)
    {
        $sale_product_id = NULL;
        $store_product = NULL;
        $store_verification = Store_sale::where('sale_id','=',$sale)
                            ->where('store_id','=',session::get('store_id'))
                            ->get();

        $sale_store_id = $store_verification[0]->store_id; 

        $product_verfication = Store_product::where('id','=',$product)
            ->where('store_id','=',session::get('store_id'))
            ->first(['id']);
        if(isset($product_verfication))
        {
            $store_product = $product_verfication->id;
        }

        //Check if product is in the store_sale_productlist.
        $sale_product_verfication = Store_sale_product::select()
                                ->where('product_id','=',$product)
                                ->where('sale_id','=',$sale)
                                ->first();
                                //dd($product_verfication);
        if(isset($sale_product_verfication['product_id']))
        {
            $sale_product_id = $sale_product_verfication['product_id'];
        }

        if(session::get('store_id') == $sale_store_id)
        {
            if($store_product != NULL)
            {
                if($sale_product_id != NULL)
                {
                    Store_sale_product::where('sale_id','=',$sale)
                        ->where('product_id','=',$product)
                        ->delete();
                    
                }
            }
        }

        $url = '/store/sales/sale/'.$sale.'/products';

        return redirect()->to($url);
    }

    public function update_sale_status($sale, $status)
    {
        //Verify Store and sale
        $check_store = NULL;
        $check_sale = NULL;
        $store_sale_verification = Store_sale::where('store_id','=',session::get('store_id'))
            ->where('sale_id','=',$sale)
            ->first();

        //dd($store_sale_verification);
        if(isset($store_sale_verification))
        {
            $check_sale = $store_sale_verification->sale_id;
            $check_store = $store_sale_verification->store_id;
            $days_left = days_difference($store_sale_verification->end_date);
        

            if(isset($status) && $check_store != NULL && $check_sale != NULL)
            {
                if($status == "active")
                {
                    if($days_left > 1)
                    {
                        Store_sale::where('sale_id','=',$sale)
                            ->update(['status'=>"1"]);

                        return redirect()->back()->with(['message' => "Sale is ACTIVE now"]);
                    }
                }
                if($status == "inactive")
                {
                    Store_sale::where('sale_id','=',$sale)
                            ->update(['status'=>"0"]);

                    return redirect()->back()->with(['message' => "Sale is INACTIVE now"]);
                }
            }
        }

        return redirect()->back()->withErrors(['check' => "Please edit the sales starting and ending dates. Sale seems to be expired."]);
    }


    public function update_store(Request $request)
    {
        $slug = str_slug($request->store_name);
        Store::where('store_id','=',session::get('store_id'))
            ->update(array('store_username'=>$request->store_username, 'store_name'=>$request->store_name, 'store_email'=> $request->store_email, 'slug'=>$slug));

        return redirect()->back();
    }




    




















    /*
     ___   _   ___ 
    |   |   | |   | \/
    |---| __| |---| /\
    */

    public function check_store_username(Request $request)
    {
    	$store_username = $request->store_username;
        $store_username = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9._@]/', ' ', urldecode(html_entity_decode(strip_tags($store_username))))));
        if($store_username != "")
        {
            $store = Store::where('store_username', 'like', $store_username)->first();
            if($store)
            {
                return['error'=>'yes'];
            }
            else
            {
                return ['error'=>'no'];
            }
        }
        else
        {
            return ['error'=>'Please Enter Username'];
        }
    }

    public function check_store_name(Request $request)
    {
    	$store_name = $request->store_name;
        $store_name = trim(preg_replace('/ +/', ' ', preg_replace("/[^A-Za-z0-9._@']/", ' ', urldecode(html_entity_decode(strip_tags($store_name))))));
        if($store_name != "")
        {
            $store = Store::where('store_name', 'like', $store_name)->first();
            if($store)
            {
                return['error'=>'yes'];
            }
            else
            {
                return ['error'=>'no'];
            }
        }
        else
        {
            return ['error'=>'Please Enter Name'];
        }
    }

    public function check_store_email(Request $request)
    {
		$store_email = $request->store_email;
        $store_name = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9._@]/', ' ', urldecode(html_entity_decode(strip_tags($store_email))))));
        if($store_email != "")
        {
            $store = Store::where('store_email', 'like', $store_email)->first();
            if($store)
            {
                return['error'=>'yes'];
            }
            else
            {
                return ['error'=>'no'];
            }
        }
        else
        {
            return ['error'=>'Please Enter Email'];
        }
    }

    public function create_store()
    {
    	$personal_stores = Auth::user()->store_links->where('privilege','=','Owner');
    	if($personal_stores->count() == 3)
    	{
    		return 'You already have three personal stores. Cannot create further';
    	}
    	return view('user.stores.create_store');
    }

    public function save_store(Request $request)
    {

    	$id = Store::create($request->all())->store_id;

    	$lts = new Link_to_store;
    	$style = new Store_style;
    	$employment = new Store_employment;
    	$sdetails = new Store_detail;
        $brand = new Store_brandmark;
        $layout = new Store_layout;
        $header = new Store_header;
        $banner = new Store_banner;
        $product_area = new Store_product_area;
        $category_panel = new Store_category_panel;
        $sale_area = new Store_sale_area;
        $single = new Store_single_product;
        //$policy = new Store_policy_area;

    	$lts->store_id = $id;
    	$lts->user_id = Auth::user()->id;
    	$lts->privilege = 'Owner';

    	$style->store_id = $id;

    	$employment->store_id = $id;

    	$sdetails->store_id = $id;

        $brand->store_id = $id;

        $layout->store_id = $id;
        $layout->layout_id = 1;

        $header->store_id = $id;
        $header->header_id = 1;

        $banner->store_id = $id;
        $banner->banner_id = 1;

        $product_area->store_id = $id;
        $product_area->product_area_id = 1;

        $category_panel->store_id = $id;
        $category_panel->category_panel_id = 1;

        $sale_area->store_id = $id;
        $sale_area->sale_area_id = 1;

        $single->store_id = $id;
        $single->store_single_product_id = 1;

        //$policy->store_id = $id;
        //$policy->policy_id = 1;

    	$lts->save();
    	$style->save();
    	$employment->save();
    	$sdetails->save();
        $brand->save();
        $layout->save();
        $header->save();
        $banner->save();
        $product_area->save();
        $category_panel->save();
        $sale_area->save();
        $single->save();
        //$policy->save();

    	return redirect()->to('/user/stores/personal')->with('message', 'You have successfully opened a store.');
    }



    public function display_product(Request $request)
    {

        
        $check_product = Store_product::where('store_id','=',session('store_id'))
            ->where('id','=',$request->product_id)
            ->first();
     
         if(count($check_product) == 1)
        {
            $check_count = Store_product::where('store_id','=', session('store_id'))
                ->where('display','=', 1)
                ->get();

            if(count($check_count) <= 12)
            {
                $update = Store_product::where('id','=',$check_product->id)
                    ->update(['display'=>$request->product_display]);

                $log = new Store_log;
                $log->store_id = session('store_id');
                if($check_product->display == 0)
                {
                    $log_string = "Product added to display";
                    $log->log_type = 32;
                    $log->log = $log_string;
                    $log->log_by = Auth::user()->id;
                    $log->log_linker = $check_product->id;
                    $log->save();
                    return redirect()->back()->with('message', 'Product added to display');
                }
                if($check_product->display == 1)
                {
                    $log_string = "Product removed from display";
                    $log->log_type = 33;
                    $log->log = $log_string;
                    $log->log_by = Auth::user()->id;
                    $log->log_linker = $check_product->id;
                    $log->save();
                    return redirect()->back()->with('message', 'Product removed from display');
                }
            }
            else
            {
                return redirect()->back()->withErrors(['check' => 'Products display limit reached. It cannot be more than 12']);
            }
        }
        return redirect()->back()->withErrors(['check' => 'Oops! Something went wrong.']);
    }

    public function direct_messages()
    {
        $store = $this->store();

        $get_message_users = Store_user_message::where('message_from','=',session('store_id'))
            /*->where('user_type','=',2)*/
            ->groupBy('message_to')
            ->get();
      
        $get_messages = Store_user_message::where('message_from','=',session('store_id'))
            ->orderBy('message_id', 'ASC')
            ->get();

        return view('store.messages.directs', compact('store','get_messages', 'get_message_users'));
    }
    public function send_direct_message(Request $request)
    {
        $message_to = clearString($request->message_to);
        $message_after = clearString($request->last_message);
        $message_text = clearString($request->message);

        $message = new Store_user_message;
        $message->user_type = 2;
        $message->message_to = $message_to;
        $message->message_text = $message_text;
        $message->message_after = $message_after;
        $message->message_type = 1;
        $message->message_from = Auth::user()->id;
        $message->save();

        return redirect()->back();
    }

    public function mark_messages_seen(Request $request)
    {
        Store_user_message::where('message_to','=',$request->id)
            ->where('user_type','=',1)
            ->where('message_from','=',session('store_id'))
            ->where('seen','=',0)
            ->update(['seen'=>1]);
    }
}
