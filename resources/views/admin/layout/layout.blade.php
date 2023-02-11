
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
 <link rel="icon" href="{{asset('images/logo.png')}}" />
 <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

  
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet"   href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/waitMe.css')}}" />
 

  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"> -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
 <style type="text/css">

  

  .sidebar-dark-orange .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-orange .nav-sidebar>.nav-item>.nav-link.active
  {
    background-color: #e35425;
    color: #ffffff;
  }


 

  .logo{
  margin-right:auto;
  display:block;
  margin-left:auto;
  width:50%;
}
  </style>

  
  @yield('header-script')
</head>
<body class="hold-transition sidebar-mini layout-fixed" id="container">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('images/logo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    
       <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
         <li class="nav-item">
          <div>
            
        </div>
      </li>

      <li class="nav-item">
            <div>
              <a class="dropdown-item" href="{{route('profile')}}" >
                Profile
              </a>
            </div>
      </li>

      <li class="nav-item">
          <div>
            <a class="dropdown-item" href="{{ route('logouts') }} ">
                {{ __('Logout') }}
            </a>
           </div>
      </li>

      
     
    </ul>

    @yield('navbar-section')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('admin/dashboard')}}" class="brand-link">
      <img class="logo" src="{{asset('images/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <!-- <span class="brand-text font-weight-light">Admin Panel</span> -->
      <!-- <span class="brand-text font-weight-light">Admin Panel</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
     

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item @if(Route::currentRouteName() == 'dashboard') menu-open @endif">
            <a href="#" class="nav-link @if(Route::currentRouteName() == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link @if(Route::currentRouteName() == 'dashboard') active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
             </ul>
          </li>

          
          <li class="nav-item @if(Route::currentRouteName() == 'view-user' || Route::currentRouteName() == 'users.index' || Route::currentRouteName() == 'users.edit' || Route::currentRouteName() == 'users.show' || Route::currentRouteName() == 'users.create' || Route::currentRouteName() == 'view-manager' || Route::currentRouteName() == 'view-employee' || Route::currentRouteName() == 'employee-detail' ) menu-open @endif">
            <a href="#" class="nav-link @if(Route::currentRouteName() == 'view-user' || Route::currentRouteName() == 'users.index' || Route::currentRouteName() == 'users.edit' || Route::currentRouteName() == 'users.show' || Route::currentRouteName() == 'view-manager' || Route::currentRouteName() == 'view-employee' || Route::currentRouteName() == 'employee-detail' || Route::currentRouteName() == 'users.create') active @endif">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('create-user')
              <li class="nav-item">
                <a href="{{route('users.create')}}" class="nav-link @if(Route::currentRouteName() == 'users.create' ) active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create User</p>
                </a>
              </li>
            @endcan  

              @can('user-list')
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link @if(Route::currentRouteName() == 'users.index') active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              @endcan
              @can('view-manager')
              <li class="nav-item">
                <a href="{{ route('view-manager') }}" class="nav-link @if(Route::currentRouteName() == 'view-manager'  || Route::currentRouteName() == 'employee-detail') active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Managers</p>
                </a>
              </li>
              @endcan

              @can('view-employee')
              <li class="nav-item">
                <a href="{{ route('view-employee') }}" class="nav-link @if(Route::currentRouteName() == 'view-employee') active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Employees</p>
                </a>
              </li>
              @endcan

           </ul>
          </li>
          
          
          @can('role-list')
          <li class="nav-item @if(Route::currentRouteName() == 'roles.index' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.show' || Route::currentRouteName() == 'roles.edit') menu-open @endif">
            <a href="#" class="nav-link @if(Route::currentRouteName() == 'roles.index' || Route::currentRouteName() == 'roles.create' || Route::currentRouteName() == 'roles.show' || Route::currentRouteName() == 'roles.edit') active @endif">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Role Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
           
              <li class="nav-item">
                <a href="{{route('roles.index')}}" class="nav-link @if(Route::currentRouteName() == 'roles.index' ) active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Role</p>
                </a>
              </li>
            
           </ul>
          </li>
          @endcan
         
          @can('store-list')
          <li class="nav-item @if(Route::currentRouteName() == 'view-store' || Route::currentRouteName() == 'assign-store' || Route::currentRouteName() == 'store-detail' || Route::currentRouteName() == 'view-event' ) menu-open @endif">
            <a href="#" class="nav-link @if(Route::currentRouteName() == 'view-store' || Route::currentRouteName() == 'assign-store' || Route::currentRouteName() == 'store-detail' || Route::currentRouteName() == 'view-event') active @endif">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Store Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('store-list')
              <li class="nav-item">
                <a href="{{route('view-store')}}" class="nav-link @if(Route::currentRouteName() == 'view-store' ) active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View store</p>
                </a>
              </li>
            @endcan
            
            @can('assign-store')
            <li class="nav-item">
                <a href="{{route('assign-store')}}" class="nav-link @if(Route::currentRouteName() == 'assign-store' ) active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Assign store</p>
                </a>
              </li>
            @endcan

            <li class="nav-item">
                <a href="{{route('view-event')}}" class="nav-link @if(Route::currentRouteName() == 'view-event' ) active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View event</p>
                </a>
            </li>

           </ul>
          </li>
         @endcan 

         @can('inventory-list')
          <li class="nav-item @if(Route::currentRouteName() == 'view-inventory' || Route::currentRouteName() == 'total-sell-bottels' ) menu-open @endif">
            <a href="#" class="nav-link @if(Route::currentRouteName() == 'view-inventory' || Route::currentRouteName() == 'total-sell-bottels') active @endif">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Inventory Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            @can('inventory-list')
              <li class="nav-item">
                <a href="{{route('view-inventory')}}" class="nav-link @if(Route::currentRouteName() == 'view-inventory' ) active  @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View inventory</p>
                </a>
              </li>
           @endcan
            
           
           </ul>
          </li>
        @endcan  

         </ul>
        </li>
      </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
   @yield('sider-section')
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
    <!-- /.content -->
   @yield('body-section')
  </div>
  
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020-<?php echo date('Y') ?> <a href="{{route('dashboard')}}"></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <!-- <b>Version</b> 3.1.0 -->
      
    </div>
    @yield('footer-section')
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<div class="script_section">
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)

   setTimeout(function(){
       $("div.alert").fadeOut(4000);
    }, 500 )
</script>
<!-- Bootstrap 4 -->



<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<!-- <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script> -->
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{asset('dist/js/pages/dashboard.js')}}"></script> -->
<script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>


<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/toastr.min.js')}}"></script>

<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>


<script>
   var type = "{{ Session::get('type') }}";
      switch (type) {
          case 'success':
              toastr.success("{{ Session::get('message') }}");
              break;

          case 'error':
              toastr.error("{{ Session::get('message') }}");
              break;

      }


      var current_effect ='bounce';
      function full_page()
      {
        $('.placeOrd').waitMe({
          effect : 'bounce',
          text : '',
          bg : 'rgba(255,255,255,0.7)',
          color : '#000',
          maxSize : '',
          waitTime : -1,
          textPos : 'vertical',
          fontSize : '',
          source : '',
          onClose : function() {}
          });
      }
</script>




@yield('footer-script')




</div>
</body>
</html>
