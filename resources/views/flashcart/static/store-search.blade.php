<div class="jumbotron text-center">
  <h1>FlashCart</h1> 
  <p>We specialize in blablabla</p> 
  <form action="/employ/search">

    <div class="input-group container">
      <div class="row">
        <div class="col-md-9">
          <input type="text" name="store" class="form-control" value="{{$search}}" placeholder="Enter Store name, email or username. Don't forget to pick respective filter" id="store-text" />
          
        </div>
        <div class="col-md-2">
          <select class="form-control" name="filter" id="search-filters" required>
            <option disabled selected>Select store filter.</option>
            <option value="all">All Stores</option>
            <option value="name">By Name</option>
            <option value="email">By Email</option>
            <option value="username">By Username</option>
          </select>
        </div>
        <div class="input-group-btn col-md-1">
          <input type="submit" class="btn btn-danger" value="Search" />
        </div>
      </div>
      
    </div>
  </form>
</div>

@section('jquery')
<script>
var getUrlParameter = function getUrlParameter(sParam) 
{
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) 
    {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) 
        {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).ready(function()
{
  var filter = getUrlParameter('filter');
  var filter_val = $("#search-filters").val();
  $(function(){

  $("#search-filters").change(function(){
    var filter_val = $(this).val();
    if(filter_val == "all"){
      $("#store-text").attr("disabled", "disabled");
    }
    else{
      $("#store-text").removeAttr('disabled');
    }
  });
  
});
  $("#search-filters").val(filter).trigger('change');
});
</script>
@endsection