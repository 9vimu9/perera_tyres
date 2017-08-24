@extends('layouts.modalform')

@section('title')EMPLOYEE LEAVES @endsection

@section('create_new')ask for a leave @endsection

@section('table')
  @if (count($leaves)>0)
  <table id="leaves_index" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 100%" >
      <thead>
          <tr>
              <th style="width: 12%">branch</th>
              <th style="width: 15%">category</th>
              <th style="width: 20%">employee name</th>
              <th style="width: 20%">reason</th>
              <th style="width: 20%">from</th>
              <th style="width: 20%">to</th>
              <th style="width: 20%">duration</th>
              <th style="width: 15%"></th>

          </tr>
      </thead>
      {{-- <tfoot>
       <tr>

         <th>branch</th>
         <th>category</th>
         <th>employee name</th>
         <th>reason</th>
         <th>from</th>
         <th>to</th>
         <th>duration</th>
         <th></th>
       </tr>
     </tfoot> --}}

      <tbody>
            @foreach ($leaves as $leave)
            <tr>
              <td>{{$leave->employee->branch->name}}</td>
              <td>{{$leave->employee->cat->name}}</td>
              <td>{{$leave->employee->name}}</td>
              <td>{{$leave->leave_type->name}}</td>
              <td>{{$leave->from_datetime}}</td>
              <td>{{$leave->to_datetime}}</td>
              <td>duration</td>
              <td>
                <button type="button" class="btn btn-basic btn-xs more" id='{{$leave->id}}'>more</button> |
                <button type="button" class="btn btn-warning btn-xs edit" id='{{$leave->id}}' data-toggle="modal" data-target="#salarys_index_modal">edit</button> |
                <button type="button" class="btn btn-danger btn-xs delete" id='{{$leave->id}}'>delete</button>

              </td>
            </tr>
            @endforeach

      </tbody>
  </table>
  @endif

  {{-- sender modal --}}
  <div class="modal fade" id="modal_search_bulk" aria-hidden="true">
    <div class="modal-dialog" style="width:90%;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Get Employees</h5>
        </div>
        <div class="modal-body">
          <div class="form-horizontal">
            <div class="form-group">
              <label class="col-sm-4 control-label">workpalce name</label>
              <div class="col-sm-5">
                <select id="branch_id"  name="branch_id" class="form-control" data-width="100%"></select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">category</label>
              <div class="col-sm-5">
                <select id="cat_id"  name="cat_id" class="form-control" data-width="100%"></select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">employee name</label>
              <div class="col-sm-5">
                <select id="employee_id"  name="employee_id" class="form-control" data-width="100%"></select>
              </div>
            </div>

          </div>

          <table id="batch_search_table" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 80%" >
              <thead>
                  <tr>
                      <th style="width: 40%">employee name</th>
                      <th style="width: 25%">branch</th>
                      <th style="width: 15%">category</th>
                      <th style="width: 10%">
                        <div class="material-switch">
                          <input id="parent_checkbox" name="ot_available" type="checkbox" />
                            <label for="parent_checkbox" class="label-danger"></label>
                        </div>
                      </th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($employees as $employee)
                  <tr>

                    <td>{{$employee->name}}</td>
                    <td>{{$employee->branch->name}}</td>
                    <td>{{$employee->cat->name}}</td>
                    <td>
                      <div class="material-switch ">
                        <input class="material-child" id="{{$employee->id}}" name="ot_available" type="checkbox" />
                          <label for="{{$employee->id}}" class="label-warning"></label>
                      </div>
                    </td>


                  </tr>

                @endforeach

              </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="get_employees">add employyes</button>
        </div>
      </div>
    </div>
  </div>
  {{-- end of  sender moal --}}


@endsection

@section('modal_form')



