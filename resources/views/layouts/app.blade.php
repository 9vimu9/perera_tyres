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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('css/libries/datatables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.3/css/fixedColumns.dataTables.min.css">

    <link href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css" rel="stylesheet">

    <link href="{{ asset('css/libries/cell-corner-button.css') }}" rel="stylesheet">

    <link href="{{ asset('css/libries/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/libries/fullcalendar.min.css') }}" rel="stylesheet">

    {{-- <link href='https://fullcalendar.io/js/fullcalendar-3.4.0/fullcalendar.min.css' rel='stylesheet' /> --}}
    <link href='https://fullcalendar.io/js/fullcalendar-3.4.0/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <link href="{{ asset('css/libries/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/libries/material-checkbox.css') }}" >
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


    <script src="{{ asset('js/libries/jquery-2.2.4.min.js') }}"></script>



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
                    <a class="navbar-brand" href="#">
                        <strong><big>PTS |</big></strong>  payroll
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                      <li><a href="/salaries"><strong><span class="badge">1</span> salary month</strong></a></li>
                      <li><a href="/input_fingerprint_data"><strong><span class="badge">2</span> mark attendence</strong></a></li>
                      <li><a href="/slips"><strong><span class="badge">3</span> pay slips</strong></a></li>
                      <li><a href="/attendence_daily_monthly">att. reports</a></li>
                      <li><a href="/employees">employees</a></li>
                      <li><a href="/holidays">holidays</a></li>
                      {{-- <li><a href="/features">allowences/deductions</a></li> --}}
                      <li><a href="/leaves">leaves</a></li>



                    </ul>

                    {{-- veee
                    samba, keeri smba, naadu
                    haal
                    samba, keer samba, rathu nke sudu ker  nadu   --}}

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
                        @else
                          <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }}</a></li>
                          <li>
                              <a href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                  Logout
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  {!! csrf_field() !!}
                              </form>
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

<script src="{{ asset('js/libries/moment.min.js') }}"></script>
<script src="{{ asset('js/libries/bootstrap.min.js') }}"></script>

<script src="{{ asset('js/libries/datatables.min.js') }}"></script>
<script src="{{ asset('js/libries/select2.full.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.full.js"></script> --}}

<script src="https://cdn.datatables.net/fixedcolumns/3.2.3/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

<script src="{{ asset('js/libries/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/libries/fullcalendar.min.js') }}"></script>




{{-- //////////////////////////////////////////home made scripts//////////////////////// --}}

<script src="{{ asset('js/dates.js') }}"></script>
<script src="{{ asset('js/ajax.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script src="{{ asset('js/tables.js') }}"></script>


@yield('script')

<script>
$(document).ready(function(){
   $('[data-toggle="tooltip"]').tooltip();
});

</script>


</body>
</html>
