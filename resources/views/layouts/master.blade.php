<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
      @hasSection ('title')
          @yield('title') - {{env('APP_NAME')}}
      @else
          {{ env('APP_NAME') }}
      @endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="{{$themeAssets}}/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="{{$assets}}/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{$assets}}/plugins/toaster/jquery.toast.css">
    <link rel="stylesheet" href="{{$assets}}/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="{{$assets}}/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="{{$assets}}/plugins/chosen/chosen.css">
    <link rel="stylesheet" href="{{$themeAssets}}/custom.min.css">

    @yield('custom-style')
    <link rel="stylesheet" href="{{$assets}}/custom.css">
  </head>
  <body>

  <!-- BEGAIN AJAXLOADER -->
  <div id="ajaxloader" class="hide">
      <div id="status">&nbsp;</div>
  </div>
  <!-- END AJAXLOADER -->

    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="{{url('home')}}" class="navbar-brand">{{env('APP_NAME')}}</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          @if (Auth::check())
          <ul class="nav navbar-nav">
            <li><a href="{{url('home')}}">Dashboard</a></li>

            @if(isSuperAdmin() || isAdmin()){
            <li><a href="{{url('owner-dashboard')}}">Owner Dashboard</a></li>
            @endif

            @if(isDepartmentAdmin())
            <li><a href="{{url('department-owner-dashboard')}}">Owner Dashboard</a></li>
            @endif

            <li><a href="{{ url('task-manager') }}">Task Manager</a></li>
            @if(isSuperAdminOrAdminOrDepartmentAdmin())
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    Master <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    @if(isSuperAdmin())
                        <li><a href="{{url('companies')}}">Companies</a></li>
                    @endif
                    @if(isSuperAdminOrAdmin())
                        <li><a href="{{url('branches')}}">Branches</a></li>
                        <li><a href="{{url('departments')}}">Departments</a></li>
                        <li><a href="{{url('bulk-departments')}}">Bulk Dept. Creation</a></li>                        
                    @endif
                    <li><a href="{{url('designations')}}">Designations</a></li>
                    <li><a href="{{url('employees/list')}}">Employees</a></li>
                    <li><a href="{{url('task-roles')}}">Task Roles</a></li>
                    <li><a href="{{url('tasks')}}">Tasks</a></li>
                    <li><a href="{{url('tasks-bulk-create')}}">Bulk Tasks Creation</a></li>
                    {{--  
                    <li><a href="{{url('employee-tasks')}}">Assign Task</a></li>
                    <li><a href="{{url('frequencies')}}">Frequencies</a></li>
                    --}}
                    <li><a href="{{url('employee-task-allocation')}}">Task Allocation</a></li>
                    @if(isSuperAdminOrAdmin())
                        <li><a href="{{url('settings')}}">Settings</a></li>
                    @endif
                </ul>
            </li>

            @endif

            @php 
                $dashboardMenu = getDashboardPermission();
            @endphp
            
            @if($dashboardMenu)
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">Others
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if(!empty($dashboardMenu['branche_menu']))
                          <li class="dropdown-submenu">
                            <a class="test"href="#">Branch Dashboard <span class="caret caret-right"></span></a>
                            {!! $dashboardMenu['branche_menu'] !!}
                          </li>
                        @endif

                        @if(count($dashboardMenu) > 1)
                            <li role="presentation" class="divider"></li>
                        @endif

                        @if(!empty($dashboardMenu['department_menu']))
                            <li class="dropdown-submenu">
                                <a class="test" href="#">Department Dashboard <span class="caret caret-right"></span></a>
                                {!! $dashboardMenu['department_menu'] !!}
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            {{--  
            @if(isEmployee())
                <li><a href="{{url('task-management')}}">Task Management</a></li>
            @endif
            --}}

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    Report <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                  <li><a href="{{url('reports/todo')}}">Todo Report</a></li>
                  <li><a href="{{url('reports/target-achievement')}}">Target Achievement Report</a></li>
                </ul>
            </li>
          </ul>
          @endif

          <ul class="nav navbar-nav navbar-right">
            @if (Auth::check())
                
                <li class="dropdown notifications-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-danger">{{ !empty($notifications) && $notifications->count() ? $notifications->count(): '' }}</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li class="header">You have {{!empty($notifications) && $notifications->count() ? $notifications->count(): 'no'}} notification(s)</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      @if(!empty($notifications) && $notifications->count())
                      <ul class="menu">
                        @foreach($notifications as $notification)
                        <li>
                          <a href="{{url('todo/'.$notification->resource_id.'?notification_id='.$notification->id)}}">
                            <i class="fa fa-info-circle text-muted"></i> {{ $notification->title }}
                          </a>
                        </li>
                        @endforeach
                      </ul>
                      @endif
                    </li>
                    @if(!empty($notifications) && $notifications->count())
                    <li class="footer"><a target="_blank" href="{{ url('notifications') }}">View all</a></li>
                    @endif
                  </ul>
                </li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->employee ?  Auth::user()->employee->full_name : Auth::user()->username }} ({{ config('constants.role.'.Auth::user()->role) }}) <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                      <li><a href="{{ url('/users/profile') }}"><i class="fa fa-btn fa-user"></i> Profile</a></li>
                      @if(isAdmin())
                        <li><a href="{{ url('/my-company') }}"><i class="fa fa-btn fa-building"></i> My Company</a></li>
                      @endif
                      <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                      <li class="divider"></li>
                      <li><a>Last Login: {{session()->get('lastLogin', Auth::user()->last_login->format('d M, Y @ h:i:s A'))}}</a></li>
                    </ul>
                </li>
            @endif
          </ul>
        </div>
      </div>
    </div>


    <div class="container">
        @if((Auth::check() && !isSuperAdmin()) || (Auth::check() && isSuperAdmin() && Request::is('employee-dashboard*')))

            @if(Request::is('employee-dashboard*'))
                @php
                    $user = $employee->user
                @endphp
            @else
                @php
                    $user = Auth::user();
                    $employee = $user->employee;
                @endphp
            @endif

            <div class="user-info row margin-bottom-20">
                <div class="col-md-7">
                    <h2><strong>{{ $user->company->title }}</strong></h2>
                    <p>{{ $user->company->address }}</p>
                </div>
                <div class="col-md-5 margin-top-20">
                    <div class="row">
                        <div class="col-sm-3">
                            <img class="profile-photo" src="{{ @getimagesize(url($employee->photo)) ? url($employee->photo) : $assets.'/images/avatar/dummy_profpic.jpg' }}" alt="{{ $employee->full_name }}" class="img-responsive">
                        </div>
                        <div class="col-sm-9"> 
                            <div class="details-info">
                                <strong>Name: </strong>{{ $employee->full_name }}
                                <br>
                                <strong>Department: </strong>{{ $employee->department->title }}
                                <br>
                                <strong>Designation: </strong>{{ $employee->designation->title }}
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
        @endif

        @if(!empty($total_todo_lists_today))
        <div class="alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <a class="alert-link" href="{{ url('task-manager') }}"><i class='fa fa-info-circle'></i> You have {{ $total_todo_lists_today }} pending tasks. </a>
        </div>
        @endif
        
        @yield('content')

        @include('global_modal')
        <footer>
            <div class="row">
              <div class="col-lg-12">
                <ul class="list-unstyled">
                  <li class="pull-right">&copy; {{Carbon::now()->format('Y')}} {{env('APP_NAME')}}. All rights reserved.</li>
                </ul>
                <p>Made with <a href="#" rel="nofollow"><i style="color:red;" class="fa fa-heart-o"></i></a> | <small>{{app_build_info()}}</small></p>
              </div>
            </div>
        </footer>
    </div>
    <script src="{{$themeAssets}}/jquery.min.js"></script>
    <script src="{{$themeAssets}}/bootstrap.min.js"></script>
    <script src="{{$assets}}/plugins/toaster/jquery.toast.js"></script>
    <script src="{{$assets}}/plugins/daterangepicker/moment.js"></script>
    <script src="{{$assets}}/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{$assets}}/plugins/chosen/chosen.jquery.min.js"></script>
    <script src="{{$assets}}/plugins/datepicker/bootstrap-datepicker.js"></script>

    <!-- Theme's Custom Script-->
    <script src="{{$themeAssets}}/custom.js"></script>

    <!-- Custom Script-->
    <script src="{{$assets}}/custom.js"></script>

    @yield('custom-script')

    @if(session()->has('toast'))
        <?php
        $toast = session()->get('toast');
        $message = $toast['message'];
        $type = $toast['type'];
        ?>
        <script>
            toastMsg("{!! $message !!}","{{ $type }}");
        </script>
    @endif
  </body>
</html>
 