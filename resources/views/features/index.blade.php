@extends('layouts.modalform')

@section('title')ALLOWENCES AND DEDUCTIONS @endsection

@section('create_new')create new category @endsection

@section('table')
  @if (count($features)>0)
  <table id="features_index_table" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 100%" >
      <thead>
          <tr>
              <th style="width: 30%">name</th>
              <th style="width: 15%">type</th>
              <th style="width: 20%">value</th>
              <th style="width: 15%"></th>
          </tr>
      </thead>
      {{-- <tfoot>
       <tr>

           <th>year</th>
           <th>month</th>
           <th>from</th>
           <th>to</th>
           <th>budget allowence</th>
           <th></th>
       </tr>
     </tfoot> --}}

      <tbody>
            @foreach ($features as $feature)
            <tr>
              <td>{{$feature->name}}</td>
              <td>{{GetFeatureTypeName($feature->feature_type)}}</td>
              <td>
                @if ($feature->is_static_value)
                  {{ $feature->value_type==0 ? "Rs. $feature->static_value" : "$feature->static_value% from basic salary " }}
                @else
                  customize
                @endif
              </td>
              <td>
                <button type="button" class="btn btn-warning btn-xs edit" id='{{$feature->id}}' data-toggle="modal" data-target="#modalform_modal">edit</button> |
                <button type="button" class="btn btn-danger btn-xs delete" id='{{$feature->id}}'>delete</button>
              </td>
            </tr>
            @endforeach
      </tbody>
  </table>
  @endif
@endsection

@section('modal_form')

  <div class="form-horizontal">
    <div class="form-group">
      <label class="col-sm-4 control-label">allowence,deduction or demonstrate</label>
      <div class="col-sm-3">
        <select class="form-control" name="feature_type" id="feature_type">
          <option value="0">deduction</option>
          <option value="1">allowence</option>
          <option value="2">for slip only</option>
        </select>
      </div>
    </div>

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label class="col-sm-4 control-label">name</label>
      <div class="col-sm-5">
        <input id="name" type="text" class="form-control" name="name" >
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
      </div>
    </div>



    <div class="form-group">
      <label class="col-sm-4 control-label">same value/precentage for every employee</label>
        <div class="col-sm-8">
          <div class="material-switch"><strong>NO </strong>value can be vary from employee to employee
            <input id="is_static_value" name="is_static_value" type="checkbox"/>
              <label for="is_static_value" class="label-warning"></label><strong> YES </strong>same value for every employee
          </div>
      </div>
    </div>

    <div class="form-group{{ $errors->has('static_value') ? ' has-error' : '' }} static_value_div">
      <label class="col-sm-4 control-label">enter that value</label>
      <div class="col-sm-2">
        <input id="static_value" type="text" class="form-control" name="static_value">
      </div>
        <div class="col-sm-2">
          <select class="form-control" name="value_type" id="value_type">
            <option value="0">rupees</option>
            <option value="1">% from basic salaray</option>
          </select>
        </div>
    </div>



  </div>


@endsection

@section('form_script')
  <script>
    create_update_toggle('features','allowence/deduction');
    var table =$('#salarys_index').DataTable();

    $('#is_static_value').change(function () {
       $('.static_value_div').fadeToggle(this.checked);
      }).change(); //ensure visible state matches initially


    $('.edit').click(function () {
      var rowData = table.row( $(this).parents('tr') ).data();
      var year=rowData[0];
      var month=moment().month(rowData[1]).format("M");
      var start_date=rowData[2];
      var end_date=rowData[3];

      $('#month_picker').data("DateTimePicker").date(year+'/'+month);
      $('#start_date_picker').data("DateTimePicker").date(start_date);
      $('#end_date_picker').data("DateTimePicker").date(end_date);

    });

    $('.save').click(function () {
      var year_month=$('#month_picker').data('date').split('/');

      var start_date=$('#start_date_picker').data("date");
      var end_date=$('#end_date_picker').data("date");

      $('#year').val(year_month[0]);
      $('#month').val(year_month[1]);
      $('#start_date').val(start_date);
      $('#end_date').val(end_date);

    });

  </script>



@endsection