{{--tabel  --}}
  <div class="content">
    <table id="batch_receive_table" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 80%" >
        <thead>
            <tr>
                <th style="width: 40%">employee name</th>
                <th style="width: 25%">branch</th>
                <th style="width: 15%">category</th>
                <th style="width: 10%">
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_search_bulk">
                    add employees
                  </button>
                </th>
                {{--for employee id  --}}
                <th></th>


            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
  {{-- eof tabel --}}

  <div class="form-horizontal">
      <div class="form-group{{ $errors->has('leave_type_id') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label">leave type</label>
        <div class="col-sm-5">
          <select id="leave_type_id"  name="leave_type_id" class="form-control" data-width="100%">
            @if (isset($leave))
              <option value="{{$leave->leave_type->id}}" >
                {{$leave->leave_type->name}}
              </option>
            @endif
          </select>

          @if ($errors->has('leave_type_id'))
              <span class="help-block">
                  <strong>{{ $errors->first('leave_type_id') }}</strong>
              </span>
          @endif
        </div>
      </div>
    <div class="row">
      <div class="col-md-1"></div>

      <div class="col-md-4" >
        <p class="text-center">from</p>
        <div  class="datetime_picker_fix" id="start_date_picker"></div>
        <input type="hidden" name="start_date" id="start_date">
      </div>

<div class="col-md-2"></div>
      <div class="col-md-4">
          <p class="text-center">to</p>
        <div  class="datetime_picker_fix" id="end_date_picker"></div>
        <input type="hidden" name="end_date" id="end_date">
      </div>
    </div>
  </div>


@endsection

@section('form_script')

  <script>

    // function IsDuplicated(employee_id) {
    //   batch_receive_table.column(2, { search:'applied' } ).data().each(function(value, index) {
    //     if(employee_id==value){
    //       alert('dup');
    //     }
    //   });
    // }
    $('#get_employees').click(function () {

      let array = [];
      batch_receive_table.column(4,  { search:'applied' } ).data().each(function(value, index) {
        array.push(value);
      });
      alert(array);
      $(".material-child").each(function () {
        // IsDuplicated($(this).attr('id'));
        let obj = array.find(o=>o  == $(this).attr('id'));
alert(obj);
        if ($(this).is(':checked')) {
          var row_detail = batch_search_table.row( $(this).parents('tr') ).data();

          //data[0] name   //data[1]branch   //2 cat    //3 checkbo html
          row_detail[3]='<button type="button" class="btn btn-warning btn-xs delete_row">remove</button>';
          row_detail[4]= $(this).attr('id');
          batch_receive_table.rows.add([row_detail]).draw();
        }

      });


    });

  function Select2ColumnSearch(table,column_id,selecter) {
    $(selecter).on('change', function(){
      var text=$(this).select2('data')[0].text;
      table.column(column_id).search(text).draw();
    });
    $(selecter).on("select2:unselecting", function (e) {
      table.column(column_id).search("").draw();
    });
  }

  Select2ColumnSearch(batch_search_table,0,'#employee_id');
  Select2ColumnSearch(batch_search_table,1,'#branch_id');
  Select2ColumnSearch(batch_search_table,2,'#cat_id');



    var modal_lv = 0;
    $('.modal').on('shown.bs.modal', function (e) {
        $('.modal-backdrop:last').css('zIndex',1051+modal_lv);
        $(e.currentTarget).css('zIndex',1052+modal_lv);
        modal_lv++
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        modal_lv--
    });



    create_update_toggle('leaves','leave');
    var table =   $('leaves_index').DataTable();

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
    $("#parent_checkbox").click(function () {
     $(".material-child").each(function () {
         $(this).prop("checked", $('#parent_checkbox').is(':checked'));
     });

    });


    //   $('.save').click(function () {
    //   var year_month=$('#month_picker').data('date').split('/');
    //
    //   var start_date=$('#start_date_picker').data("date");
    //   var end_date=$('#end_date_picker').data("date");
    //
    //   $('#year').val(year_month[0]);
    //   $('#month').val(year_month[1]);
    //   $('#start_date').val(start_date);
    //   $('#end_date').val(end_date);
    //
    //
    // });


   </script>
 @endsection
