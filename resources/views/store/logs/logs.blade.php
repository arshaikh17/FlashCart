@extends('layouts.store', ['store'=>$store])

@section('store-view')
Logs
@endsection
@section('store-subview')
All Logs
@endsection

@section('store-breadcrumb')
<li><a href="/store">Home</a></li>
<li>Logs</li>
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
<link rel="stylesheet" type="text/css" href="../../../../css/logs.css" />
<section class="col-lg-10">
  <div class="box box-primary">
    <div class="box-header">
      <div class="box-title">Logs</div>
    </div>
    <div class="box-body">
      <div class="col-lg-10  col-lg-offset-1">
        <div class="panel panel-primary log_box">
          
          <div class="panel-body log_box">
            <table class="table table-responsive table-condensed log_table">
              @forelse($logs as $log)

                @if($log->log_type == 1)
                <?php
                $user = returnUser($log->log_to);
                $user2 = returnUser($log->log_by);
                ?>
                <tr class="">
                  <td class="log_left">
                    <div class="log_contents">
                      <table>
                        <tr><td>{{ $log->log }} @if($log->seen == 0)<span class="label label-danger">new</span>@endif</td>
                      </tr>
                      <tr><td>With:&nbsp;&nbsp;<span class="label label-info">{{ $user->name }}</span>                  
                      &nbsp;&nbsp;
                  By:&nbsp;&nbsp;<span class="label label-info">{{ $user2->name }}</span>
                  <br /></td></tr>
                      <tr><td>
                        <a href="/store/conversations/{{ $log->log_to }}/{{ $log->log_linker }}">view conversation</a>
                      </td></tr>
                    </table>
                  </div>
                </td>
                <td class="log_right">
                  <div class="log_contents">
                    <table>
                      <tr><td>Log recorded on:</td></tr>
                      <tr><td>{{ $log->created_at->diffForHumans() }}</td></tr>
                      <tr><td>{{ date_format($log->created_at, 'l / M dS, y') }}</td></tr>
                    </table>
                  </div>
                </td>
              </tr>
                @elseif($log->log_type == 11)
                <?php
                $user = returnUser($log->log_by);
                ?>
                <tr class="">
                  <td class="log_left">
                    <div class="log_contents">
                      <table>
                        <tr><td>{{ $log->log }} @if($log->seen == 0)<span class="label label-danger">new</span>@endif</td>
                      </tr>
                      <tr><td>Deleted by:&nbsp;&nbsp;<span class="label label-info">{{ $user->name }}</span></td></tr>
                      <tr><td>
                        <a href="/store/conversations/archive/{{ $log->log_linker }}">view conversation in archive</a>
                      </td></tr>
                    </table>
                  </div>
                </td>
                <td class="log_right">
                  <div class="log_contents">
                    <table>
                      <tr><td>Log recorded on:</td></tr>
                      <tr><td>{{ $log->created_at->diffForHumans() }}</td></tr>
                      <tr><td>{{ date_format($log->created_at, 'l / M dS, y') }}</td></tr>
                    </table>
                  </div>
                </td>
              </tr>
              @elseif($log->log_type == 21 || $log->log_type == 22)
              <?php
                $user = returnUser($log->log_by);
              ?>
              <tr class="">
                  <td class="log_left">
                    <div class="log_contents">
                      <table>
                        <tr><td>{{ $log->log }} @if($log->seen == 0)<span class="label label-danger">new</span>@endif</td>
                      </tr>
                      <tr><td>By:&nbsp;&nbsp;<span class="label label-info">{{ $user->name }}</span></td></tr>
                      <tr><td>
                        <a href="/store/orders/order/{{ $log->log_linker }}">view order</a>
                      </td></tr>
                    </table>
                  </div>
                </td>
                <td class="log_right">
                  <div class="log_contents">
                    <table>
                      <tr><td>Log recorded on:</td></tr>
                      <tr><td>{{ $log->created_at->diffForHumans() }}</td></tr>
                      <tr><td>{{ date_format($log->created_at, 'l / M dS, y') }}</td></tr>
                    </table>
                  </div>
                </td>
              </tr>
              @elseif($log->log_type == 3 || $log->log_type == 31 || $log->log_type == 32 || $log->log_type == 33)
              <?php
                $user = returnUser($log->log_by);
              ?>
              <tr class="">
                  <td class="log_left">
                    <div class="log_contents">
                      <table>
                        <tr><td>{{ $log->log }} @if($log->seen == 0)<span class="label label-danger">new</span>@endif</td>
                      </tr>
                      <tr><td>By:&nbsp;&nbsp;<span class="label label-info">{{ $user->name }}</span></td></tr>
                      <tr><td>
                        <a href="/store/products/product/{{ $log->log_linker }}">view product</a>
                      </td></tr>
                    </table>
                  </div>
                </td>
                <td class="log_right">
                  <div class="log_contents">
                    <table>
                      <tr><td>Log recorded on:</td></tr>
                      <tr><td>{{ $log->created_at->diffForHumans() }}</td></tr>
                      <tr><td>{{ date_format($log->created_at, 'l / M dS, y') }}</td></tr>
                    </table>
                  </div>
                </td>
              </tr>

              @endif
            @empty
            <div class="log_contents">
              No logs, yet.
            </div>
            @endforelse
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>


@endsection