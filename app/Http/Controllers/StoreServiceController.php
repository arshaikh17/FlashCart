<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Store;
use Auth;
use App\User;
use App\Link_to_store;
use App\Store_user_message;
use App\Store_user_conversation;
use App\Store_user_conversation_message;
use App\Store_log;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class StoreServiceController extends Controller
{
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

    public function start_conversation(Request $request)
    {
    	$title = clearString($request->qc_title);
    	$receiver = clearString($request->qc_receiver);
    	$message = clearString($request->qc_message);

    	$convo_id = DB::table('store_user_conversations')
    		->insertGetId(array
    			(
    				'suc_title' => $title,
    				'suc_from' => session('store_id'),
    				'suc_to' => $receiver,
    				'starter' => Auth::user()->id,
    				'created_at' => date("Y-m-d H:i:s")
    			));

    	$msg = new Store_user_conversation_message;
    	$msg->conversation_id = $convo_id;
    	$msg->sucm_message = $message;
    	$msg->sucm_type = 2;
    	$msg->save();

    	$receiver_details = returnUser($receiver);
    	$log_string = "New conversation '".$title."' started";
    	$log = new Store_log;
		$log->store_id = session('store_id');
		$log->log = $log_string;
		$log->log_type = 1;
		$log->log_by = Auth::user()->id;
		$log->log_to = $receiver;
		$log->log_linker = $convo_id;
		$log->save();

    	return redirect()->back()->with('message', 'Conversation successfully started. Message sent.');
    }

    public function send_message(Request $request)
    {
    	$message = clearString($request->cm_message);
    	$convo_id = clearString($request->cm_conversation);
    	$user_id = clearString($request->cm_user);

    	$check = Store_user_conversation::where('suc_id','=',$convo_id)
    		->where('suc_to','=',$user_id)
    		->count();

    	if($check == 1)
    	{
    		$msg = new Store_user_conversation_message;
    		$msg->sucm_message = $message;
    		$msg->conversation_id = $convo_id;
    		$msg->sucm_type = 2;
    		$msg->save();

    		return redirect()->back()->with('message',"Message sent successfully.");
    	}
    	else
    	{
    		return redirect()->back()->with(['check'=>"Oops! Something went wrong."]);
    	}
    }

    public function goto_messages()
    {
    	$store = $this->store();

    	$get_users = Link_to_store::where('store_id','=',session('store_id'))
    		->get();
    	$users = array();
    	foreach($get_users as $user)
    	{
    		$new_user = array();

    		if($user->user_id != Auth::user()->id)
    		{
    			$user_info = User::select('id','name','picture')
    				->where('id','=',$user->user_id)
    				->first();

    			$new_user['user_id'] = $user_info->id;
    			$new_user['user_name'] = $user_info->name;
    			$new_user['user_picture'] = $user_info->picture;
    			$users[] = $new_user;
    		}
    	}

    	return view('store.messages.users', compact('store', 'users'));
    }

    public function get_user_conversations($userId)
    {
    	$store = $this->store();

    	$get_users = Link_to_store::where('store_id','=',session('store_id'))
    		->get();
    	$users = array();
    	foreach($get_users as $user)
    	{
    		$new_user = array();

    		if($user->user_id != Auth::user()->id)
    		{
    			$user_info = User::select('id','name','picture')
    				->where('id','=',$user->user_id)
    				->first();

    			$new_user['user_id'] = $user_info->id;
    			$new_user['user_name'] = $user_info->name;
    			$new_user['user_picture'] = $user_info->picture;
    			$users[] = $new_user;
    		}
    	}

    	$user_id = clearString($userId);

    	$check = Link_to_store::where('user_id','=',$user_id)
    		->where('store_id','=',session('store_id'))
    		->count();

    	if($check == 1)
    	{
			$conversations = Store_user_conversation::where('suc_from','=',session('store_id'))
				->where('suc_to','=',$user_id)
				->orderBy('suc_id','DESC')
				->get();

    		return view('store.messages.conversations', compact('store', 'users', 'conversations','user_id'));
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['check'=>'Oops! Something went wrong.']);
    	}
    }

    public function get_conversation_messages($userId = "", $convoId = "")
    {
    	$store = $this->store();

    	$get_users = Link_to_store::where('store_id','=',session('store_id'))
    		->get();
    	$users = array();
    	foreach($get_users as $user)
    	{
    		$new_user = array();

    		if($user->user_id != Auth::user()->id)
    		{
    			$user_info = User::select('id','name','picture')
    				->where('id','=',$user->user_id)
    				->first();

    			$new_user['user_id'] = $user_info->id;
    			$new_user['user_name'] = $user_info->name;
    			$new_user['user_picture'] = $user_info->picture;
    			$users[] = $new_user;
    		}
    	}
    	if($userId != "")
    	{
    	$user_id = clearString($userId);

    	$check = Link_to_store::where('user_id','=',$user_id)
    		->where('store_id','=',session('store_id'))
    		->count();

    	if($check == 1)
    	{
			$conversations = Store_user_conversation::where('suc_from','=',session('store_id'))
				->where('suc_to','=',$user_id)
				->where('suc_keep_alive','=',1)
				->orderBy('suc_id','DESC')
				->get();

				if($convoId != "")
				{

    	$convo_id = clearString($convoId);

			$check_convo = Store_user_conversation::where('suc_from','=',session('store_id'))
				->where('suc_to','=',$user_id)
				->where('suc_id','=',$convo_id)
				->first();

			if($check_convo != "")
			{
				if($check_convo->suc_keep_alive == 1)
				{
					Store_user_conversation_message::where('conversation_id','=',$convo_id)
						->where('sucm_type','=',1)
						->where('seen','=',0)
						->update(['seen'=>1]);

					return view('store.messages.messages', compact('store', 'users', 'conversations', 'convo_id','user_id'));
				}
				
			}
		}
		else
		{
			//return "2";
    		return view('store.messages.messages', compact('store', 'users', 'conversations','user_id'));
		}
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['check'=>'Oops! Something went wrong.']);
    	}
    }
    else
    {
    	return view('store.messages.messages', compact('store', 'users'));
    }
    }

    public function delete_message(Request $request)
    {
    	$convo_id = clearString($request->cm_delete_convo);

    	$check = Store_user_conversation::where('suc_id','=',$convo_id)
    		->where('suc_from','=',session('store_id'))
    		->first();

    	if($check != "")
    	{
    		Store_user_conversation::where('suc_id','=',$convo_id)
    			->where('suc_from','=',session('store_id'))
    			->update(['suc_keep_alive'=>0]);

    		$user = returnUser($check->suc_to);
    		$log_string = "Conversation '".$check->suc_title."' deleted";
    		$log = new Store_log;
			$log->store_id = session('store_id');
			$log->log = $log_string;
			$log->log_type = 11;
			$log->log_by = Auth::user()->id;
			$log->log_linker = $convo_id;
			$log->save();


    		return redirect()->back()->with('message','Conversation deleted!');
    	}
    	else
    	{
    		return redirect()->back()->withErrors(['check'=>'Oops! Something went wrong.']);
    	}
    }

    public function get_archive_conversation($convoId)
    {
    	return "deleted";
    }
}
