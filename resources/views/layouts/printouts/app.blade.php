<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}


    <!-- Google Font -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"> --}}
    <style>
        body {
            font-family: 'Lato';
            font-size: 160%;


        }

        .hiddencell {
            visibility: hidden;
        }
        .fa-btn {
            margin-right: 6px;

        }

        .table {
            border-radius: 5px;

            margin: 0px auto;
            float: none;
        }
    </style>

</head>

<body onload="window.print();">
  print time: {{date("Y-m-d H:i:sa")}}
  <div class="wrapper">
    <div class="row">
      <div class="col-xs-1"></div>
      <div class="col-xs-10">
        <h3>
          <p class="text-center" >
            PERERA TYRE SERVICES<br>
            <font size="6">
              @yield('title')
            </font>
          </p>
        </h3>
        <h4>
          <p class="text-center" >
            @yield('sub_title')
          </p>
        </h4>
      </div>
    </div>
    <div class="content">
      @yield('content')

    </div>
  </div>
</body>
  @yield('script')

</html>
