<!DOCTYPE html>
<html>
@if (Auth::user())
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$store->store_name}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <script src="../../../../../../store_css/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <link rel="stylesheet" href="../../../../../../store_css/admin/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../../../../../store_css/admin/css/style.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../../../../store_css/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../../../../../store_css/admin/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../../../../../store_css/admin/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../../../../../../store_css/admin/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../../../../../../store_css/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../../../../../../store_css/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <script src="../../../../../../store_css/admin/js/ajax.js"></script>
  <script src="../../../../../js/services/pushpad-service-worker.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <?php 
    Pushpad\Pushpad::$auth_token = 'f60cc83fc31cf15d3ba9a72f7d24027e';
    Pushpad\Pushpad::$project_id = "3464";
    $uid = Auth::user()->id;
    $uidSignature = Pushpad\Pushpad::signature_for(Auth::user()->id);
    //dd($uidSignature);
  ?>
  <script>
  (function(p,u,s,h,x){p.pushpad=p.pushpad||function(){(p.pushpad.q=p.pushpad.q||[]).push(arguments)};h=u.getElementsByTagName('head')[0];x=u.createElement('script');x.async=1;x.src=s;h.appendChild(x);})(window,document,'https://pushpad.xyz/pushpad.js');

  pushpad('init', "3464");
  //pushpad('subscribe');
  pushpad('uid', "{{$uid}}", "{{$uidSignature}}");
</script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  @yield('css')
  @yield('jquery')
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="/store" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">{{mb_substr($store->store_name, 0, 1)}}</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">{{$store->store_name}}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <?php $messages = getUnseenMessages(session('store_id')); ?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">{{count($messages)}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{count($messages)}} messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                @forelse($messages as $msg)
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="../../../../uploads/user/pictures/{{$msg->picture}}" class="img-circle" alt="{{$msg->name}}">
                      </div>
                      <h4>
                        {{$msg->suc_title}}
                        <small><i class="fa fa-clock-o"></i> {{diffForHumansShort($msg)}}</small>
                      </h4>
                      <p>{{substr($msg->sucm_message, 0, 35)}}</p>
                    </a>
                  </li>
                  <!-- end message -->
                  @empty
                  <li>No new messages</li>
                  @endforelse
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <?php 
            $notifications = getStoreNotifications($store->store_id);
          ?>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{ count($notifications['unseen']) }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{ count($notifications['unseen']) }} unseen notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                @forelse($notifications['unseen'] as $notification)
                  <li class="unseen">
                      {!! $notification !!} &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-o text-aqua"></i>
                  </li>
                  <hr />
                @empty
                  <li>No unseen notifications, yet. <i class="fa fa-circle-o text-aqua"></i></li>
                @endforelse
                
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a>
              <a href="/store/notifications/action/" class="send_ajax" id="{{ session('store_id') }}">mark as seen (all)</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          @if(\Session::get('privilege') == "Owner" || \Session::get('privilege') == "owner")
          <?php
            $logs = getStoreLogs(session('store_id'));
            $count_logs = count($logs);
          ?>
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">{{ $count_logs }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{ $count_logs }} logs</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                @forelse($logs as $log)
                  <li><!-- Task item -->
                    <a href="/store/logs/log/{{ $log->sl_id }}">
                      <h3>
                        {{ $log->log }}
                        <small class="pull-right">{{ $log->created_at->diffForHumans() }}</small>
                      </h3>
                    </a>
                  </li>
                @empty
                <li>No new logs.</li>
                @endforelse
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="/store/logs/">View all logs</a>
                <a class="send_ajax" href="/store/logs/action/" id="{{ session('store_id') }}">mark as seen (all)</a>
              </li>
            </ul>
          </li>
          @endif
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="/home" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../../uploads/user/pictures/{{ Auth::user()->picture }}" class="user-image" alt="{{ Auth::user()->name }}">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../../uploads/user/pictures/{{ Auth::user()->picture }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->name }}
                  <small>Member since {{ Auth::user()->created_at->diffForHumans() }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/user/home" class="btn btn-default btn-flat">Home</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/user/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../../uploads/user/pictures/{{ Auth::user()->picture }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
        </div>
      </div>
      <!-- search form -->
      <a href="/">&nbsp;<img src="../../../../uploads/flashcart/logo/Flashcart.png" width="50" />&nbsp;&nbsp; Go to FlashCart</a>

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
		    <li>
          <a href="/store">
            <i class="fa fa-home"></i><span>Home</span>
          </a>
        </li>
        <li>
          <a href="/store/conversations">
            <i class="fa fa-envelope"></i><span>Conversations</span>
          </a>
        </li>
        <li>
          <a href="/store/messages">
            <i class="fa fa-envelope"></i><span>Direct Messages</span>
          </a>
        </li>
      <li class="header">ORDERS</li>
      <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Orders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/store/orders/"><i class="fa fa-circle-o"></i>All Orders</a></li>
          </ul>
        </li>
      	@include('store.static.sidemenu')

        <!--<li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>

        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
      -->

        <!--<li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>-->
        <li class="header">SERVICES</li>
        <li>
          <a href="/store/logs"><i class="fa fa-flag"></i> <span>Logs</span></a>
        </li>
        @yield('store-navigation')

        @if(\Session::get('privilege') == "Owner" || \Session::get('privilege') == "owner")
            @include('store.static.employment-sidemenu')
            @include('store.static.settingmenu')
        @endif
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red notifier check"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-green notifier success"></i> <span>Success</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua notifier"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('store-view')
        <small>@yield('store-subview')</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/store"><i class="fa fa-home"></i>Home</a></li>
        @yield('store-breadcrumb')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     	@yield('store-biginfo')
      <!-- Main row -->
      <div class="row">
      	@yield('store-successcontent')
		@yield('store-alertcontent')
        @yield('store-content')     
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2017 <a href="http://flashcart.com.pk">FlashCart</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->

<!-- jQuery UI 1.11.4 -->
<script src="../../../../../../store_css/admin/plugins/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="../../../../../../store_css/admin/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../../../../../../store_css/admin/plugins/raphael-min.js"></script>
<script src="../../../../../../store_css/admin/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="../../../../../../store_css/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../../../../../../store_css/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../../../../../../store_css/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../../../../../store_css/admin/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="../../../../../../store_css/admin/plugins/moment.min.js"></script>
<script src="../../../../../../store_css/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../../../../../../store_css/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../../../../../../store_css/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../../../../../../store_css/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../../../../../store_css/admin/plugins/fastclick/fastclick.js"></script>
<script src="../../../../../../store_css/admin/dist/js/app.min.js"></script>

<script src="../../../../../../store_css/admin/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../../../../store_css/admin/dist/js/demo.js"></script>

  @else
        <strong>You are not authorized to this page.</strong>
    @endif
</body>
</html>
