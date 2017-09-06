@extends('layouts.modalform')

@section('title')
  <h3 class="text-center">
    REMUNERATION RECORD
    @isset($slips)
    for {{date("F", mktime(0, 0, 0, $slips[0]->salary->month, 10))}},{{$slips[0]->salary->year}}
    <br>
    <strong>{{$slips[0]->employee->branch->name}}</strong>
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
  {{-- <table id="slips_index_table" class="display nowrap" cellspacing="0" width="100%"> --}}
<table id="slips_index_table" class="table table-bordered  " cellspacing="0" style="table-layout: fixed" >
      <thead>
        <tr>
            <th rowspan="2">Evaluation</th>
            <th rowspan="2">Approval</th>
            <th colspan="2">points</th>
            <th rowspan="2">Total</th>
            <th rowspan="2">Date</th>
            <th rowspan="2">Award Amount</th>
            <th rowspan="2"> Last Modified By</th>
            <th rowspan="2">Total</th>
            <th rowspan="2">Date</th>
            <th rowspan="2">Award Amount</th>
            <th rowspan="2"> Last Modified By</th>
        </tr>
        <tr>
            <th> Tangible </th>
            <th> Intangible </th>
        </tr>

      </thead>

      <tbody>
            @foreach ($slips as $slip)
              @if ($slip->employee->branch_id==$branch_id)
                <tr>
           <td>Al/GL</td>
           <td>Select</td>
           <td>col1</td>
           <td>col2</td>
           <td>col3</td>
           <td>col4</td>
           <td>col5</td>
           <td>col2</td>
           <td>col3</td>
           <td>col4</td>
           <td>col5</td>
                  <td>
                    <a href="/slips/{{$slip->id}}" class="btn btn-warning btn-xs more"><i class="fa fa-plus" aria-hidden="true"></i> / <i class="fa fa-minus" aria-hidden="true"></i></a>
                  </td>
                </tr>
              @endif
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

    ///////////////////////////////////////////////////////
    var table = $('#slips_index_table').DataTable({

      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      searching   : true,
      ordering    : true,
      info        : true
    });

    /////////////////////////////////////////////////////////

  </script>



@endsection
