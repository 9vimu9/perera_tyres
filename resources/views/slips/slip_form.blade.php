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
    <div class="panel-heading">employee information</div>
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
          <p>Rs {{$slip->salary->budget_allowence+$slip->basic_salary}}</p>
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
        ALLOWENCES
        <button type="submit" class="pull-right btn btn-success btn-sm save">update</button>
      </div>
      <div class="panel-body">
        @foreach ($features as $feature)
          @if ($feature->feature_type==1){{-- //1=allowence 0=deduction 2=demo ppp--}}
            @include('slips.template')
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
        DEDUCTIONS
        <button type="submit" class="pull-right btn btn-danger btn-sm save">update</button>
      </div>
      <div class="panel-body">
        @foreach ($features as $feature)
          @if ($feature->feature_type==0){{-- //1=allowence 0=deduction 2=demo ppp--}}
            @include('slips.template')
          @endif
        @endforeach
      </div>
    </div>
</form>



    <div class="panel panel-danger">
      <div class="panel-heading">working days / times</div>
      <div class="panel-body">
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
          <div class="form-group">
            <label class="col-sm-4 control-label">saturday availability</label>
              <div class="col-sm-3">
                <div class="material-switch">
                  <input id="is_sat_work" name="is_sat_work" type="checkbox"
                  @if (isset($employee))
                    {{ $employee->is_sat_work== 1 ? "checked" : "" }}
                  @endif
                  />
                    <label for="is_sat_work" class="label-success"></label>
                </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-4">
              <button type="submit" class="btn btn-primary">
               {{isset($employee) ? 'update' : 'create'}}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
