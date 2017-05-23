@extends('layouts.store', ['store'=>$store])

@section('store-title')
{{ $store->store_name }} - Employees
@endsection

@section('store-view')
Employment Area
@endsection
@section('store-subview')
All Requests
@endsection

@section('store-breadcrumb')
<li><a href="/store/employment">Employment Area</a></li>
<li>All Requests</li>
@endsection

@section('store-alertcontent')
@if($errors->any())
  <div class="container">
    <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>NOTE!</strong>  
        {!! $errors->first('category_check') !!}
        {!! $errors->first('privilege_check') !!}
    </div>
  </div>
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
  @endif
@endsection

@section('store-content')
<section class="col-lg-8">
  <div class="box box-default">
    <div class="box-header"><div class="box-title">Requests</div></div>
      <div class="box-body">
        <ul class="list-group">
          @forelse($employment_list as $proposal)
            <a href="#" class="view_proposal_anchor"><li class="list-group-item view_proposal" id="{{ $proposal->user_id }}"><strong>{{ $proposal->name }}</strong> requesting at <strong>{{ number_format($proposal->salary) }} Rs.</strong> - {{ $proposal->created_at->diffForHumans() }}</li></a>
          @empty
            <li>You currently have no requests.</li>
          @endforelse
        </ul>
      </div>
  </div>
</section>

<section class="col-lg-4">
  <div class="box box-default">
    <div class="box-header">
      <div class="box-title">Proposal Details</div>
    </div>
    @foreach($employment_list as $proposal)
      <div class="box-body proposal" id="details-{{ $proposal->user_id }}">
        <div class="container ">
          <div class="row ">
            <div class="col-xs-12 col-sm-6 col-md-6 ">
              <div class="">
                <div class="row ">
                  <div class="col-sm-6 col-md-3 ">
                    <img src="/uploads/user/pictures/{{ $proposal->picture }}" alt="{{ $proposal->name }}" class=" img-responsive" />
                  </div>
                  <div class="col-sm-3 col-md-8 ">
                    <h4 class="">
                      {{ $proposal->name }}
                    </h4>
                    <p>
                      {{ $proposal->email }}
                      <br />
                      Salary: Rs {{ number_format($proposal->salary) }}.
                      <br />
                      <!-- Split button -->
                      <div class="btn-group">
                        <a href="/store/employment/proposal/{{ $proposal->proposal_id }}" class="btn btn-primary">View Proposal</a>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span><span class="sr-only">QA</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="/store/employment/proposal/{{$proposal->proposal_id}}">View Proposal</a></li>
                          <li class="divider" ></li>
                          <li><a href="/store/employment/proposal/{{$proposal->user_id}}/{{$proposal->proposal_id}}/{{$proposal->store_id}}/action/accept">Accept</a></li>
                          <li><a href="/store/employment/proposal/{{$proposal->user_id}}/{{$proposal->proposal_id}}/{{$proposal->store_id}}/action/decline">Decline</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>
@endsection

@section('jquery')
<script>
  $(document).ready(function()
  {
    $(".view_proposal").click(function(e)
    {
      e.preventDefault();
      $(".proposal").slideUp(100);
      var id = $(this).attr('id');
      $("#details-"+id).slideDown(200);
    });
  });
</script>
@endsection