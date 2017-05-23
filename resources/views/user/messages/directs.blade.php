@extends('layouts.user')

@section('user-header')
    <h5><b><i class="fa fa-comment"></i> My Messages</b></h5>
@endsection



@section('user-content')
<section class="container">
  @forelse(array_chunk($get_message_users->all(), 3) as $row)
  <div class="row">
    @foreach($row as $message)
    <?php
    $store = returnStore($message->message_from);
    $last_message = "";
    ?>
    @if($message->message_from != 0)
    <div class="col-md-5 col-lg-5">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <div class="panel panel-primary">
              <div class="panel-heading" id="accordion">
                <span class="glyphicon glyphicon-comment"></span> {{ $store->store_name }}
                <div class="btn-group pull-right">
                  <a type="button" class="btn btn-default btn-xs viewer_button" id="{{ $message->message_from }}" data-toggle="collapse" data-parent="#accordion" href="#chat_{{ $message->message_from }}">
                    <span class="glyphicon glyphicon-chevron-down"></span>
                  </a>
                </div>
              </div>
              <div class="panel-collapse collapse" id="chat_{{ $message->message_from }}">
                <div class="panel-body">
                  <ul class="chat">
                    @foreach($get_messages as $get_message)
                    @if($get_message->message_from == $message->message_from)
                    @if($get_message->user_type == 1)
                    <li class="left clearfix"><span class="chat-img pull-left">
                      <img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" class="img-circle" />
                    </span>
                    <div class="chat-body clearfix">
                      <div class="header">
                        <strong class="primary-font">{{Auth::user()->name}}</strong> <small class="pull-right text-muted">
                        <span class="glyphicon glyphicon-time"></span>{{$get_message->created_at->diffForHumans()}}</small>
                      </div>
                      <p>
                        {{$get_message->message_text}}
                      </p>
                    </div>
                  </li>
                  <?php $last_message = $get_message->message_id; ?>
                  @elseif($get_message->user_type == 2)
                  <li class="right clearfix"><span class="chat-img pull-right">
                    <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                  </span>
                  <div class="chat-body clearfix">
                    <div class="header">
                      <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>{{$get_message->created_at->diffForHumans()}}</small>
                      <strong class="pull-right primary-font">{{ $store->store_name }}</strong>
                    </div>
                    <p>
                      {{$get_message->message_text}}
                    </p>
                  </div>
                </li>
                <?php $last_message = $get_message->message_id; ?>
                @endif
                @endif
                @endforeach
              </ul>
            </div>
            <div class="panel-footer">
              <form method="POST" action="/user/messages/send_message">
              {{csrf_field()}}
              <div class="input-group">
                <input type="text" name="last_message" value="{{ $last_message }}" class="hidden" />
                <input type="text" name="message_to" value="{{ $message->message_from }}" class="hidden">
                <input id="btn-input" name="message" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                <span class="input-group-btn">
                  <button class="btn btn-warning btn-sm" type="submit" id="btn-chat">
                  Send</button>
                </span>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endforeach
</div>
@empty
No chats, yet.
@endforelse
</section>

<style>
  a:hover
  {
    text-decoration: none !important;
  }
  .chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.chat li.left .chat-body
{
    margin-left: 60px;
}

.chat li.right .chat-body
{
    margin-right: 60px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #777777;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height: 250px;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

</style>
@endsection
