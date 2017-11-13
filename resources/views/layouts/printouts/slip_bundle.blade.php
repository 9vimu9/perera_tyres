@extends('layouts.printouts.template')

@section('style')

  <style media="screen">


    table, th, td {
        border: 1px solid black;
    }

  p,body{
            margin: 0px;
            padding: 0px;
        }

        hr {
      display: block;
      height:5px;
      background: transparent;
      width: 100%;
      border: none;
      border-top: solid 5px #aaa;
  }

  </style>
@endsection

@section('content')
  @for ($i=0; $i < count($slips); $i+=3)
    <div class="row">
        <div class="col-sm-4 text-center">
          @if ($i%3==0 && count($slips)>$i)
            {{ slip_creator($slips[$i],$allowences,$deductions,$demos)}}
          @endif
        </div>

        <div class="col-sm-4 text-center">
          @if (($i+1)%3==1 && count($slips)>$i+1)
            {{ slip_creator($slips[$i+1],$allowences,$deductions,$demos)}}

          @endif
        </div>

        <div class="col-sm-4 text-center">
          @if (($i+2)%3==2 && count($slips)>$i+2)
          {{ slip_creator($slips[$i+2],$allowences,$deductions,$demos)}}

          @endif
        </div>

      </div>
      <p style="page-break-after: always;">&nbsp;</p>
      <p style="page-break-before: always;">&nbsp;</p>
  @endfor

@endsection
