@extends('layouts.modalform')

@section('title')
  @isset($year)
{{$year}}
  @endisset
  LEAVES: {{$employee->name}}
@endsection

@section('create_new')select year @endsection

@section('table')

  @if (isset($employee_leave_data) && count($employee_leave_data)>0)
  <table id="employee_leaves_index" class="table table-striped table-hover table-center " cellspacing="0" style="table-layout: fixed; width: 70%" >
      <thead>
          <tr>
              <th style="width: 30%">date</th>
              <th style="width: 20%">leave type</th>
              <th style="width: 14%">days</th>
          </tr>
      </thead>
      <tbody>
            @foreach ($employee_leave_data as $leave_data)

            <tr>
              <td>{{$leave_data['date']}}</td>
              <td>{{$leave_data['type']}}</td>
              <td>{{$leave_data['days']}}</td>
            </tr>
            @endforeach
      </tbody>
  </table>
  @endif
@endsection

@section('modal_form')



  <div class="row">
    <div class="col-md-3"></div>

    <div class="col-md-6" >
      <p class="text-center">from</p>
      <div  class="year_picker_fix" id="year_picker_fix"></div>
      <input type="hidden" name="from_datetime" id="from_datetime">
      <input type="hidden" name="to_datetime" id="to_datetime">
      <input type="hidden" name="range_by_custom" value="1">


    </div>
  </div>


@endsection

@section('form_script')
  <script>
    Route_call('leaves/{{$employee->id}}','set year','get','select year');

    $('.save').click(function () {
      var year=$('#year_picker_fix').data("date");
      $("#from_datetime").val(year+"-01-01");
      $("#to_datetime").val(year+"-12-31");

    });



  </script>



@endsection
