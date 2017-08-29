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
                    <td class='cell-corner'>
                      @php
                        echo GetInOutOfDayHTML($employee,$date->format("Y-m-d"),$salary);
                      @endphp
                       <span class="br_tri tri" data-target="#modal" data-toggle="modal"></span>
                     </td>

                  @endforeach
                </tr>
                @endforeach
          </tbody>
      </table>
      @endif


</div>

<form action="" method="POST">
  {{ csrf_field() }}
  <div id="modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit attendence data</h4>
        </div>
        <div class="modal-body">
          <div class="form-horizontal">
            <div class="form-group{{ $errors->has('start_time') ? ' has-error' : '' }}">
              <label class="col-sm-4 control-label">clock in time</label>
              <div class="col-sm-2">
                <input id="time_picker" type="text" class="form-control time_picker_input" name="start_time" value='{{isset($employee) ? $employee->start_time : old('start_time')}}'>
                @if ($errors->has('start_time'))
                    <span class="help-block">
                        <strong>{{ $errors->first('start_time') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('end_time') ? ' has-error' : '' }}">
              <label class="col-sm-4 control-label">clock out time</label>
              <div class="col-sm-2">
                <input id="time_picker" type="text" class="form-control time_picker_input" name="end_time" value='{{isset($employee) ? $employee->end_time : old('end_time')}}'>
                @if ($errors->has('end_time'))
                    <span class="help-block">
                        <strong>{{ $errors->first('end_time') }}</strong>
                    </span>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
          <input id="submit" type="submit" class="btn btn-primary save">
        </div>
      </div>

    </div>
  </div>


</form>


@endsection

@section('script')
  <script>

  $(document).ready(function() {
    var table = $('#attendence_index').DataTable( {
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,

        // fixedColumns:   {
        //     leftcolumns: 1,
        //
        // },
        searching   : false,
        ordering    : false,
        info        : false

    } );
  } );

  </script>

@endsection
