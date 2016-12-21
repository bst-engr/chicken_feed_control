<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@section('title') 
            @show </title>

    <link href="{{asset('css/jquery-ui.min.css') }}" rel="stylesheet">
   <!-- Bootstrap Core CSS -->
    <link href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset('bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/datatables-responsive/css/dataTables.responsive.css')}}">
 
    
    <link rel="stylesheet" href="{{asset('css/pnotify.custom.min.css') }}">
    <link href="{{asset('css/datepicker.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/plugins/summernote.css') }}">

    <!-- Timeline CSS -->
    <link href="{{asset('dist/css/timeline.css')}}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('dist/css/sb-admin-2.css')}}" rel="stylesheet">
    <style type="text/css">
        label.error{color:red;}
    </style>
    <!-- Morris Charts CSS -->
    <link href="{{asset('bower_components/morrisjs/morris.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{asset('bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>   
    <script src="{{ asset('js/pnotify.custom.min.js') }}"></script>
    <script src="{{ asset('js/plugins/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/plugins/summernote.min.js') }}"></script>
    <script src="{{asset('bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
   
    <!-- Morris Charts JavaScript -->
    <!-- <script src="{{asset('bower_components/raphael/raphael-min.js')}}"></script>
    <script src="{{asset('bower_components/morrisjs/morris.min.js')}}"></script>
    <script src="{{asset('js/morris-data.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{asset('dist/js/sb-admin-2.js')}}"></script>

    @yield('header')
    <script type="text/javascript">
    
    //function used to autocomplete fields for boards
    // New selector
    jQuery.expr[':'].Contains = function(a, i, m) {
    return jQuery(a).text().toUpperCase()
    .indexOf(m[3].toUpperCase()) >= 0;
    };
     
    // Overwrites old selecor
    jQuery.expr[':'].contains = function(a, i, m) {
    return jQuery(a).text().toUpperCase()
    .indexOf(m[3].toUpperCase()) >= 0;
    }; 

    $(document).ready(function() {
        $.ucfirst = function(str) {
            var text = str;


            var parts = text.split(' '),
                len = parts.length,
                i, words = [];
            for (i = 0; i < len; i++) {
                var part = parts[i];
                var first = part[0].toUpperCase();
                var rest = part.substring(1, part.length);
                var word = first + rest;
                words.push(word);

            }

            return words.join(' ');
        };
    });

    </script>

</head>

<body {{ (Sentry::check()) ? "" : "class=page-wrapper-body" }}>

    <div id="{{ (Sentry::check()) ? "wrapper" : "wrapper-login" }}">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" style="margin-bottom:0px;" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{action('DashboardController@index')}}">Roomi Farms</a>
                 <!-- <ul class="nav navbar-nav ">
                    if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
                        <li {{ (Request::is('users*') ? 'class="active"' : '') }}><a href="{{ action('\\Sentinel\Controllers\UserController@index') }}">Users</a></li>
                        <li {{ (Request::is('groups*') ? 'class="active"' : '') }}><a href="{{ action('\\Sentinel\Controllers\GroupController@index') }}">Groups</a></li>
                    endif
                  </ul> -->
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-top-links navbar-right">
                
                @if (!Sentry::check())
                    <li {{ (Request::is('login') ? 'class="active"' : '') }}><a href="{{ route('sentinel.login') }}">Login</a></li>      
                @else
                 @if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
                    <li {{ (Request::is('users*') ? 'class="active"' : '') }}><a href="{{ action('\\Sentinel\Controllers\UserController@index') }}">Users</a></li>
                    <li {{ (Request::is('groups*') ? 'class="active"' : '') }}><a href="{{ action('\\Sentinel\Controllers\GroupController@index') }}">Groups</a></li>
                @endif 
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" style="margin-right:10px"></i>{{ Sentry::getUser()->first_name }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <!-- <li>
                            <a href="/password/reset/{{Session::getToken()}}"><i class="fa fa-fw fa-user"></i> Change Password</a>
                        </li> -->
                        <li>
                            <a href="{{ route('sentinel.profile.show') }}">My Account</a>
                        </li>
                        <li class="divider"></li>
                       <li>
                        <a href="{{ route('sentinel.logout') }}">Logout</a>
                    </li>
                    </ul>
                </li>
                @endif
            </ul>
            @if (Sentry::check())
                @include('layouts/leftsidebar')
            @endif
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="page-header">
                            @yield('page_title')
                            <small>@yield('sub_page_title')</small>
                        </h1>
                        <!-- <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol> -->
                    </div>
                </div>
                <!-- /.row -->
                <!-- Notifications -->
                @include('layouts/notifications')
                <!-- ./ notifications -->

                <!-- Content -->
                @yield('content')
                <!-- ./ content -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script type="text/javascript">
    function getvalidUrl(action, param){
        var url;
        $.ajax({
          type: "POST",
          url: '{{route("getUrl")}}',
          async: false,
          data: {'action':action, 'param': param, '_token': "{{ Session::getToken() }}"}
        })
        .done(function( response ) {
            url = response;
        });
        return url;

    }
    </script>

</body>

</html>
