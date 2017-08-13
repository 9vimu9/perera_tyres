<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>



    <!-- Styles -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-2.2.4/dt-1.10.15/af-2.2.0/b-1.3.1/b-colvis-1.3.1/b-print-1.3.1/cr-1.3.3/r-2.1.1/rr-1.2.0/sc-1.4.2/datatables.min.css"/> --}}
    <link href="{{ asset('css/libries/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/libries/select2.min.css') }}" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/libries/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

    <link href='https://fullcalendar.io/js/fullcalendar-3.4.0/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://fullcalendar.io/js/fullcalendar-3.4.0/fullcalendar.print.min.css' rel='stylesheet' media='print' />


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-static-top ">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <strong><big>PTS |</big></strong>  payroll
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">

                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                              EMPLOYEES<span class="caret"></span>
                          </a>
                          <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="#">add employee</a>
                              </li>
                          </ul>
                      </li>


                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
      {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

      {{-- <script src="{{ asset('js/libries/jquery.min.js') }}"></script> --}}
      <script src="{{ asset('js/libries/jquery-2.2.4.min.js') }}"></script>

<script src="{{ asset('js/libries/moment.min.js') }}"></script>
<script src="{{ asset('js/libries/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/libries/datatables.min.js') }}"></script>
<script src="{{ asset('js/libries/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/libries/select2.min.js') }}"></script>
<script src="{{ asset('js/libries/fullcalendar.min.js') }}"></script>




{{-- //////////////////////////////////////////home made scripts//////////////////////// --}}

<script src="{{ asset('js/dates.js') }}"></script>
<script src="{{ asset('js/ajax.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script src="{{ asset('js/tables.js') }}"></script>
<script src="{{ asset('js/fullcalendar.js') }}"></script>

@yield('script')




</body>
</html>
