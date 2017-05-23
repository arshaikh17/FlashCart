<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Notification;
use App\Store_notification;
use App\Store_log;
use Mailgun\Mailgun;
use Pushpad;
use Notification;
use Auth;
use App\Mail\orderPlaced;
use Illuminate\Support\Facades\Mail;

class AjaxController extends Controller
{
    public function notifications_action(Request $request)
    {
     	if($request->id == 1)
     	{
     		Store_notification::where('store_id','=',session('store_id'))
                ->where('seen','=',0)
     			->update(['seen'=>1]);
     	}
    }

    public function logs_action(Request $request)
    {
     	if($request->id == session('store_id'))
     	{
     		Store_log::where('store_id','=',session('store_id'))
                ->where('seen','=',0)
     			->update(['seen'=>1]);
     	}
    }

    public function test()
    {

        /*$mgClient = new Mailgun('key-c95c91448e742a12c081504be52cbdf1');
        $domain = "flashcart.com.pk";
        $result = $mgClient->sendMessage($domain, array(
    'from'    => 'Excited User <arshaikh_17@hotmail.com>',
    'to'      => 'Baz <flash@flashcart.com.pk>',
    'subject' => 'Hello',
    'text'    => 'Testing some Mailgun awesomness!'
));*/
        //dd($result);
/*Pushpad\Pushpad::$auth_token = 'f60cc83fc31cf15d3ba9a72f7d24027e';
    Pushpad\Pushpad::$project_id = "3464";
        $notification = new Pushpad\Notification(array(
  'body' => "Hello world!", # max 120 characters
  'title' => "Website Name", # optional, defaults to your project name, max 30 characters
  'target_url' => "http://example.com", # optional, defaults to your project website
  'icon_url' => "http://example.com/assets/icon.png", # optional, defaults to the project icon
  'ttl' => 604800 # optional, drop the notification after this number of seconds if a device is offline
));
        $notification->deliver_to(Auth::user()->id, ["tags" => ["avc", "tags2"]]);
$notification->deliver_to(Auth::user()->id);*/

        return view('test');
        //Mail::to('arshaikh_17@hotmail.com')
            //->send(new orderPlaced());
        
    }

}
