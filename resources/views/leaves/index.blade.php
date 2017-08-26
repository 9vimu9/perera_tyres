@extends('layouts.modalform')

@section('title')EMPLOYEE LEAVES @endsection

@section('create_new')ask for a leave @endsection

@section('table')
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

  @if (count($leaves)>0)
  <table id="leaves_index_table" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 100%" >
      <thead>
          <tr>
              <th style="width: 20%">branch</th>
              <th style="width: 12%">category</th>
              <th style="width: 20%">employee name</th>
              <th style="width: 15%">reason</th>
              <th style="width: 15%">from</th>
              <th style="width: 15%">to</th>
              <th style="width: 10%">duration</th>
              <th style="width: 20%"></th>

          </tr>
      </thead>

      <tbody>
            @foreach ($leaves as $leave)
            <tr>
              <td>{{$leave->employee->branch->name}}</td>
              <td>{{$leave->employee->cat->name}}</td>
              <td>{{$leave->employee->name}}</td>
              <td>{{$leave->leave_type->name}}</td>
              @php
                $from_datetime=$leave->from_date.' '.$leave->from_time;
                $to_datetime=$leave->to_date.' '.$leave->to_time;
              @endphp
              <td>{{$from_datetime}}</td>
              <td>{{$to_datetime}}</td>
              <td>{{GetDurationHumanVersion($to_datetime,$from_datetime)}}</td>
              <td>
                <button type="button" class="btn btn-basic btn-xs more" id='{{$leave->id}}'>more</button> |
                <button type="button" class="btn btn-warning btn-xs edit" id='{{$leave->id}}' data-toggle="modal" data-target="#modalform_modal">edit</button> |
                <button type="button" class="btn btn-danger btn-xs delete" id='{{$leave->id}}'>delete</button>

              </td>
            </tr>
            @endforeach

      </tbody>
  </table>
  @endif

  @include('layouts/search_modal')

@endsection

@section('modal_form')

  @include('layouts/receiver_table')

  <div class="form-horizontal">
      <div class="form-group">
        <label class="col-sm-2 control-label">leave type</label>
        <div class="col-sm-5">
          <select id="leave_type_id"  name="leave_type_id" class="form-control" data-width="100%">

          </select>


        </div>
      </div>
    <div class="row">
      <div class="col-md-1"></div>

      <div class="col-md-4" >
        <p class="text-center">from</p>
        <div  class="datetime_picker_fix" id="from_datetime_picker"></div>
        <input type="hidden" name="from_datetime" id="from_datetime">

      </div>

<div class="col-md-2"></div>
      <div class="col-md-4">
          <p class="text-center">to</p>
          <div  class="datetime_picker_fix" id="to_datetime_picker"></div>
          <input type="hidden" name="to_datetime" id="to_datetime">
      </div>
    </div>
  </div>


@endsection

@section('form_script')

  <script>
    create_update_toggle('leaves','leave');

    //var leaves_index_table =$('leaves_index_table').DataTable();

    $('.edit').click(function () {
      var rowData = leaves_index_table.row( $(this).parents('tr') ).data();
      alert(rowData);
      var year=rowData[0];
      var month=moment().month(rowData[1]).format("M");
      var start_date=rowData[2];
      var end_date=rowData[3];

      $('#month_picker').data("DateTimePicker").date(year+'/'+month);
      $('#start_date_picker').data("DateTimePicker").date(start_date);
      $('#end_date_picker').data("DateTimePicker").date(end_date);

    });


    $('.save').click(function () {//modalform save buttton
      var from_datetime=$('#from_datetime_picker').data("date");
      var to_datetime=$('#to_datetime_picker').data("date");
      $('#from_datetime').val(from_datetime);
      $('#to_datetime').val(to_datetime);

      var batch_employee_id = [];
      batch_receive_table.column(4,  { search:'applied' } ).data().each(function(value, index) {
          batch_employee_id.push(value);
      });
      $('#table_data_employee_id').val(batch_employee_id.toString());


    });


   </script>
 @endsection
