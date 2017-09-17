@extends('layouts.app')

@section('content')
{!! csrf_field() !!}
<div class="container">
      <h3><p class="text-center"><strong>{{$branch->name}}</strong> attendence from
      <span class="badge">{{$salary->start_date}}</span> to
      <span class="badge">{{$salary->end_date}}</span>
      </p></h3>

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
                <tr >
                  <td>{{$employee->name}}</td>

                  @foreach ($daterange as $date)
                    <td class='cell-corner' data-container="body" data-toggle="tooltip" title="{{$employee->name}}">
                      @php
                        echo GetInOutOfDay($employee,$date->format("Y-m-d"),$salary);
                      @endphp
                       <span class="br_tri tri" data-target="#attendence_editor_modal" data-toggle="modal" data-date="{{$date->format("Y-m-d")}}" data-employee_id="{{$employee->id}}"></span>
                     </td>

                  @endforeach
                </tr>
                @endforeach
          </tbody>
      </table>
      @endif
</div>

@include('attendence.attendence_editor')
@endsection

@section('script')



  <script>
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









  </script>

@endsection
