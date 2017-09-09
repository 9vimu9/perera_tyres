@extends('layouts.app')

@section('content')
{!! csrf_field() !!}
<div class="container">
      <h3><p class="text-center">attendence from
      <span class="badge">{{$salary->start_date}}</span> to
      <span class="badge">{{$salary->end_date}}</span>
      <hr>{{$branch->name}}</p></h3>

      @if (count($employees)>0)
      <table id="attendence_index" class="table table-bordered  " cellspacing="0" style="table-layout: fixed" >

        @php
        $daterange = GetEveryDayBetweenTwoDates($salary->start_date,$salary->end_date);
        @endphp

          <thead>
              <tr>
                <th>name</th>
                @foreach ($daterange as $date)
                  <th>{{$date->format("M/d D")}}</th>
                @endforeach

              </tr>
          </thead>
          <tbody>

                @foreach ($employees as $employee)
                <tr>
                  <td>{{$employee->name}}</td>

                  @foreach ($daterange as $date)
                    <td class='cell-corner' >
                      @php
                        echo GetInOutOfDayHTML($employee,$date->format("Y-m-d"),$salary);
                      @endphp
                       <span class="br_tri tri" data-target="#modal" data-toggle="modal" data-date="{{$date->format("Y-m-d")}}" data-employee_id="{{$employee->id}}"></span>
                     </td>

                  @endforeach
                </tr>
                @endforeach
          </tbody>
      </table>
      @endif


</div>

<form action="/attendence" method="POST">
  {{ csrf_field() }}
  <input type="hidden" name="salary_id" value='{{$salary->id}}' >
  <input type="hidden" name="branch_id" value='{{$branch->id}} '>

  <input type="hidden" name="employee_id" id="employee_id">


  <div id="modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:90%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit attendence data</h4>
        </div>
        <div class="modal-body">

          <div class="form-horizontal">

            <div class="form-group">
              <label class="col-sm-4 control-label">clock in time <i class="fa fa-sign-in" aria-hidden="true"></i></label>
              <div class="col-sm-3">
                <input type="hidden" name="start_datetime_attendence_id" id="start_datetime_attendence_id" >
                <input id="clock_in_datetime_picker" type="text" class="form-control datetime_picker_input" name="start_datetime" value=''>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">clock out time <i class="fa fa-sign-out" aria-hidden="true"></i></label>
              <div class="col-sm-3">
                <input type="hidden" name="end_datetime_attendence_id" id="end_datetime_attendence_id" >
                <input id="clock_out_datetime_picker" type="text" class="form-control datetime_picker_input" name="end_datetime" value=''>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">on leave <i class="fa fa-sun-o" aria-hidden="true"></i></label>
              <div class="col-sm-4">
                <div class="material-switch">
                  <input id="is_on_Leave" name="is_on_Leave" type="checkbox"/>
                  <label for="is_on_Leave" class="label-danger">
                  <input type="hidden" name="leave_id" id="leave_id">
                </div>
              </div>
            </div>
          </div>

          <div class="leave_section">
            @include('leaves/leave_template')

          </div>


          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
          <input id="submit" type="submit" class="btn btn-primary save" value="update">
        </div>
      </div>

      </div>

    </div>
</form>


@endsection

@section('script')

<style media="screen">
  .modal-dialog,
.modal-content {
  /* 80% of window height */
  height: 90%;
}

.modal-body {
  /* 100% = dialog height, 120px = header + footer */
height: calc(100% - 120px);
  /*overflow-y: scroll;*/
}
  </style>

  <script>

    var clock_in_attendence_id=0;
    var clock_out_attendence_id=0;
    var leave_id=0;
    var employee_id=0;

    $('.save').click(function () {//modalform save buttton(submit button)
      // alert(clock_in_attendence_id);
      $('#start_datetime_attendence_id').val(clock_in_attendence_id);
      $('#end_datetime_attendence_id').val(clock_out_attendence_id);
      $('#leave_id').val(leave_id);
      $('#employee_id').val(employee_id);


    });

    $('.br_tri').click(function(){

      var cell_date=$(this).attr('data-date');
      employee_id=$(this).attr('data-employee_id');


      clock_in_attendence_id=$(this).parent().find('.clock_in').attr('data-attendence_id');
      clock_out_attendence_id=$(this).parent().find('.clock_out').attr('data-attendence_id');

      var late_attendence_id=$(this).parent().find('.late').attr('data-attendence_id');
      var early_attendence_id=$(this).parent().find('.early').attr('data-attendence_id');

      leave_id=$(this).parent().find('.on_leave').attr('data-leave_id');

      var clock_in=$(this).parent().find('.clock_in').text();
      var one_entry=$(this).parent().find('.one_entry').text();
      var late=$(this).parent().find('.late').text().slice(0,5);
      var clock_out=$(this).parent().find('.clock_out').text();
      var early=$(this).parent().find('.early').text().slice(0,5);
      var is_ab=$(this).parent().find('.ab');
      if(one_entry)
      {
        clock_in=clock_out=one_entry;
      }


      if(!clock_in){
        clock_in=late;
        clock_in_attendence_id=late_attendence_id;
      }

      if(!clock_out){
        clock_out=early;
        clock_out_attendence_id=early_attendence_id;
      }

    $('#clock_in_datetime_picker').data("DateTimePicker").date(cell_date+' '+clock_in);
    $('#clock_out_datetime_picker').data("DateTimePicker").date(cell_date+' '+clock_out);


    if (leave_id>0) {
      $('#is_on_Leave').prop('checked', true);
    }
    else {
      $('#is_on_Leave').prop('checked', false);
    }

      $('#is_on_Leave').change();

      if (leave_id>0) {
        queryData={leave_id:leave_id};

        AjaxGetData(3,'get',queryData).success(function (data) {
          $('#from_datetime_picker').data("DateTimePicker").date(data[0].from_date+' '+data[0].from_time);
          $('#to_datetime_picker').data("DateTimePicker").date(data[0].to_date+' '+data[0].to_time);
        });

      }
      else {
        $('#from_datetime_picker').data("DateTimePicker").date(cell_date);
        $('#to_datetime_picker').data("DateTimePicker").date(cell_date);
      }
    });



      $('#is_on_Leave').change(function () {
         if(this.checked){
            $('.leave_section').fadeIn();
         }
         else {
            $('.leave_section').fadeOut();
         }
        }).change(); //ensure visible state matches initially


    var table = $('#attendence_index').DataTable( {
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        searching   : false,
        ordering    : false,
        info        : false

    } );


  </script>

@endsection
