@extends('layouts.user')

@section('user-header')
    <h5><b><i class="fa fa-envelope"></i> My Messages</b></h5>
@endsection


@section('user-alert')
@if($errors->any())
    <div class="container">
        <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>NOTE!</strong> {!! $errors->first('check') !!}
        </div>
    </div>
    @endif
@endsection

@section('user-success')
@if(session()->has('message'))
  <div class="container">
    <div class="alert alert-success alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>SUCCESS!</strong>  
        {!! session()->get('message') !!}
    </div>
  </div>
  @endif
@endsection

@section('user-content')
<link rel="stylesheet" type="text/css" href="../../../../../css/user-list.css">
<link rel="stylesheet" type="text/css" href="../../../../../css/messages.css">
<div class="col-lg-3">
  <div class="panel panel-primary">
    <div class="panel-heading">
      Stores
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table user-list">
          <tbody>
          @forelse($stores as $store)
            <tr>
              <td @if(isset($store_id) && $store['store_id'] == $store_id) class="active-td" @endif>
                <a href="/user/conversations/{{ $store['store_id'] }}"><div>
                <img src="../../../../uploads/store/brand_marks/logo/{{ $store['brand_logo'] }}" alt="{{ $store['store_name'] }}">
                <p class="user-link">{{ $store['store_name'] }}</p>
                </div></a>
              </td>
            </tr>
          @empty
          <p>No store has started conversation.</p>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@if(isset($store_id))
<div class="col-lg-3">
  <div class="panel panel-primary">
    <div class="panel-heading">
      Conversations
    </div>
    <div class="panel-body">
      <div class="">
        <table class="table table-responsive conversation-list">
          <tbody>
            @forelse($conversations as $conversation)
            <?php
            $messages = getConversationMessages($conversation->suc_id, $conversation->suc_from);
            $unseen_messages = array();
            foreach($messages as $msg)
            {
            if($msg->seen == 0 && $msg->sucm_type == 2)
            {
            $unseen_messages[] = $msg;
            }
            }
            ?>
            <tr>
              <td @if(isset($convo_id) && $conversation->suc_id == $convo_id) class="active-td" @endif>
                <a href="/user/conversations/{{ $conversation->suc_from }}/{{ $conversation->suc_id }}">
                  <div>
                    <p class="conversation-link">{{ $conversation->suc_title }}
                      @if($conversation->seen == 0)
                      <span class="label label-success">new</span>
                      @endif
                      @if(count($unseen_messages) > 0)
                      <span class="label label-info">unseen</span>
                      @endif
                    </p>
                    <span class="user-subhead">Messages: {{ count($messages) }} &nbsp;&nbsp;&nbsp;&nbsp;Unseen: {{ count($unseen_messages) }}</span>
                  </div>
                </a>
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
</div>
@endif
@if(isset($store_id) && isset($convo_id))
<div class="col-lg-6">
  <div class="panel panel-primary">
    <div class="panel-heading">
      Messages
    </div>
    <div class="panel-body">
    <div class="box-body messages_box">
      <div class="chat_window">
        <ul class="messages">
        @forelse($convo_messages as $message)
          @if($message->sucm_type == 2) 
            <li class="message left appeared">
            <div class="avatar"><span class="avatar_text">You</span></div>
          @elseif($message->sucm_type == 1) 
            <?php $store = returnStore($store_id) ?>

            <li class="message right appeared">
            <div class="avatar"><span class="avatar_text">{{ getFirstLetters($store->store_name) }}</span></div>
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
          <form action="/user/conversations/send_message" method="POST">
          {{csrf_field()}}
          <input type="text" name="cm_conversation" class="hidden" value="{{ $convo_id }}" />
          <input type="text" name="cm_store" class="hidden" value="{{ $store_id }}" />
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
  </div>
</div>
@endif
@endsection