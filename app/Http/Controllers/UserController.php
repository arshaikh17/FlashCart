<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Store;
use App\User;
use App\Link_to_store;
use App\User_address;
use App\User_detail;
use App\Store_order;
use App\Store_product;
use App\Store_order_product;
use App\Store_product_category;
use App\Store_product_sub_category;
use App\Store_payment_option;
use App\store_sale;
use App\Store_user_conversation;
use App\Store_user_message;
use App\Store_user_conversation_message;
use App\Store_log;
use App\Store_brandmark;

use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function send_direct_message(Request $request)
    {
        $message_to = clearString($request->message_to);
        $message_after = clearString($request->last_message);
        $message_text = clearString($request->message);

        $message = new Store_user_message;
        $message->user_type = 1;
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
        Store_user_message::where('message_from','=',$request->id)
            ->where('user_type','=',2)
            ->where('message_to','=',Auth::user()->id)
            ->where('seen','=',0)
            ->update(['seen'=>1]);
    }

    public function direct_messages()
    {
        $get_message_users = Store_user_message::where('message_to','=',Auth::user()->id)
            /*->where('user_type','=',2)*/
            ->groupBy('message_from')
            ->get();
      
        $get_messages = Store_user_message::where('message_to','=',Auth::user()->id)
            ->orderBy('message_id', 'ASC')
            ->get();

        return view('user.messages.directs', compact('get_messages', 'get_message_users'));
    }
    public function index()
    {   

        //$personal_stores = Auth::user()->stores()->wherePivot('privilege', 'Owner')->get();
        $user_details = User_detail::join('user_addresses','user_addresses.user_id','user_details.user_id')
            ->where('user_details.user_id', '=', Auth::user()->id)
            ->first();

        $stores =Link_to_store::join('stores as s', 'link_to_stores.store_id', '=', 's.store_id')
            ->where('user_id','=',Auth::user()->id)
            ->get();

        $convo_messages = Store_user_conversation::where('suc_to','=', Auth::user()->id)
            ->join('store_user_conversation_messages as sucm','suc_id', 'conversation_id')
            ->where('suc_keep_alive','=',1)
            ->where('sucm_type','=',2)
            ->where('sucm.seen','=',0)
            ->get();

        $direct_messages = Store_user_message::where('message_to','=',Auth::user()->id)
            ->where('user_type','=',1)
            ->where('seen','=',0)
            ->get();

        return view('user.home',compact('stores', 'user_details', 'convo_messages', 'direct_messages'));
    }

    public function user_stores()
    {
        $personal_stores = Link_to_store::where('user_id','=',Auth::user()->id)
            ->where('privilege','=','Owner')
            ->count();

        $employeed_stores = Link_to_store::where('user_id','=',Auth::user()->id)
            ->where('privilege','=','Employee')
            ->count();

        return view('user.stores.stores', compact('personal_stores', 'employeed_stores'));
    }

    public function personal_stores()
    {
        $stores =Link_to_store::join('stores as s', 'link_to_stores.store_id', '=', 's.store_id')
            ->where('privilege','=','Owner')
            ->where('user_id','=',Auth::user()->id)
            ->get();

        $statistics = array();
        if($stores != "")
        {
            foreach($stores as $store)
            {
                $get_total_orders = Store_order::where('store_id','=',$store->store_id)
                    ->count();

                $get_total_products = Store_product::where('store_id','=',$store->store_id)
                    ->count();

                $get_total_products_sold = Store_order_product::join('store_orders as so','so_id','order_id')
                    ->where('store_id','=',$store->store_id)
                    ->count();

                $get_total_categories = Store_product_category::where('store_id','=',$store->store_id)
                    ->count();

                $get_total_sub_categories = Store_product_sub_category::where('store_id','=',$store->store_id)
                    ->count();

            $get_total_payment_options = Store_payment_option::where('store_id','=',$store->store_id)
                    ->count();

                $get_total_employees = Link_to_store::where('privilege','=','Employee')
                    ->where('store_id','=',$store->store_id)
                    ->count();

                $get_total_sales = Store_sale::where('store_id','=',$store->store_id)
                    ->count();

                $statistics[$store->store_id]['orders'] = $get_total_orders;
                $statistics[$store->store_id]['products'] = $get_total_products;
                $statistics[$store->store_id]['products_sold'] = $get_total_products_sold;
                $statistics[$store->store_id]['categories'] = $get_total_categories;
                $statistics[$store->store_id]['sub_categories'] = $get_total_sub_categories;
                $statistics[$store->store_id]['payment_options'] = $get_total_payment_options;
                $statistics[$store->store_id]['employees'] = $get_total_employees;
                $statistics[$store->store_id]['sales'] = $get_total_sales;
            }
        }
        else
        {
            $statistics = "";
        }
        return view('user.stores.personal', compact('stores', 'statistics'));
    }
    public function employeed_stores()
    {
        $stores =Link_to_store::join('stores as s', 'link_to_stores.store_id', '=', 's.store_id')
            ->where('privilege','=','Employee')
            ->where('user_id','=',Auth::user()->id)
            ->get();

        $statistics = array();
        if($stores != "")
        {
            foreach($stores as $store)
            {
                $get_total_orders = Store_order::where('store_id','=',$store->store_id)
                    ->count();

                $get_total_products = Store_product::where('store_id','=',$store->store_id)
                    ->count();

                $get_total_products_sold = Store_order_product::join('store_orders as so','so_id','order_id')
                    ->where('store_id','=',$store->store_id)
                    ->count();

                $get_total_categories = Store_product_category::where('store_id','=',$store->store_id)
                    ->count();

                $get_total_sub_categories = Store_product_sub_category::where('store_id','=',$store->store_id)
                    ->count();

            $get_total_payment_options = Store_payment_option::where('store_id','=',$store->store_id)
                    ->count();

                $get_total_employees = Link_to_store::where('privilege','=','Employee')
                    ->where('store_id','=',$store->store_id)
                    ->count();

                $get_total_sales = 2;/*Store_sale::where('store_id','=',$store->store_id)
                    ->count();*/

                $statistics[$store->store_id]['orders'] = $get_total_orders;
                $statistics[$store->store_id]['products'] = $get_total_products;
                $statistics[$store->store_id]['products_sold'] = $get_total_products_sold;
                $statistics[$store->store_id]['categories'] = $get_total_categories;
                $statistics[$store->store_id]['sub_categories'] = $get_total_sub_categories;
                $statistics[$store->store_id]['payment_options'] = $get_total_payment_options;
                $statistics[$store->store_id]['employees'] = $get_total_employees;
                $statistics[$store->store_id]['sales'] = $get_total_sales;
            }
        }
        else
        {
            $statistics = "";
        }
        return view('user.stores.employeed', compact('stores', 'statistics'));
    }

    public function address()
    {
        $address = User_address::where('user_id', '=', Auth::user()->id)
            ->first();

        return view('user.settings.address', compact('address'));
    }

    public function settings()
    {
        return view('user.settings.settings');
    }

    public function save_picture(Request $request)
    {
        $path = public_path().'/uploads/user/pictures/';
        $image = $request->file('user_picture_new');
        $picture = Auth::user()->id."-".time()."-".$image->getClientOriginalName();

        if($image->move($path,$picture))
        {
            User::where('id','=',Auth::user()->id)
                ->update(['picture'=>$picture]);

            return redirect()->back()->with('message', "Profile Picture saved.");
        }

        return redirect()->back()->withErrors(['check'=>"Failed to upload picture."]);
    }

    public function save_primary_information(Request $request)
    {
        $name = clearString($request->primary_full_name);

        User::where('id','=',Auth::user()->id)
            ->update(['name'=>$name]);

        return redirect()->back()->with('message', "Primary details saved.");
    }

    public function edit_address(Request $request)
    {
        $house = trim($request->hno);
        $street = trim($request->street);
        $area = trim($request->area);
        $city = trim($request->city);
        $state = trim($request->state);
        $postal = trim($request->postal_code);
        $phone = trim($request->phone);
        $mobile = trim($request->mobile);
        $mobile_2 = trim($request->mobile_2);

        User_address::where('user_id','=', Auth::user()->id)
            ->update(['house_no'=>$house, 'street'=>$street, 'area'=>$area, 'city'=>$city, 'state'=>$state, 'postal'=>$postal, 'phone'=>$phone, 'mobile'=>$mobile, 'mobile_2'=>$mobile_2]);

        return redirect()->back()->with('message', "Address details saved.");
    }

    public function goto_messages()
    {
        $get_stores = Store_user_conversation::where('suc_to','=',Auth::user()->id)
            ->groupBy('suc_from')
            ->get();

        $stores = array();

        foreach($get_stores as $store)
        {
            $store_info = Store::select('stores.store_id','store_name','brand_logo')
                ->join('store_brandmarks as sb','sb.store_id','stores.store_id')
                ->where('stores.store_id','=',$store->suc_from)                    
                ->first();
            $stores[] = $store_info;
        }

        return view('user.messages.users', compact('stores'));
    }

    public function get_conversations($storeId)
    {
        $store_id = clearString($storeId);

        $get_stores = Store_user_conversation::where('suc_to','=',Auth::user()->id)
            ->groupBy('suc_from')
            ->get();

        $stores = array();

        foreach($get_stores as $store)
        {
            $store_info = Store::select('stores.store_id','store_name','brand_logo')
                ->join('store_brandmarks as sb','sb.store_id','stores.store_id')
                ->where('stores.store_id','=',$store->suc_from)                    
                ->first();
            $stores[] = $store_info;
        }

        $conversations = Store_user_conversation::where('suc_from','=',$store_id)
            ->where('suc_to','=',Auth::user()->id)
            ->get();

        return view('user.messages.conversations', compact('stores', 'conversations', 'store_id'));
    }

    public function get_messages($storeId = "", $convoId = "")
    {
        $get_stores = Store_user_conversation::where('suc_to','=',Auth::user()->id)
            ->groupBy('suc_from')
            ->get();

        $stores = array();

        foreach($get_stores as $store)
        {
            $store_info = Store::select('stores.store_id','store_name','brand_logo')
                ->join('store_brandmarks as sb','sb.store_id','stores.store_id')
                ->where('stores.store_id','=',$store->suc_from)                    
                ->first();
            $stores[] = $store_info;
        }

        if($storeId != "")
        {
            $store_id = clearString($storeId);
        $conversations = Store_user_conversation::where('suc_from','=',$store_id)
            ->where('suc_to','=',Auth::user()->id)
            ->orderBy('suc_id', 'DESC')
            ->get();
            if($convoId != "")
            {
                $convo_id = clearString($convoId);
        $convo_messages = Store_user_conversation_message::select('suc_id','sucm_id','sucm_type','suc_title','suc_to','suc_from','sucm_message','store_user_conversation_messages.seen','store_user_conversation_messages.created_at','store_user_conversation_messages.updated_at')
            ->join('store_user_conversations as suc','suc_id','conversation_id')
            ->where('conversation_id','=',$convo_id)
            ->where('suc_from','=',$store_id)
            ->where('suc_to','=',Auth::user()->id)
            ->get();

        Store_user_conversation::where('suc_id','=',$convo_id)
            ->where('suc_from','=',$store_id)
            ->where('seen','=',0)
            ->update(['seen'=>1]);

        Store_user_conversation_message::where('conversation_id','=',$convo_id)
            ->where('seen','=',0)
            ->where('sucm_type','=',2)
            ->update(['seen'=>1]);

        return view('user.messages.messages', compact('stores', 'conversations', 'convo_messages', 'store_id', 'convo_id'));
    }
    else
    {
        return view('user.messages.messages', compact('stores', 'conversations', 'store_id'));
    }
    }
    else
    {
        return view('user.messages.messages', compact('stores'));
    }
    }

    public function send_message(Request $request)
    {
        $convo_id = clearString($request->cm_conversation);
        $store_id = clearString($request->cm_store);
        $msg = clearString($request->cm_message);

        $check = Store_user_conversation::where('suc_from','=',$store_id)
            ->where('suc_id','=',$convo_id)
            ->count();

        if($check == 1)
        {
            $message = new Store_user_conversation_message;
            $message->sucm_message = $msg;
            $message->sucm_type = 1;
            $message->conversation_id = $convo_id;
            $message->save();

            return redirect()->back()->with('message','Message sent succesfully.');
        }

        return redirect()->back()->withErrors(['check'=>'Oops! Something went wrong.']);
    }
}
