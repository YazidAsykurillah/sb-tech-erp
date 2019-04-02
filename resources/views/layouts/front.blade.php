<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BMKN Accounting</title>
    <!-- Font Awesome CSS -->
    {!! Html::style('css/font-awesome/font-awesome.css') !!}

    <!-- Styles -->
    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap/bootstrap.css') !!}
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Landing Page theme CSS -->
    {!! Html::style('css/landing-page.css') !!}

    <style>
        /*body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }*/
        body{
            background:url("../img/intro-bg.jpg");
        }
    </style>
    <!-- Additional styles -->
    @yield('additional_styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="{{ url('/') }}">BMKN Accounting</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                     <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/home') }}"><i class="fa fa-btn fa-dashboard"></i>Back to Dashboard</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    @yield('content')
    <!-- jQuery -->
    {!! Html::script('js/jquery-1.12.4.js') !!}

    <!-- Bootstrap Core JavaScript -->
    {!! Html::script('js/bootstrap/bootstrap.js') !!}
    
    <!-- Additional javascript -->
    @yield('additional_scripts')
    
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
