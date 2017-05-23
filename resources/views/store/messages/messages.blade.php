@extends('layouts.store', ['store'=>$store])

@section('store-view')
Messages
@endsection
@section('store-subview')
Users @if(isset($user_id))Conversations @if(isset($convo_id))Messages @endif @endif
@endsection

@section('store-breadcrumb')
<li><a href="/store/conversations">Conversations</a></li>
<li><a href="/store/conversations">Users</a></li>
@if(isset($user_id))
<li><a href="/store/conversations/{{$user_id}}">Conversations</a></li>
@if(isset($convo_id))
<li>Messages</li>
@endif
@endif
@endsection


@section('store-alertcontent')
@if($errors->any())
  <div class="container">
    <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>NOTE!</strong>  
        {!! $errors->first('check') !!}
    </div>
  </div>
  @section('css')
  <style>
    .check{
  color:red;
  background:red;
  border-radius:50%;
  animation:op 3s ease infinite;
}
@keyframes op{
0%{
  opacity:0;
}
50%{
  opacity:1;
}
100%{
  opacity:0;
}
}
  </style>
  @endsection
  @endif
@endsection
@section('store-successcontent')
@if(session()->has('message'))
  <div class="container">
    <div class="alert alert-success alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>SUCCESS!</strong>  
        {!! session()->get('message') !!}
    </div>
  </div>
  @section('css')
  <style>
    .success{
  color:green;
  background:green;
  border-radius:50%;
  animation:op 3s ease infinite;
}
@keyframes op{
0%{
  opacity:0;
}
50%{
  opacity:1;
}
100%{
  opacity:0;
}
}
  </style>
  @endsection
  @endif
@endsection

@section('store-content')
<link rel="stylesheet" type="text/css" href="../../../../../css/messages.css">
<link rel="stylesheet" type="text/css" href="../../../../../css/user-list.css">
<section class="col-lg-3">
  <div class="box box-primary">
    <div class="box-header">
      <div class="box-title">Users</div>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table user-list">
          <tbody>
          @forelse($users as $user)
            <tr>
              <td @if(isset($user_id) && $user['user_id'] == $user_id) class="active-td" @endif>
                <a href="/store/conversations/{{ $user['user_id'] }}"><div>
                <img src="../../../../uploads/user/pictures/{{ $user['user_picture'] }}" alt="{{ $user['user_name'] }}">
                <p class="user-link">{{ $user['user_name'] }}</p>
                </div></a>
              </td>
            </tr>
          @empty
          <p>No other users working in this store, yet.</p>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@if(isset($conversations))
<section class="col-lg-3">
<div class="box box-primary">
    <div class="box-header">
      <div class="box-title">Conversations</div>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table conversation-list">
          <tbody>
          @forelse($conversations as $conversation)
          <?php 
            $messages = getConversationMessages($conversation->suc_id, session('store_id'));

            $unseen_messages = array();
            foreach($messages as $msg)
            {
              if($msg->seen == 0 && $msg->sucm_type == 1)
              {
                $unseen_messages[] = $msg;
              }
            }
          ?>
            <tr>
              <td @if(isset($convo_id) && $conversation->suc_id == $convo_id) class="active-td" @endif>
                <a href="/store/conversations/{{ $conversation->suc_to }}/{{ $conversation->suc_id }}">
                <div>
                <p class="conversation-link" >{{ $conversation->suc_title }}  
                  @if(count($unseen_messages) > 0)
                  <span class="label label-success">new</span>
                  @endif
                </p>
                <span class="user-subhead">Messages: {{ count($messages) }} &nbsp;&nbsp;&nbsp;&nbsp;Unseen: {{ count($unseen_messages) }}</span>
                </div>
                </a>
                <br />
                @if(isset($convo_id))
                  @if($conversation->suc_id != $convo_id)
                  <form action="/store/conversations/actions/delete" method="POST">
                    {{csrf_field()}}
                    <input type="text" name="cm_delete_convo" class="hidden" value="{{ $conversation->suc_id }}" />
                    <button type="submit" class="pull-right" style="background: none;padding: 0px;border: none;"><i class="fa fa-close fa-1g" style="color:red;"></i></button>
                </form>
                  @endif
                @else
                <form action="/store/conversations/actions/delete" method="POST">
                  {{csrf_field()}}
                  <input type="text" name="cm_delete_convo" class="hidden" value="{{ $conversation->suc_id }}" />
                  <button type="submit" class="pull-right" style="background: none;padding: 0px;border: none;"><i class="fa fa-close fa-1g" style="color:red;"></i></button>      
                </form>
                @endif
              </td>
            </tr>
          @empty
          <p>No other users working in this store, yet.</p>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
</div>
</section>
@endif
@if(isset($conversations) && isset($messages) && isset($convo_id))
<section class="col-lg-6">
  <div class="box box-primary">
    <div class="box-header">
      <div class="box-title">Messages</div>
    </div>
    <div class="box-body messages_box">
      <div class="chat_window">
        <ul class="messages">
        <?php $messages = getConversationMessages($convo_id, session('store_id')); ?>
        @forelse($messages as $message)
          @if($message->sucm_type == 2) 
            <li class="message left appeared">
            <div class="avatar"><span class="avatar_text">You</span></div>
          @elseif($message->sucm_type == 1) 
            <?php $user = returnUser($user_id) ?>
            <li class="message right appeared">
            <div class="avatar"><span class="avatar_text">{{ getFirstLetters($user->name) }}</span></div>
          @endif
          
            <div class="text_wrapper">
              <span class="main_text">{{ $message->sucm_message }}</span>
              <span class="text_info">Sent at: {{ $message->created_at->diffForHumans() }} 
              @if($message->updated_at != "" && $message->updated_at != $message->created_at)
               - Seen at: {{$message->updated_at->diffForHumans()}} 
              @endif
              </span>
            </div>
          </li>
        @empty
          <p>No messages in this conversation.</p>
        @endforelse
        </ul>
        <div class="bottom_wrapper clearfix">
          <form action="/store/conversations/send_message" method="POST">
          {{csrf_field()}}
          <input type="text" name="cm_conversation" class="hidden" value="{{ $convo_id }}" />
          <input type="text" name="cm_user" class="hidden" value="{{ $user_id }}" />
          <div class="row">
            <div class="col-lg-10">
                <textarea placeholder="Type your message here..." class="form-control" name="cm_message" style="resize: none;"></textarea>
            </div>
            <div class="col-lg-2">
                <input type="submit" value="Send" class="btn btn-primary">
            </div>
          </div>
         
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif
@endsection