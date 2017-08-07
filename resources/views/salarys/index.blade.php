@extends('layouts.app')

@section('content')

<div class="container">

  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <h3><p class="text-center">SALARIES</p></h3>

      <div class="panel panel-info">
        <div class="panel-heading">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#salarys_index_modal">
          create new month
        </button>
        </div>
        <div class="panel-body">

          <table id="salarys_index" class="table table-striped table-hover " cellspacing="0" style="table-layout: fixed; width: 100%" >
              <thead>
                  <tr>
                      <th style="width: 15%">year</th>
                      <th style="width: 15%">month</th>
                      <th style="width: 20%">from</th>
                      <th style="width: 20%">to</th>
                      <th style="width: 20%"></th>

                  </tr>
              </thead>
              <tfoot>
               <tr>
                   <th>year</th>
                   <th>month</th>
                   <th>from</th>
                   <th>to</th>
                   <th></th>
               </tr>
             </tfoot>

              <tbody>
                  <tr>
                      <td>2017</td>
                      <td>march</td>
                      <td>2017/12/20</td>
                      <td>2017/04/23</td>
                      <td>
                        <button type="button" class="btn btn-basic btn-xs">more</button> |
                        <button type="button" class="btn btn-warning btn-xs">edit</button> |
                        <button type="button" class="btn btn-danger btn-xs">delete</button>

                      </td>

                  </tr>
                  <tr>
                      <td>Garrett Winters</td>
                      <td>Accountant</td>
                      <td>Tokyo</td>
                      <td>63</td>
                      <td>2011/07/25</td>

                  </tr>

              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="salarys_index_modal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-large ">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title">add new salary month</h4>
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
        <button id="create" type="button" class="btn btn-primary" data-dismiss="modal">create</button>
      </div>
    </div>
  </div>
</div>




@endsection

@section('script')
  <script>
    SetDateTimePicker('#month_picker','YYYY/MM',true,true);
    SetDateTimePicker('.date_picker','YYYY/MM/DD',true,true);

    $('#create').click(function () {
      var year_month=$('#month_picker').data('date')
      var start_date=$('#start_date').data('date')
      var end_date=$('#end_date').data('date')

      var data={
        _token: CSRF_TOKEN,
        year:year_month.split('/')[0],
        month:year_month.split('/')[1],
        start_date:start_date,
        end_date:end_date
              }

      AjaxPOST(data,'/salaries','post');
    });

  </script>

@endsection
