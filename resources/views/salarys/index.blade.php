@extends('layouts.modalform')

@section('title')SALARIES @endsection

@section('optional_space')
  <form class="form-horizontal" role="form" method="post" action="/salaries/update_budget_allowence">
    {{ csrf_field() }}
    <div class="panel panel-danger">
      <div class="panel-heading">update budget allowence</div>
      <div class="panel-body">
          <div class="form-group{{ $errors->has('budget_allowence') ? ' has-error' : '' }}">
            <label class="col-sm-4 control-label">budget allowence(Rs.)</label>
            <div class="col-sm-3">
              <input id="budget_allowence" type="text" class="form-control" name="budget_allowence" value="{{MetaGet('budget_allowence')}}">
              @if ($errors->has('budget_allowence'))
                  <span class="help-block">
                      <strong>{{ $errors->first('budget_allowence') }}</strong>
                  </span>
              @endif
            </div>
            <button type="submit" class="btn btn-primary">save</button>
          </div>
      </div>
    </div>
  </form>

@endsection


@section('create_new')create new salary @endsection

@section('table')
  @if (count($salarys)>0)
  <table id="salarys_index" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 100%" >
      <thead>
          <tr>
              <th style="width: 12%">year</th>
              <th style="width: 15%">month</th>
              <th style="width: 20%">from</th>
              <th style="width: 20%">to</th>
              <th style="width: 20%">budget allowence(Rs)</th>
              <th style="width: 15%"></th>

          </tr>
      </thead>
      <tfoot>
       <tr>

           <th>year</th>
           <th>month</th>
           <th>from</th>
           <th>to</th>
           <th>budget allowence</th>
           <th></th>
       </tr>
     </tfoot>
     <tbody>
            @foreach ($salarys as $salary)
            <tr>
              <td>{{$salary->year}}</td>
              <td>{{date("F", mktime(0, 0, 0, $salary->month, 10))}}</td>
              <td>{{$salary->start_date}}</td>
              <td>{{$salary->end_date}}</td>
              <td>{{$salary->budget_allowence}}</td>
                <form action="/salaries/{{$salary->id}}" class="pull-right" method="POST">
                  {{ csrf_field() }}
                  <td>
                    <button type="button" class="btn btn-warning btn-xs edit" id='{{$salary->id}}' data-toggle="modal" data-target="#modalform_modal">edit</button> |
                    <input type="submit" name="delete" value="remove" class="btn btn-danger btn-xs">
                    <input type="hidden" name="_method" value="DELETE">
                  </td>
                </form>
            </tr>
            @endforeach

      </tbody>
  </table>
  @endif
@endsection

@section('modal_form')
  <div class="row">
    <div class="col-md-3">
      <p class="text-center">select month and year</p>
      <div id="month_picker" class="month_picker_fix"></div>
        <input type="hidden" name="month" id="month" >
        <input type="hidden" name="year" id="year">
    </div>

    <div class="col-md-1"></div>

    <div class="col-md-3" >
      <p class="text-center">from</p>
      <div  class="date_picker_fix" id="start_date_picker"></div>
      <input type="hidden" name="start_date" id="start_date">
    </div>

    <div class="col-md-1"></div>

    <div class="col-md-3">
        <p class="text-center">to</p>
      <div  class="date_picker_fix" id="end_date_picker"></div>
      <input type="hidden" name="end_date" id="end_date">
    </div>
  </div>

@endsection

@section('form_script')
  <script>
    create_update_toggle('salaries','salary');
    var table =   $('#salarys_index').DataTable();

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
