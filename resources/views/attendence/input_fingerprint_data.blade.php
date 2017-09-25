@extends('layouts.app')

@section('content')

<div class="container">


      <h3><p class="text-center">MARK ATTENDENCE</p></h3>

      <div class="panel panel-info">
        <div class="panel-heading">select salary month</div>
        <div class="panel-body">
          @include('layouts.salary_month_selector')

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
                <input type="hidden" name="salary_id" id="salary_id" >

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
