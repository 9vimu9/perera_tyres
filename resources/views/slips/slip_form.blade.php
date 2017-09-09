@extends('layouts.form')

@section('title')
  <h3 class="text-center">
    PAY SLIP for {{date("F", mktime(0, 0, 0, $slip->salary->month, 10))}},{{$slip->salary->year}}
  </h3>
  <h4 class="text-center">
    ({{$slip->salary->start_date}} to {{$slip->salary->end_date}})
  </h4>

@endsection

@section('panels')

  {{-- basic details start --}}
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="row">
        <div class="col-sm-2 text-left">employee info</div>
        <div class="col-sm-3 text-right">final salary</div>
        <h3><div class="col-sm-4  total_salary"></div></h3>
        <div class="col-sm-3 text-right">
          <a href="/printouts/slip/{{$slip->id}}" class="btn btn-success btn-sm"><i class="fa fa-back" aria-hidden="true"></i> back</a>
          <a href="/printouts/slip/{{$slip->id}}" class="btn btn-warning btn-sm"><i class="fa fa-print" aria-hidden="true"></i> print</a>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-4 text-right">
          <p>name</p>
        </div>
        <div class="col-sm-6">
          <p>{{$slip->employee->name}}</p>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4 text-right">
          <p>branch</p>
        </div>
        <div class="col-sm-6">
          <p>{{$slip->employee->branch->name}}</p>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4 text-right">
          <p>designation</p>
        </div>
        <div class="col-sm-6">
          <p>{{$slip->employee->designation->name}}</p>
        </div>
      </div>


      <div class="row">
        <div class="col-sm-4 text-right">
          <p>primary salary</p>
        </div>
        <div class="col-sm-6">
          <p>Rs {{$slip->basic_salary}}</p>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4 text-right">
          <p>budget allowence</p>
        </div>
        <div class="col-sm-6">
          <p>Rs {{$slip->salary->budget_allowence}}</p>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-4 text-right">
          <p>basic salary</p>
        </div>
        <div class="col-sm-6">
          <span>Rs </span><span id="basic_salary">{{$slip->salary->budget_allowence+$slip->basic_salary}}</span>
        </div>
      </div>
<p class="text-right"><i><strong>(basic salary = primary salary + budget allowence)</strong></i></p>

    </div>
  </div>
      {{-- basic details end --}}

<form  role="form" method="post" action="/slips">
  <input type="hidden" name="slip_id" value="{{$slip->id}}">
        {{ csrf_field() }}
    <div class="panel panel-success">
      <div class="panel-heading">
        <div class="row">
          <div class="col-sm-2 text-left">ALLOWENCES</div>
          <h3><div class="col-sm-8 text-center total_allowences"></div></h3>

          <div class="col-sm-2 text-right">
            <button type="submit" class="btn btn-success btn-sm save">update</button>
          </div>
        </div>
      </div>
      <div class="panel-body form-horizontal">
        @foreach ($features as $feature)
          @if ($feature->feature_type==1){{-- //1=allowence 0=deduction 2=demo ppp--}}
            @include('slips.feature_template')
          @endif
        @endforeach
      </div>
    </div>
</form>

<form  role="form" method="post" action="/slips">
  <input type="hidden" name="slip_id" value="{{$slip->id}}">
        {{ csrf_field() }}
    <div class="panel panel-danger">
      <div class="panel-heading">
        <div class="row">
          <div class="col-sm-2 text-left">DEDUCTIONS</div>
          <h3>  <div class="col-sm-8 text-center total_deductions"></div></h3>
          <div class="col-sm-2 text-right">
            <button type="submit" class="pull-right btn btn-danger btn-sm save">update</button>

          </div>
        </div>
      </div>
      <div class="panel-body form-horizontal">
        @foreach ($features as $feature)
          @if ($feature->feature_type==0){{-- //1=allowence 0=deduction 2=demo ppp--}}
            @include('slips.feature_template')
          @endif
        @endforeach
      </div>
    </div>
</form>


<form  role="form" method="post" action="/slips">
  <input type="hidden" name="slip_id" value="{{$slip->id}}">
        {{ csrf_field() }}
    <div class="panel panel-default">
      <div class="panel-heading">
        DISPLAY ON SLIP
        <button type="submit" class="pull-right btn btn-default btn-sm save">update</button>
      </div>
      <div class="panel-body form-horizontal">
        @foreach ($features as $feature)
          @if ($feature->feature_type==2){{-- //1=allowence 0=deduction 2=demo ppp--}}
            @include('slips.feature_template')

          @endif
        @endforeach
      </div>
    </div>
</form>



    <div class="panel panel-info">
      <div class="panel-heading">
        <div class="row">
          <div class="col-sm-2 text-left">OVER TIME</div>
          <div class="col-sm-2 text-center ">OT RATE:Rs {{$ot_rate}}</div>
          <div class="col-sm-3 text-center ">OT HOURS:{{$ot_hours}}</div>
          <div class="col-sm-5 text-right ">Rs <h3>{{$ot_hours*$ot_rate}}</h3></div>

        </div>
      </div>
      <div class="panel-body">
        @php
          $daterange = GetEveryDayBetweenTwoDates($slip->salary->start_date,$slip->salary->end_date);
        @endphp

        <table class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 70%" >
            <thead>
                <tr>
                    <th style="width: 25%">date</th>
                    <th style="width: 25%">type</th>
                    <th style="width: 15%">clock in</th>
                    <th style="width: 22%">clock out</th>
                    <th style="width: 20%">OT (m)</th>

                </tr>
            </thead>

            <tbody>
              @foreach ($daterange as $date)
                @php
                //  array(
                // 'actual_clock_in' => '09:27',
                //  'actual_clock_out' => '15:58',
                //  'late_time_min' => 87,
                //  'early_time_min' => 62,
                //  'OT' => 0,
                //  'leave_deduction' => 149

                $data=is_date_has_over_time($date->format("Y-m-d"),$slip->salary,$slip->employee);
                @endphp
                @if ($data['OT']>0)
                  <tr>
                    <td>{{$date->format("Y-m-d")}}</td>
                    <td>
                      @php
                      $holiday=IsHoliday($slip->employee,$date->format("Y-m-d"));
                      echo $holiday ? $holiday : 'working day' ;
                      @endphp
                    </td>
                    <td>{{$data['actual_clock_in']}}</td>
                    <td>{{$data['actual_clock_out']}}</td>
                    <td>{{GetDurationHumanVersion(0,0,$data['OT']*60)}}</td>


                  </tr>


                @endif
              @endforeach
            </tbody>
        </table>

    </div>
  </div>

@endsection


@section('script')
  <script>


  $('.remove').click(function () {
    var feature_id=$(this).attr('data-feature-id');
    console.log(feature_id);
    $("#slip_feature_value_"+feature_id).val('0').change();
  });


  </script>

@endsection
