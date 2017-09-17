<form action="/attendence" method="POST">
  {{ csrf_field() }}
  <input type="hidden" name="salary_id" value='{{$salary->id}}' >
  <input type="hidden" name="branch_id" value='{{$branch->id}} '>

  <input type="hidden" name="employee_id" id="employee_id">


  <div id="attendence_editor_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:90%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit attendence data</h4>
        </div>
        <div class="modal-body">

          <div class="form-horizontal">

            <div class="form-group">
              <label class="col-sm-4 control-label">clock in time <i class="fa fa-sign-in" aria-hidden="true"></i></label>
              <div class="col-sm-3">
                <input type="hidden" name="start_datetime_attendence_id" id="start_datetime_attendence_id" >
                <input id="clock_in_datetime_picker" type="text" class="form-control datetime_picker_input" name="start_datetime" value=''>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">clock out time <i class="fa fa-sign-out" aria-hidden="true"></i></label>
              <div class="col-sm-3">
                <input type="hidden" name="end_datetime_attendence_id" id="end_datetime_attendence_id" >
                <input id="clock_out_datetime_picker" type="text" class="form-control datetime_picker_input" name="end_datetime" value=''>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">on leave <i class="fa fa-sun-o" aria-hidden="true"></i></label>
              <div class="col-sm-4">
                <div class="material-switch">
                  <input id="is_on_Leave" name="is_on_Leave" type="checkbox"/>
                  <label for="is_on_Leave" class="label-danger">
                  <input type="hidden" name="leave_id" id="leave_id">
                </div>
              </div>
            </div>
          </div>

          <div class="leave_section">
            @include('layouts/date_range_template')

          </div>


          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
          <input id="submit" type="submit" class="btn btn-primary update_attendence" value="update">
        </div>
      </div>

      </div>

    </div>
</form>

<style media="screen">
  .modal-dialog,
  .modal-content {
    /* 80% of window height */
    height: 90%;
  }

  .modal-body {
    /* 100% = dialog height, 120px = header + footer */
  height: calc(100% - 120px);
    /*overflow-y: scroll;*/
  }
</style>

<script>

  var clock_in_attendence_id=0;
  var clock_out_attendence_id=0;
  var leave_id=0;
  var employee_id=0;

  $('.update_attendence').click(function () {//modalform save buttton(submit button)
    // alert(clock_in_attendence_id);
    $('#start_datetime_attendence_id').val(clock_in_attendence_id);
    $('#end_datetime_attendence_id').val(clock_out_attendence_id);
    $('#leave_id').val(leave_id);
    $('#employee_id').val(employee_id);
  });

  $('#is_on_Leave').change(function () {
     if(this.checked){
        $('.leave_section').fadeIn();
     }
     else {
        $('.leave_section').fadeOut();
     }
    }).change(); //ensure visible state matches initially

</script>
