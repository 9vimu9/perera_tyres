
{{-- basic details start --}}
<div class="panel panel-info">
  <div class="panel-heading">
    employee information
    <a href="/employees" class="btn btn-success btn-sm pull-right "><i class="fa fa-arrow-left" aria-hidden="true"></i> back</a>

  </div>
  <div class="panel-body">
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">name</label>
      <div class="col-sm-5">
          <input id="name" type="text" class="form-control" name="name" value='{{isset($employee) ? $employee->name : old('name')}}'>
          @if ($errors->has('name'))
              <span class="help-block >
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </div>
    </div>

    <div class="form-group{{ $errors->has('epf_no') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">EPF no</label>
      <div class="col-sm-2">
        <input id="epf_no" type="text" class="form-control" name="epf_no" value='{{isset($employee) ? $employee->epf_no : old('epf_no')}}'>
        @if ($errors->has('epf_no'))
            <span class="help-block">
                <strong>{{ $errors->first('epf_no') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group{{ $errors->has('nic') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">NIC</label>
      <div class="col-sm-2">
        <input id="nic" type="text" class="form-control" name="nic" value='{{isset($employee) ? $employee->nic : old('nic')}}'>
        @if ($errors->has('nic'))
            <span class="help-block">
                <strong>{{ $errors->first('nic') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">address</label>
      <div class="col-sm-8">
        <input id="address" type="text" class="form-control" name="address"value='{{isset($employee) ? $employee->address : old('address')}}'>
        @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">tel</label>
      <div class="col-sm-2">
        <input id="tel" type="text" class="form-control" name="tel" value='{{isset($employee) ? $employee->tel : old('tel')}}'>
        @if ($errors->has('tel'))
            <span class="help-block">
                <strong>{{ $errors->first('tel') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group{{ $errors->has('join_date') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">date joined</label>
      <div class="col-sm-2">
        <input id="date_picker" type="text" class="form-control date_picker_input" name="join_date" value='{{isset($employee) ? $employee->join_date : old('join_date')}}'>
        @if ($errors->has('join_date'))
            <span class="help-block">
                <strong>{{ $errors->first('join_date') }}</strong>
            </span>
        @endif
      </div>
    </div>

  </div>
</div>
    {{-- basic details end --}}
  <div class="panel panel-danger">
    <div class="panel-heading">salary details</div>
    <div class="panel-body">

      <div class="form-horizontal">

        <div class="form-group">
          <label class="col-sm-4 control-label">EPF enabled?</label>
            <div class="col-sm-3">
              <div class="material-switch">
                <input id="is_epf" name="is_epf" type="checkbox"
                @if (isset($employee))
                  {{ $employee->is_epf== 1 ? "checked" : "" }}
                @endif
                />
                  <label for="is_epf" class="label-warning"></label>
              </div>
          </div>
        </div>

        <div class="form-group{{ $errors->has('basic_salary') ? ' has-error' : '' }}">
          <label class="col-sm-4 control-label">primary salary(Rs.)</label>
          <div class="col-sm-3">
            <input id="basic_salary" type="text" class="form-control" name="basic_salary" value='{{isset($employee) ? $employee->basic_salary : old('basic_salary')}}'>
            @if ($errors->has('basic_salary'))
                <span class="help-block">
                    <strong>{{ $errors->first('basic_salary') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 control-label">OT available</label>
            <div class="col-sm-3">
              <div class="material-switch">
                <input id="ot_available" name="ot_available" type="checkbox"
                @if (isset($employee))
                  {{ $employee->ot_available== 1 ? "checked" : "" }}
                @endif
                />
                  <label for="ot_available" class="label-success"></label>
              </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 control-label">salary type</label>
            <div class="col-sm-4">
              <div class="material-switch">per day salary
                <input id="is_monthly_salary" name="is_monthly_salary" type="checkbox"
                @if (isset($employee))
                  {{ $employee->per_day_salary== 0 ? "checked" : "" }}
                @endif
                />
                  <label for="is_monthly_salary" class="label-info"></label>monthly salary
              </div>
          </div>
        </div>

        <div class="form-group{{ $errors->has('actual_salary') ? ' has-error' : '' }} actual_salary">
          <label class="col-sm-4 control-label">actual salary(Rs.)</label>
          <div class="col-sm-3">
            <input id="actual_salary" type="text" class="form-control" name="actual_salary" value='{{isset($employee) ? $employee->actual_salary : old('actual_salary')}}'>
            @if ($errors->has('actual_salary'))
                <span class="help-block">
                    <strong>{{ $errors->first('actual_salary') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group{{ $errors->has('per_day_salary') ? ' has-error' : '' }} per_day_salary">
          <label class="col-sm-4 control-label">per day salary(Rs.)</label>
          <div class="col-sm-3">
            <input id="per_day_salary" type="text" class="form-control" name="per_day_salary" value='{{isset($employee) ? $employee->per_day_salary : old('per_day_salary')}}'>
            @if ($errors->has('per_day_salary'))
                <span class="help-block">
                    <strong>{{ $errors->first('per_day_salary') }}</strong>
                </span>
            @endif
          </div>
        </div>


      </div>
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

<script>
  $('#is_monthly_salary').change(function () {


     if (this.checked) {
       $('.actual_salary').fadeIn();
       $('.per_day_salary').fadeOut();
     }
     else {
       $('.actual_salary').fadeOut();
       $('.per_day_salary').fadeIn();

     }

    }).change(); //ensure visible state matches initially
</script>
