@extends('layouts.app')

@section('content')

<div class="container">


      <h3><p class="text-center">ATTENDENCE</p></h3>

      <div class="panel panel-info">
        <div class="panel-heading">select salary month</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-1"></div>
              <div class="col-sm-5">
                  <div id="month_picker" class="month_picker_fix"></div>
              </div>
              <div class="col-sm-5">
                <h3><p class="text-center" id="year">2017</p></h3>
                <h3><p class="text-center" id="month">oct</p></h3>
                <hr>
                <h4><p class="text-center" id="start_date">2017-05-23</p></h4>
                <h4><p class="text-center" >to</p></h4>

                <h4><p class="text-center" id="end_date">2017-06-23</p></h4>

              </div>
          </div>
        </div>
      </div>
      <div class="panel panel-success">
        <div class="panel-heading">get attendence data using finger print machine</div>
        <div class="panel-body">
          <div class="form-inline">
            <div class="col-xs-6">
              <label class="col-xs-12 control-label">company</label>

              <form  action="attendence/new_sheet" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                <input type="hidden" name="salarys_id" id="salarys_id" >

              <div class="col-xs-12">
                <select id="branch_id"  name="branch_id" class="form-control" data-width="100%">
                </select>
              </div>
            </div>
            <div class="col-xs-6">
              <br>
              <span class="btn btn-warning btn-sm btn-file">
                upload file
                 <input type="file" name="fileToUpload" id="fileToUpload">
              </span>

              <input type="submit" class="btn btn-danger btn-sm pull-right" value="mark attendence">

              </form>
            </div>
          </div>
          <br>
          <hr>
        </div>
      </div>


</div>

@endsection

@section('script')
  <script>
  var selected_branch_id=0;

     $dataepicker_change_event=$('#month_picker').on('dp.change', function(){
          var year_month=$('#month_picker').data('date')
          var year=year_month.split('/')[0];
          var month=year_month.split('/')[1];
          queryData={year:year,month:month};

          AjaxGetData(1,'get',queryData).success(function (data) {

            $('#month').html(moment(data[0].month, 'MM').format('MMMM'));
            $('#year').html(data[0].year);
            $('#start_date').html(data[0].start_date);
            $('#end_date').html(data[0].end_date);
            $('#salarys_id').val(data[0].id);
          });
      })

      $('#branch_id').on('select2:select', function (evt) {
        var selected_branch_id=evt.params.data.id;
   });


  </script>
@endsection
