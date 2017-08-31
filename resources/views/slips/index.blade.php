@extends('layouts.modalform')

@section('title')
  <h3 class="text-center">
    REMUNERATION RECORD
    @isset($salary_month)

    @endisset
  </h3>

  <h4 class="text-center">
    @isset($salary_month)

    @endisset
  </h4>

@endsection

@section('create_new')select salary month @endsection

@section('table')
  @if (isset($slips) && count($slips)>0)
  <table id="slips_index_table" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 100%" >
      <thead>
          <tr>
              <th style="width: 22%">name</th>
              <th style="width: 15%">designation</th>
              <th style="width: 22%">branch</th>
              <th style="width: 15%">category</th>
              <th style="width: 15%">basic salary</th>
              <th style="width: 10%"></th>
          </tr>
      </thead>

      <tbody>
            @foreach ($slips as $slip)

            <tr>
              <td>{{$slip->employee->name}}</td>
              <td>{{$slip->employee->designation->name}}</td>
              <td>{{$slip->employee->branch->name}}</td>
              <td>{{$slip->employee->cat->name}}</td>
              <td>{{$slip->salary->budget_allowence+$slip->basic_salary}}</td>

              <td>
                {{-- <button type="button" class="btn btn-warning btn-xs more" id='{{$slip->id}}'>all/ded</button> | --}}
                <a href="#" class="btn btn-warning btn-xs more"><i class="fa fa-plus" aria-hidden="true"></i> / <i class="fa fa-minus" aria-hidden="true"></i></a>
              </td>
            </tr>
            @endforeach
      </tbody>
  </table>
  @endif

@endsection

@section('modal_form')

  @include('layouts.salary_month_selector')
  <input type="hidden" name="salary_id" id="salary_id" >
  <div class="form-horizontal form-group ">
    <label class="col-sm-3 control-label">workpalce name</label>
    <div class="col-sm-4">
      <select id="branch_id"  name="branch_id" class="form-control" data-width="100%"></select>
    </div>
  </div>


@endsection

@section('form_script')
  <script>
    // create_update_toggle('features','allowence/deduction');
    Route_call('index_with_slips','select salary month','get','create slips');

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
