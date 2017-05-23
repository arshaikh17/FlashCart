@extends('layouts.store', ['store'=>$store])

@section('store-title')
{{ $store->store_name }} - Build Layout
@endsection

@section('store-view')
Layout
@endsection
@section('store-subview')

@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li><a href="/store/settings/layout">Personalization</a></li>
<li>Build Layouts</li>
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
<section class="col-lg-12">
  <div class="box box-default">
    <div class="box-header" data-target="#intro" data-toggle="collapse"><div class="box-title ">Building Store's Layouts</div></div>
    <div id="intro" class=" collapse in">
      
      
      <div class="box-body" >
        <p>This is where you build your store's layout. How you shop or store would look depends on how you customize it. Make sure you have enough time to build. Store/Shop's looks determine the customer interests. Every panel every section should have consistency, if there are different or unmatching styles in your store/shop it is more likely customer would not feel good or gets confused.</p>
        <p>There are a lot of different designs on each section. And more features are yet to come in future. So build up and start selling. :)</p>
        <p>Good Luck!</p>
      </div>
    </div>
  </div>
</section>


<section class="col-lg-12 design-layout">
  
  <h1>Layout</h1>
  <div class=" row">
    <div class="col-lg-4">
      <div class="box box-default">
        <div class="box-header"  data-target=".layout" data-toggle="collapse"><div class="box-title">Layout</div></div>
        <div class="collapse layout">
          <div class="box-body">
            <form method="POST" action="/store/settings/layout/save/layout">
            {{ csrf_field() }}
            <select class="form-control" name="layout">
              @forelse($layouts as $layout)
              <option value="{{ $layout->layout_id }}"> {{$layout->layout_name}} </option>
              @empty
              <option selected disabled> No layouts </option>
              @endforelse
            </select>
            <br />
              
            <input type="submit" value="Save" class="btn btn-primary pull-right" />

            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="box box-default">
        <div class="box-header"  data-target=".layout" data-toggle="collapse"><div class="box-title">Preview</div></div>
        <div class="collapse layout" id="layoutDet">
          <div class="box-body">
            <div class="collapse in layout_preview">
              <div class="container">
                
                <div class="row">
                  <div class="navbar-layout header-navbar-layout hoverable layout-item">
                    <div class="layout-content">
                      Header/Navbar
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="left-panel-1-layout hoverable menu-layout layout-item side-panel col-xs-1">
                    Categories/ <br/> Sales
                  </div>
                  <div class="col-xs-2 right-panel-1-layout hoverable products-layout side-panel layout-item">
                    Products Area
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="box box-default">
        <div class="box-header"  data-target=".layout" data-toggle="collapse"><div class="box-title">Information</div></div>
        <div class="collapse layout" id="layoutDetInfo">
          <div class="box-body stay-inside">
            <div class="collapse in layout_preview">
              <p id="detContent">Hover at any preview section for details.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="col-lg-12 design-layout">
  
  <h1>Header/Navbar/Main Menu</h1>
  <div class=" row">
    <div class="col-lg-4">
      <div class="box box-default">
        <div class="box-header"  data-target=".header-navbar" data-toggle="collapse"><div class="box-title">Headers/Navbars</div></div>
        <div class="collapse header-navbar">
          <div class="box-body">
            <form method="POST" action="/store/settings/layout/save/header">
            {{ csrf_field() }}
            <select class="form-control" name="header" id="header_options">
              <option disabled selected> Select from options </option>
              @forelse($headers as $header)
              <option value="{{ $header->header_id }}"> {{$header->header_name}} </option>
              @empty
              <option selected disabled> No headers </option>
              @endforelse
            </select>
            <br />
              
            <input type="submit" value="Save" class="btn btn-primary pull-right" />

            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="box box-default">
        <div class="box-header"  data-target=".header-navbar" data-toggle="collapse"><div class="box-title">Preview</div></div>
        <div class="collapse header-navbar" id="headerDet">
          <div class="box-body">
            <div class="collapse in layout_preview" id="header_preview">
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="box box-default">
        <div class="box-header"  data-target=".header-navbar" data-toggle="collapse"><div class="box-title">Information</div></div>
        <div class="collapse header-navbar" id="headerDetInfo">
          <div class="box-body stay-inside">
            <div class="collapse in layout_preview">
              <p id="hDetContent" class="iterative_hdet">Hover at any preview section for details.</p>
              @foreach($headers as $header)
                <div id="hDetContent_{{ $header->header_id }}" class="iterative_hdet" style="display:none;">{!! $header->header_description !!}</div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function()
  {
    $("#header_options").change(function()
    {
      var id = $(this).val();
      var div = $("#header_preview");
      div.empty();
      div.append("<a href='../../../../uploads/service/headers/header-"+id+".png'><img src='../../../../uploads/service/headers/header-"+id+".png' class='img-responsive' /></a>");
      $(".iterative_hdet").slideUp(50);
      $("#hDetContent_"+id).slideDown(200);
    });
    $(".hoverable").mouseenter(function()
    {
      var p = $("#detContent");
      p.empty();
      if($(this).hasClass("header-navbar-layout"))
      {
        p.text("This is a header section where your navigation is located. Search bar, menu, categories and sales. It also contains the brandmark of your shop/store. The placement of header on preview shows where your header will be placed in html.");
      }
      if($(this).hasClass("menu-layout"))
      {
        p.text("This is a menu section where your categories, as well as, sales are shown both 'separately'. Display of sub categories depends on the design of the category and sale design you choose. The placement of menu on preview shows where your category and sale sections will be placed in html.");
      }
      if($(this).hasClass("products-layout"))
      {
        p.text("This is a products section where your products will be displayed. Products displayed can be through searching or can also be through category search. Display of sub categories depends on the design of the category and sale design you choose. The placement of products on preview shows where your category and sale sections will be placed in html.");
      }
    });
    $(".hoverable").mouseleave(function()
    {
      $("#detContent").empty();
      $("#detContent").text("Hover at any preview section for details.");
    });
  });
</script>

<style>
.design-layout
{
  padding-bottom: 10px;
  border-bottom: 4px solid lightgrey;

}
.stay-inside
{
  white-space: normal;
}
.hoverable:hover
{
  border: 2px solid grey;
  background-color: grey;
}
.layout-item
{
    background-color: lightgrey;
    border: 1px solid lightgrey;
    margin-bottom: 3px;
    margin-left: 3px;
}
  .navbar-layout
  {
    padding-top: 10px;
    padding-bottom: 10px;

    width: 300px;
  }
  .left-panel-1-layout
  {
    min-width: 65px;
  }
  .right-panel-1-layout
  {
    min-width: 130px;
  }
  .layout-content
  {
    margin-left: 20px;
  }
  .side-panel
  {
    padding-top: 50px;
    padding-bottom: 50px;
  }
</style>
@endsection