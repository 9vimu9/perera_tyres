<div class="row form-horizontal">
  <div class="form-group">
    <div class="col-sm-4 text-right">{{$feature->name}}</div>
      <div class="col-sm-2">
        <input {{$feature->is_static_value==1 ? " readonly " : ""}} id="slip_feature_value" type="text" class="form-control" name="slip_feature_value[]"
          @if ($feature->is_static_value==1)
            @if ($feature->slip_feature_static_value>0)
              value='{{$feature->slip_feature_static_value}}'
            @else
              value='{{$feature->static_value}}'
            @endif
          @else
              value='{{$feature->slip_feature_value}}'
          @endif
          >
        <input type="hidden" name="slip_feature_id[]" value="{{$feature->slip_feature_id}}">
        <input type="hidden" name="feature_id[]" value="{{$feature->feature_id}}">
        <input type="hidden" name="slip_feature_static_value[]" value="{{$feature->static_value}}">

      </div>
      <div class="col-sm-3">
        <select {{$feature->is_static_value==1 ? " disabled " : ""}} class="form-control" name="slip_feature_value_type[]" id="value_type" >
          <option value="0"
            @if ($feature->is_static_value==1)
              @if ($feature->slip_feature_static_value>0)
                {{ $feature->slip_feature_value_type == 0 ? " selected " : "" }}
              @else
                {{ $feature->value_type == 0 ? " selected " : "" }}
              @endif
            @else
              {{ $feature->slip_feature_value_type == 0 ? " selected " : "" }}
            @endif
          >rupees
          </option>

          <option value="1"
          @if ($feature->is_static_value==1)
            @if ($feature->slip_feature_static_value>0)
              {{ $feature->slip_feature_value_type == 1 ? " selected " : "" }}
            @else
              {{ $feature->value_type == 1 ? " selected " : "" }}
            @endif
          @else
            {{ $feature->slip_feature_value_type == 1 ? " selected " : "" }}
          @endif
            >% from basic salaray
          </option>
        </select>
      </div>
      @if ($feature->is_static_value==0)
        <button type="button" class="btn btn-danger btn-xs">remove</button>
      @endif
  </div>
</div>
