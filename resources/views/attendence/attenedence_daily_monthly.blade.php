@extends('layouts.modalform')

@section('title')
  ATTENDENCE
  @isset($branch_name)
  <strong>{{$branch_name}}</strong>
  <br>
  from <span class="badge">{{$start_date}}</span>
  to <span class="badge">{{$end_date}}</span>
  @endisset
  @endsection

@section('create_new')select date range @endsection



@section('table')

  @if (isset($employees_attendence_data) && count($employees_attendence_data)>0)
    @php

    @endphp

  <table id="attendence_daily_monthly_table" class="table table-bordered table-striped table-hover table-center " cellspacing="0" style="table-layout: fixed" >
      <thead>
          <tr>
              <th style="width: 30%">name</th>
              <th style="width: 20%">designation</th>
              <th style="width: 12%">planned clock in</th>
              <th style="width: 12%">planned clock out</th>
              <th style="width: 10%">days worked</th>
              <th style="width: 10%">total absent</th>
              <th style="width: 10%">days on leave</th>
              <th style="width: 10%">absent(without notify)</th>
              <th style="width: 12%">OT hours</th>
              <th style="width: 12%">week day OT</th>
              <th style="width: 12%">weekend OT</th>
              <th style="width: 12%">days late</th>
              <th style="width: 12%">mins late</th>
              <th style="width: 12%">days early</th>
              <th style="width: 12%">mins early</th>
          </tr>
      </thead>
      <tbody>
            @foreach ($employees_attendence_data as $employee_attendence_data)

            <tr>
                <td>{{$employee_attendence_data['employee']->name}}</td>
                <td>{{$employee_attendence_data['employee']->designation->name}}</td>
                <td>{{$employee_attendence_data['employee']->start_time}}</td>
                <td>{{$employee_attendence_data['employee']->end_time}}</td>
{{--can we get something like avaerage start_time of employee  --}}
                <td>{{$employee_attendence_data['days_worked']}}</td>
                <td>{{$employee_attendence_data['times_onleave']+$employee_attendence_data['times_absent_without_leave']}}</td>
                <td>{{$employee_attendence_data['times_onleave']}}</td>
                <td>{{$employee_attendence_data['times_absent_without_leave']}}</td>
                @php
                  $total_ot=($employee_attendence_data['ot_hours_working_days']+$employee_attendence_data['ot_hours_holidays'])/60;
                  $total_ot=round($total_ot,2);
                  $ot_hours_working_days=round($employee_attendence_data['ot_hours_working_days']/60,2);
                  $ot_hours_holidays=round($employee_attendence_data['ot_hours_holidays']/60,2);
                @endphp
                <td>{{$total_ot}}</td>
                <td>{{$ot_hours_working_days}}</td>
                <td>{{$ot_hours_holidays}}</td>
                <td>{{$employee_attendence_data['times_late']}}</td>
                <td>{{$employee_attendence_data['mins_late']}}</td>
                <td>{{$employee_attendence_data['times_early']}}</td>
                <td>{{$employee_attendence_data['mins_early']}}</td>
            </tr>
            @endforeach
      </tbody>
  </table>
  @endif
@endsection

@section('modal_form')
  <input type="hidden" name="salary_id" id="salary_id" >

  <div class="form-group">
    <label class="col-sm-2 control-label">workplace name</label>
    <div class="col-sm-5">
      <select id="branch_id"  name="branch_id" class="form-control" data-width="100%"></select>
    </div>

  </div>
<br>
<hr>
  @include('layouts.complete_date_range')


@endsection

@section('form_script')
  <script>
    Route_call('attendence_daily_monthly','select date range and branch','get','select range');

    var attendence_daily_monthly_table =   $('#attendence_daily_monthly_table').DataTable({
      scrollY:        '400px',
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      searching   : true,
      ordering    : true,
      info        : false,
      dom         : 'Bfrtip',
      buttons     : [

                 {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                @isset($branch_name)
                  title:'ATTENDENCE: {{$branch_name}}from {{$start_date}} to {{$end_date}}'
                @endisset

            }
          ]


        });
  </script>



@endsection
