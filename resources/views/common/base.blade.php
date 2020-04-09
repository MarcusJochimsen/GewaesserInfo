<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../../../../favicon.ico">

    <title>
        @if(View::hasSection('water'))
            @yield('water') -
        @endif
        GewässerInfo
    </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/gentelella-custom.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('head')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0; background-color: #EDEDED">
                    <a href="index.html" class="site_title" style="color: #000000 !important;">
                        <img src="{{ asset('images/gewaesserinfo.svg') }}" alt="GewaesserInfo.de Logo" width="40" height="40"> <span>GewässerInfo</span>
                    </a>
                </div>

                <div class="clearfix"></div>

                <br>

                <!-- menu profile quick info -->
                <!--div class="profile clearfix top_search form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div-->
                <!-- /menu profile quick info -->

                <br>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            <li>
                                <a href="{{ url('/') }}"><i class="fas fa-home fa-lg mr-2"></i> Übersicht</a>
                            </li>
                            <li><a><i class="fas fa-water fa-lg mr-2"></i> Gewässer <span class="fas fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{url('water/create')}}">Hinzufügen</a></li>
                                    {{--                                    <li><a href="form_advanced.html">Verwalten</a></li>--}}
                                    {{--                                    <li><a href="form_validation.html">Drucken</a></li>--}}
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars fa-2x"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        @guest
                            <li class="">
                                <a href="{{ route('login') }}" class="user-profile">
                                    Anmelden
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                            </li>
                        @else
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fa fa-sign-out pull-right"></i> Abmelden</a>
                                        {{ Form::model('', ['route' => 'logout', 'id' => 'frm-logout', 'style' => 'display: none;']) }}
                                        {{ Form::close() }}
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            @yield('main')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Tauchergruppe Florian - Freiwillige Feuerwehr Buchholz
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>


<!-- Scripts -->
<script src="{{ asset('js/gentelella-custom.js') }}"></script>

@yield('bottomScripts')

</body>
</html>
