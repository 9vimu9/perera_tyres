@extends('layouts.printouts.app')

@section('title')
  {{$slip->employee->branch->name}}<br>PAY SLIP for {{date("F", mktime(0, 0, 0, $slip->salary->month, 10))}},{{$slip->salary->year}}


@endsection

@section('sub_title')
  ({{$slip->salary->start_date}} to {{$slip->salary->end_date}})

@endsection


@section('content')
  @php
    $ot_in_rs=get_ot_in_rs($slip->salary,$slip->employee,$slip->epf_ot_rate);
    $basic_salary=$slip->salary->budget_allowence+$slip->basic_salary;
    $total_allowences_in_rs=$allowences[1]+$ot_in_rs;
    $total_deductions_in_rs=$deductions[1];
    $total_salary=round($ot_in_rs+$basic_salary+$total_allowences_in_rs-$total_deductions_in_rs,2);

  @endphp
  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">name</div>
    <div class="col-xs-6 ">{{$slip->employee->name}} </div>
  </div>
  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">EPF no </div>
    <div class="col-xs-6 ">{{$slip->employee->epf_no}} </div>
  </div>

  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">designation </div>
    <div class="col-xs-6 ">{{$slip->employee->designation->name}} </div>
  </div>

  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right"><h4>SALARY</h4></div>
    <div class="col-xs-6 "><h4>{{$total_salary}}</h4> </div>
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
    <div class="col-xs-6 ">Rs {{$basic_salary}}</div>
  </div>

<br>
  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-3 text-right">allowences </div>
    {{-- <div class="col-xs-3 ">Rs {{$allowences[1]}} </div> --}}

  </div>

    @foreach ($allowences[0] as $allowence)
      <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-3 text-right">{{$allowence['name']}}</div>
        <div class="col-xs-3 text-left">Rs {{$allowence['value_in_rs']}}</div>
      </div>
    @endforeach

    <div class="row">
      <div class="col-xs-3"></div>
      <div class="col-xs-3 text-right">over time</div>
      <div class="col-xs-3 ">Rs {{$ot_in_rs}}</div>
    </div>

    <div class="row">
      <div class="col-xs-3"></div>
      <div class="col-xs-3 text-right">TOTAL</div>
      <div class="col-xs-3 ">Rs {{$total_allowences_in_rs}}</div>
    </div>


    <br>
    <div class="row">
      <div class="col-xs-1"></div>
      <div class="col-xs-3 text-right">deductions </div>
      {{-- <div class="col-xs-3 ">Rs {{$deductions[1]}} </div> --}}

    </div>

      @foreach ($deductions[0] as $deduction)
        <div class="row">
          <div class="col-xs-3"></div>
          <div class="col-xs-3 text-right">{{$deduction['name']}}</div>
          <div class="col-xs-3 text-left">Rs {{$deduction['value_in_rs']}}</div>
        </div>

      @endforeach
      <div class="row">
        <div class="col-xs-3"></div>
        <div class="col-xs-3 text-right">TOTAL</div>
        <div class="col-xs-3 ">Rs {{$total_deductions_in_rs}}</div>
      </div>
<br>



@endsection
