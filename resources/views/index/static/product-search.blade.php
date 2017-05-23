
  <form action="/{{$store_username}}/products/search/">

    <div class="input-group container">
      <input type="text" name="product" class="form-control" value="{{$search}}" placeholder="Search from {{$store_name}}" />
      <div class="input-group-btn">
        <input type="submit" class="btn btn-danger" value="Search" />
      </div>
    </div>
  </form>