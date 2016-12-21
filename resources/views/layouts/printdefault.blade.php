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

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{asset('css/styles.css') }}" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="{{asset('js/jquery.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('js/bootstrap.min.js') }}"></script>

    @yield('header')

</head>

<body>

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    @yield('page_title')
                    <small>@yield('sub_page_title')</small>
                </h1>
                
            </div>
        </div>
        <!-- /.row -->

        <!-- Content -->
        @yield('content')
        <!-- ./ content -->
    </div>
    <!-- /.container-fluid -->

    <p class="text-center">&copy; SSG Factory. Nextbridge (PVT) LTD</p>


</body>

</html>
