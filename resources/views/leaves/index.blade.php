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

              <form action="/leaves/{{$leave->id}}" class="pull-right" method="POST">
                {{ csrf_field() }}
                <td>
                  <button type="button" class="btn btn-warning btn-xs edit" id='{{$leave->id}}' data-toggle="modal" data-target="#modalform_modal">edit</button> |
                  <input type="submit" name="delete" value="remove" class="btn btn-danger btn-xs">
                  <input type="hidden" name="_method" value="DELETE">
                </td>
              </form>

            </tr>
            @endforeach

      </tbody>
  </table>
  @endif

  @include('layouts/search_modal')

@endsection

@section('modal_form')

<span id="employee_list">
  @include('layouts/receiver_table')
</span>


  @include('leaves/leave_template')

@endsection

@section('form_script')

  <script>

    create_update_toggle("leaves","leave");

    $('.edit').click(function () {
      $("#employee_list").fadeOut();
      var rowData = leaves_index_table.row( $(this).parents('tr') ).data();
      var employee_name=rowData[2];
      var leave_id=$(this).attr('id');
      $('#edit_form').attr( 'action',"/leaves/"+leave_id);
      $('#modal_title').text($('#modal_title').text()+":"+employee_name);
      var start_date=rowData[4];
      var end_date=rowData[5];
      $('#from_datetime_picker').data("DateTimePicker").date(start_date);
      $('#to_datetime_picker').data("DateTimePicker").date(end_date);

    });

    $('.create').click(function () {
      $("#employee_list").fadeIn();

    });

    $('.save').click(function () {//modalform save buttton
      var batch_employee_id = [];
      batch_receive_table.column(4,  { search:'applied' } ).data().each(function(value, index) {
          batch_employee_id.push(value);
      });
      $('#table_data_employee_id').val(batch_employee_id.toString());


    });


   </script>
 @endsection
