      <div class="shadow">
        <div class="content">
        <br />
         <p class="user_image center"><img src="../../../../uploads/user/pictures/{{Auth::user()->picture}}" class="img-thumbnail shadow" style="height:150px;width:150px" alt="{{ Auth::user()->name }}"></p>
         <hr>
         <p><i class="fa fa-pencil fa-fw"></i> Designer, UI</p>
         <p><i class="fa fa-home fa-fw"></i> {{ $city }}, {{ $state }}</p>
         <p><i class="fa fa-birthday-cake fa-fw"></i> <?php echo date('F jS, Y', strtotime($date));  ?></p>
        </div>
      </div>