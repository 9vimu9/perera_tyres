@extends('layouts.app')

@section('content')

<div class="container">

  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <h3><p class="text-center">SALARIES</p></h3>

      <div class="panel panel-info">
        <div class="panel-heading">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#salarys_index_modal" onclick=" $('#modal_title').html('add new salary month'); $('#save').html('create'); ">
          create new month
        </button>
        </div>
        <div class="panel-body">
@if (count($salarys)>0)


          <table id="salarys_index" class="table table-striped table-hover " cellspacing="0" style="table-layout: fixed; width: 100%" >
              <thead>
                  <tr>
                      <th style="width: 12%">year</th>
                      <th style="width: 15%">month</th>
                      <th style="width: 20%">from</th>
                      <th style="width: 20%">to</th>
                      <th style="width: 12%">budget allowence(Rs)</th>
                      <th style="width: 20%"></th>

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
                        <td>{{$salary->budget_allowance->amount}}</td>
                      <td>
                        <button type="button" class="btn btn-basic btn-xs more" id='{{$salary->id}}'>more</button> |
                        <button type="button" class="btn btn-warning btn-xs edit" id='{{$salary->id}}' data-toggle="modal" data-target="#salarys_index_modal">edit</button> |
                        <button type="button" class="btn btn-danger btn-xs delete" id='{{$salary->id}}'>delete</button>

                      </td>
                    </tr>
                    @endforeach

              </tbody>
          </table>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="salarys_index_modal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-large ">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
            <p class="text-center">select month and year</p>
            <div id="month_picker"></div>
          </div>

          <div class="col-md-1"></div>

          <div class="col-md-3" >
            <p class="text-center">from</p>
            <div  class="date_picker" id="start_date"></div>
          </div>

          <div class="col-md-1"></div>

          <div class="col-md-3">
              <p class="text-center">to</p>
            <div  class="date_picker" id="end_date"></div>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
        <button id="save" type="button" class="btn btn-primary " data-dismiss="modal"></button>
      </div>
    </div>
  </div>
</div>




@endsection

@section('script')
  <script>
    SetDateTimePicker('#month_picker','YYYY/MM',true,true);
    SetDateTimePicker('.date_picker','YYYY/MM/DD',true,true);
    var updating_row;

    $('#save').click(function () {

      var year_month=$('#month_picker').data('date')
      var start_date=$('#start_date').data('date')
      var end_date=$('#end_date').data('date')

      var data={
        year:year_month.split('/')[0],
        month:year_month.split('/')[1],
        start_date:start_date,
        end_date:end_date
              }

      if($(this).text()=='create'){
        AjaxPOST(data,'/salaries','post');
      }
      else {
        data.method= 'PATCH';
        AjaxPOST(data,'/salaries/'+updating_row,'post');
      }
    //  location.reload();
    });
 //var table = $('#salarys_index').DataTable();
   $('.edit').click(function () {

     updating_row=$(this).attr('id');
     $('#save').html('update');
     $('#modal_title').html('edit salary month');
     var rowData = salarys_index_table.row( $(this).parents('tr') ).data();
     /// I defined this table as salarys_index_table at tables.js near line 4,5,6
     var year=rowData[0];
     var month=moment().month(rowData[1]).format("M");
     var start_date=rowData[2];
     var end_date=rowData[3];

      $('#month_picker').data("DateTimePicker").date(year+'/'+month);
     $('#start_date').data("DateTimePicker").date(start_date);
     $('#end_date').data("DateTimePicker").date(end_date);


   });

  </script>

@endsection
