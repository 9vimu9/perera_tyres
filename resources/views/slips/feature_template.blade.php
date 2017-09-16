  <div class="form-group">
    <div class="col-sm-4 text-right">{{$feature->name}}</div>
      <div class="col-sm-2">
        <input {{$feature->is_static_value==1 ? " readonly " : ""}} id="slip_feature_value_{{$feature->id}}" type="text" class="form-control value_input" name="slip_feature_value[]"
          @if ($feature->is_static_value==1)
            @if ($feature->slip_feature!=NULL)
              value='{{$feature->slip_feature['value']}}'
            @else
              value='{{$feature->static_value}}'
            @endif
          @else
              value='{{$feature->slip_feature['value']}}'
          @endif
          >
        <input type="hidden" name="slip_feature_id[]" value="{{$feature->slip_feature['id']}}">
        <input type="hidden" name="feature_id[]" value="{{$feature->id}}">
        <input type="hidden" name="slip_feature_static_value[]" value="{{$feature->static_value}}">

      </div>
      <div class="col-sm-3">
        <select {{$feature->is_static_value==1 ? " readonly " : ""}} class="form-control" name="slip_feature_value_type[]" id="slip_feature_value_type_{{$feature->id}}" >
          <option value="0"
            @if ($feature->is_static_value==1)
              @if ($feature->slip_feature['static_value']>0)
                {{ $feature->slip_feature['value_type'] == 0 ? " selected " : "" }}
              @else
                {{ $feature->value_type == 0 ? " selected " : "" }}
              @endif
            @else
              {{ $feature->slip_feature['value_type'] == 0 ? " selected " : "" }}
            @endif
          >rupees
          </option>

          <option value="1"
          @if ($feature->is_static_value==1)
            @if ($feature->slip_feature['static_value']>0)
              {{ $feature->slip_feature['value_type'] == 1 ? " selected " : "" }}
            @else
              {{ $feature->value_type == 1 ? " selected " : "" }}
            @endif
          @else
            {{ $feature->slip_feature['value_type'] == 1 ? " selected " : "" }}
          @endif
            >% from basic salaray
          </option>
        </select>
      </div>
      @if ($feature->is_static_value==0)
        <button type="button" class="btn btn-danger btn-xs remove" data-feature-id="{{$feature->id}}">remove</button>
      @endif
      <div class="row">
        <span class="col-sm-8 text-right text-success value_from_feature" id="value_from_feature_{{$feature->id}}" data-allowence='0' data-deduction='0'></span>

      </div>
  </div>


  <script>
  $(document).ready(function() {
  function input_function() {
    var value_from_feature=0;
    var feature_type={{$feature->feature_type}};//1=allowence 0=deduction 2=demo
    var input_value=$("#slip_feature_value_{{$feature->id}}").val();
    var select_value_type=$("#slip_feature_value_type_{{$feature->id}}").val();//0=fixed value from salary 1=precentage
    var basic_salary=$('#basic_salary').text();
    if(select_value_type==0){
      value_from_feature=input_value;
    }
    else {//==1 precentage
      value_from_feature=basic_salary*(input_value/100);
    }


      if (feature_type==0) {
        $('#value_from_feature_{{$feature->id}}').attr('data-deduction',value_from_feature);
      }
      else if (feature_type==1) {
        $('#value_from_feature_{{$feature->id}}').attr('data-allowence',value_from_feature);

      }

      if (value_from_feature>0) {
        $('#value_from_feature_{{$feature->id}}').text('Rs. '+ value_from_feature);
      }
      else {
        $('#value_from_feature_{{$feature->id}}').text('');
      }

    var total_allowences=0;
    var total_deductions=0;

    $('.value_from_feature').each(function () {
      var allowence=parseFloat($(this).attr('data-allowence'))||0;
      var deduction=parseFloat($(this).attr('data-deduction'))||0;
      total_allowences+=allowence;
      total_deductions+=deduction;
    });
    var total_salary=parseFloat({{$ot_in_rs}})+parseFloat(basic_salary)+(total_allowences-total_deductions);
    total_salary=Number((total_salary).toFixed(2));
    $('.total_salary').text('Rs. '+total_salary);
    $('.total_deductions').text('Rs. '+total_deductions);
    $('.total_allowences').text('Rs. '+total_allowences);


  }

$("#slip_feature_value_{{$feature->id}}").on('keyup change paste input',input_function).change();
$("#slip_feature_value_type_{{$feature->id}}").on('keyup paste input',input_function).change();

  });
  </script>
