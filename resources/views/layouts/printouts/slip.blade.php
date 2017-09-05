@extends('layouts.printouts.app')

@section('title')
  PAY SLIP for {{date("F", mktime(0, 0, 0, $slip->salary->month, 10))}},{{$slip->salary->year}}


@endsection

@section('sub_title')
  ({{$slip->salary->start_date}} to {{$slip->salary->end_date}})

@endsection


@section('content')
  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">name </div>
    <div class="col-xs-6 ">{{$slip->employee->name}} </div>
  </div>
  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">branch </div>
    <div class="col-xs-6 ">{{$slip->employee->branch->name}} </div>
  </div>

  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">designation </div>
    <div class="col-xs-6 ">{{$slip->employee->designation->name}} </div>
  </div>
  <hr>

  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">primary salary </div>
    <div class="col-xs-6 ">Rs {{$slip->basic_salary}} </div>
  </div>

  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">budget allowence </div>
    <div class="col-xs-6 ">Rs {{$slip->salary->budget_allowence}}</div>
  </div>

  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">basic salary</div>
    <div class="col-xs-6 ">Rs {{$slip->salary->budget_allowence+$slip->basic_salary}}</div>
  </div>

<br>
  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">allowences </div>
    <div class="col-xs-3 ">Rs {{$allowences[1]}} </div>

  </div>

    @foreach ($allowences[0] as $allowence)
      <div class="row">
        <div class="col-xs-2"></div>
        <div class="col-xs-2 text-right">{{$allowence['name']}}</div>
        <div class="col-xs-3 text-center">{{$allowence['value']}}</div>
        <div class="col-xs-3 text-left">Rs {{$allowence['value_in_rs']}}</div>
      </div>


    </div>
    @endforeach

    <br>
    <div class="row">
      <div class="col-xs-1"></div>
      <div class="col-xs-3 text-right">deductions </div>
      <div class="col-xs-3 ">Rs {{$deductions[1]}} </div>

    </div>

      @foreach ($deductions[0] as $deduction)
        <div class="row">
          <div class="col-xs-2"></div>
          <div class="col-xs-2 text-right">{{$deduction['name']}}</div>
          <div class="col-xs-3 text-center">{{$deduction['value']}}</div>
          <div class="col-xs-3 text-left">Rs {{$deduction['value_in_rs']}}</div>
        </div>


      </div>
      @endforeach
<br>
      <div class="row">
        <div class="col-xs-1"></div>
        <div class="col-xs-3 text-right">over time </div>
        <div class="col-xs-3 ">Rs {{$ot_rate*$ot_hours}}</div>

      </div>

      <div class="row">
        <div class="col-xs-2"></div>
        <div class="col-xs-3 text-right">OT rate</div>
        <div class="col-xs-3 ">Rs {{$ot_rate}}</div>
      </div>

      <div class="row">
        <div class="col-xs-2"></div>
        <div class="col-xs-3 text-right">OT hours</div>
        <div class="col-xs-3 ">Rs {{$ot_hours}}</div>
      </div>






@endsection
