@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <h3><p class="text-center">ATTENDENCE</p></h3>

      <div class="panel panel-info">
        <div class="panel-heading">select salary month</div>
        <div class="panel-body">
          <div class="row">
              <div class="col-sm-4">
                  <div id="month_picker"></div>
              </div>
              <div class="col-sm-8">


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
              <div class="col-xs-12">
                <select id="branch_id"  name="branch_id" class="form-control" data-width="100%">
                </select>
              </div>
            </div>
            <div class="col-xs-6">
              <br>
              <button type="button" class="btn btn-warning btn-sm ">
                add finger print file
              </button>

              <button type="button" class="btn btn-danger btn-sm pull-right">
                upload data
              </button>

            </div>

          </div>
        </div>
      </div>
      {{-- <form class="form-horizontal" role="form" method="post" action="/employees">
        {{ csrf_field() }}
        @include('employees.form')
      </form> --}}
    </div>
  </div>
</div>


@endsection

@section('script')
  <script>
     SetDateTimePicker('#month_picker','YYYY/MM',true,true);

  </script>

@endsection
