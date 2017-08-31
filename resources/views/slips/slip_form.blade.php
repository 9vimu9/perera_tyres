@extends('layouts.form')

@section('title')
  <h3 class="text-center">
    PAY SLIP for {{date("F", mktime(0, 0, 0, $slip->salary->month, 10))}},{{$slip->salary->year}}
  </h3>
  <h4 class="text-center">
    {{$slip->employee->name}}
  </h4>

@endsection

@section('panels')

  {{-- basic details start --}}
  <div class="panel panel-info">
    <div class="panel-heading">employee information</div>
    <div class="panel-body">
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
    </div>
  </div>
      {{-- basic details end --}}
    <div class="panel panel-success">
      <div class="panel-heading">EARNINGS</div>
      <div class="panel-body">
        @foreach ($features as $feature)
          <div class="row">
            @if ($feature->is_compulsory_feature && $feature->is_static_value)
              <div class="col-sm-4 text-right">
                <p>{{$feature->name}}</p>
              </div>
              @if ($feature->value_type==1){{-- 0=fixed value from slary 1=precentage --}}
                <div class="col-sm-4 ">
                  <p>Rs.
                  @if ($feature->slip_static_value)
                    {{$basic_salary*$feature->slip_static_value/100}} ({{$feature->slip_static_value}}% from basic salary)</p>
                    @else
                      {{$basic_salary*$feature->latest_static_value/100}} ({{$feature->latest_static_value}}% from basic salary)</p>
                  @endif

                </div>
              @endif
            @endif
        </div>
        @endforeach


      </div>
    </div>

    <div class="panel panel-success">
      <div class="panel-heading">workplace</div>
      <div class="panel-body">
        <div class="form-horizontal">

          <div class="form-group{{ $errors->has('branch_id') ? ' has-error' : '' }}">
            <label class="col-sm-4 control-label">workplace name</label>
            <div class="col-sm-6">
              <select id="branch_id"  name="branch_id" class="form-control" data-width="100%">
                @if (isset($employee))
                  <option value="{{$employee->branch->id}}" >
                    {{$employee->branch->name}}
                  </option>
                @endif
              </select>

              @if ($errors->has('branch_id'))
                  <span class="help-block">
                      <strong>{{ $errors->first('branch_id') }}</strong>
                  </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('fingerprint_no') ? ' has-error' : '' }}">
            <label class="col-sm-4 control-label">finger print ID</label>
            <div class="col-sm-2">
              <input id="fingerprint_no" type="text" class="form-control" name="fingerprint_no" value='{{isset($employee) ? $employee->fingerprint_no : old('fingerprint_no')}}'>
              @if ($errors->has('fingerprint_no'))
                  <span class="help-block">
                      <strong>{{ $errors->first('fingerprint_no') }}</strong>
                  </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
            <label class="col-sm-4 control-label">category</label>
            <div class="col-sm-3">
              <select id="cat_id"  name="cat_id" class="form-control" data-width="100%">
                @if (isset($employee))
                  <option value="{{$employee->cat->id}}" >

                  </option>
                @endif
              </select>

              @if ($errors->has('cat_id'))
                  <span class="help-block">
                      <strong>{{ $errors->first('cat_id') }}</strong>
                  </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('designation_id') ? ' has-error' : '' }}">
            <label class="col-sm-4 control-label">designation</label>
            <div class="col-sm-3">
              <select id="designation_id"  name="designation_id" class="form-control" data-width="100%">
                @if (isset($employee))
                  <option value="{{$employee->designation_id}}" >
                    {{$employee->designation->name}}
                  </option>
                @endif

              </select>

              @if ($errors->has('designation_id'))
                  <span class="help-block">
                      <strong>{{ $errors->first('designation_id') }}</strong>
                  </span>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

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
