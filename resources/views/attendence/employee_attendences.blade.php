@extends('layouts.modalform')

@section('title')ATTENDENCE : {{$employee->name}} @endsection

@section('create_new')select date range @endsection

@section('table')

  @if (count($working_days)>0)
    @php
      
    @endphp
  <table id="employee_attendence_index" class="table table-striped table-hover table-center " cellspacing="0" style="table-layout: fixed; width: 70%" >
      <thead>
          <tr>
              <th style="width: 30%">date</th>
              <th style="width: 20%">status</th>
              <th style="width: 14%">clock in</th>
              <th style="width: 14%">clock out</th>
              <th style="width: 12%">OT m</th>
              <th style="width: 12%">2OT m</th>
              <th style="width: 12%">late m</th>
              <th style="width: 20%"></th>
              {{-- array(3) { ["one_entry"]=> string(5) "18:13" ["one_entry_attendence_id"]=> int(290) ["status"]=> string(9) "one entry" }
              array(0) { } array(9) { ["status"]=> string(0) "" ["2_entries"]=> int(1) ["actual_clock_in"]=> string(5) "07:08" ["actual_clock_out"]=> string(5) "18:13" ["late_time_min"]=> int(0) ["early_time_min"]=> int(0) ["OT"]=> int(253) ["double_OT"]=> int(0) ["leave_deduction"]=> int(0) } --}}
{{--  --}}


          </tr>
      </thead>
      <tbody>
            @foreach ($working_days as $working_day)
              @php
                $data_array=GetInOutOfDay($employee,$working_day->date,$working_day->salary,1);

              @endphp
            <tr>
              <td>{{$working_day->date}} <strong>{{date('D', strtotime($working_day->date))}}</strong></td>
              <td>{{$data_array['status']}}</td>
              <td>{{isset($data_array['actual_clock_in']) ? $data_array['actual_clock_in'] : ""}}</td>
              <td>{{isset($data_array['actual_clock_out']) ? $data_array['actual_clock_out'] : ""}}</td>
              <td>{{isset($data_array['OT']) ? $data_array['OT'] : ""}}</td>
              <td>{{isset($data_array['double_OT']) ? $data_array['double_OT'] : ""}}</td>
              <td>{{isset($data_array['leave_deduction']) ? $data_array['leave_deduction'] : ""}}</td>
              <td>
                <button type="button" class="btn btn-warning btn-xs edit" id='' data-toggle="attendence_editor_modal" data-target="#modalform_modal">edit</button> |
              </td>
            </tr>
            @endforeach
      </tbody>
  </table>
  @include('attendence.attendence_editor')
  @endif
@endsection

@section('modal_form')
  <input type="hidden" name="salary_id" id="salary_id" >
  @include('layouts.complete_date_range')


@endsection

@section('form_script')
  <script>
    Route_call('attendence/{{$employee->id}}','set date','get','select range');

    // $('.br_tri').click(function(){
    //
    //   var cell_date=$(this).attr('data-date');
    //   employee_id=$(this).attr('data-employee_id');
    //
    //
    //   clock_in_attendence_id=$(this).parent().find('.clock_in').attr('data-attendence_id');
    //   clock_out_attendence_id=$(this).parent().find('.clock_out').attr('data-attendence_id');
    //
    //   var late_attendence_id=$(this).parent().find('.late').attr('data-attendence_id');
    //   var early_attendence_id=$(this).parent().find('.early').attr('data-attendence_id');
    //
    //   leave_id=$(this).parent().find('.on_leave').attr('data-leave_id');
    //
    //   var clock_in=$(this).parent().find('.clock_in').text();
    //   var one_entry=$(this).parent().find('.one_entry').text();
    //   var late=$(this).parent().find('.late').text().slice(0,5);
    //   var clock_out=$(this).parent().find('.clock_out').text();
    //   var early=$(this).parent().find('.early').text().slice(0,5);
    //   var is_ab=$(this).parent().find('.ab');
    //   if(one_entry)
    //   {
    //     clock_in=clock_out=one_entry;
    //   }
    //
    //
    //   if(!clock_in){
    //     clock_in=late;
    //     clock_in_attendence_id=late_attendence_id;
    //   }
    //
    //   if(!clock_out){
    //     clock_out=early;
    //     clock_out_attendence_id=early_attendence_id;
    //   }
    //
    // $('#clock_in_datetime_picker').data("DateTimePicker").date(cell_date+' '+clock_in);
    // $('#clock_out_datetime_picker').data("DateTimePicker").date(cell_date+' '+clock_out);
    //
    //
    // if (leave_id>0) {
    //   $('#is_on_Leave').prop('checked', true);
    // }
    // else {
    //   $('#is_on_Leave').prop('checked', false);
    // }
    //
    //   $('#is_on_Leave').change();
    //
    //   if (leave_id>0) {
    //     queryData={leave_id:leave_id};
    //
    //     AjaxGetData(3,'get',queryData).success(function (data) {
    //       $('#from_datetime_picker').data("DateTimePicker").date(data[0].from_date+' '+data[0].from_time);
    //       $('#to_datetime_picker').data("DateTimePicker").date(data[0].to_date+' '+data[0].to_time);
    //     });
    //
    //   }
    //   else {
    //     $('#from_datetime_picker').data("DateTimePicker").date(cell_date);
    //     $('#to_datetime_picker').data("DateTimePicker").date(cell_date);
    //   }
    // });


  </script>



@endsection
