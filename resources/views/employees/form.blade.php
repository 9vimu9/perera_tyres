
{{-- basic details start --}}
<div class="panel panel-info">
  <div class="panel-heading">basic</div>
  <div class="panel-body">
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">name</label>
      <div class="col-sm-5">
          <input id="name" type="text" class="form-control" name="name" value={{old('name')}}>
          @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </div>
    </div>

    <div class="form-group{{ $errors->has('epf_no') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">EPF no</label>
      <div class="col-sm-2">
        <input id="epf_no" type="text" class="form-control" name="epf_no" value={{old('epf_no')}}>
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
        <input id="nic" type="text" class="form-control" name="nic" value={{old('nic')}}>
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
        <input id="address" type="text" class="form-control" name="address" value={{old('address')}}>
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
        <input id="tel" type="text" class="form-control" name="tel" value={{old('tel')}}>
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
        <input id="date_picker" type="text" class="form-control" name="join_date" value={{old('join_date')}}>
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
        <div class="form-group{{ $errors->has('basic_salary') ? ' has-error' : '' }}">
          <label class="col-sm-4 control-label">basic salary(Rs.)</label>
          <div class="col-sm-3">
            <input id="basic_salary" type="text" class="form-control" name="basic_salary" value={{old('basic_salary')}}>
            @if ($errors->has('basic_salary'))
                <span class="help-block">
                    <strong>{{ $errors->first('basic_salary') }}</strong>
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

        <div class="form-group{{ $errors->has('branchs_id') ? ' has-error' : '' }}">
          <label class="col-sm-4 control-label">workplace name</label>
          <div class="col-sm-6">
            <select id="branchs_id"  name="branchs_id" class="form-control" data-width="100%">
            </select>

            @if ($errors->has('branchs_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('branchs_id') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group{{ $errors->has('fingerprint_no') ? ' has-error' : '' }}">
          <label class="col-sm-4 control-label">finger print ID</label>
          <div class="col-sm-2">
            <input id="fingerprint_no" type="text" class="form-control" name="fingerprint_no" value={{old('fingerprint_no')}}>
            @if ($errors->has('fingerprint_no'))
                <span class="help-block">
                    <strong>{{ $errors->first('fingerprint_no') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group{{ $errors->has('cats_id') ? ' has-error' : '' }}">
          <label class="col-sm-4 control-label">category</label>
          <div class="col-sm-3">
            <select id="cats_id"  name="cats_id" class="form-control" data-width="100%">
            </select>

            @if ($errors->has('cats_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('cats_id') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group{{ $errors->has('designations_id') ? ' has-error' : '' }}">
          <label class="col-sm-4 control-label">designation</label>
          <div class="col-sm-3">
            <select id="designations_id"  name="designations_id" class="form-control" data-width="100%">
            </select>

            @if ($errors->has('designations_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('designations_id') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group{{ $errors->has('start_time') ? ' has-error' : '' }}">
          <label class="col-sm-4 control-label">day start time</label>
          <div class="col-sm-2">
            <input id="time_picker" type="text" class="form-control" name="start_time" value={{old('start_time')}}>
            @if ($errors->has('start_time'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_time') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-6 col-sm-offset-4">
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-btn fa-plus"></i> create
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @section('script')
    <script type="text/javascript">
      GetSuggestionsForSelect2("#cats_id",'name','cats');
      GetSuggestionsForSelect2("#branchs_id",'name','branchs');
      GetSuggestionsForSelect2("#designations_id",'name','designations');
    </script>

  @endsection
