{{-- sender modal ////////////////////////////////////////////////////////////////////////////////////////////////////--}}


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
                      <input class="material-child" id="material-child-id_{{$employee->id+10}}" name="ot_available" type="checkbox" />
                        <label for="material-child-id_{{$employee->id+10}}" class="label-warning"></label>
                    </div>
                  </td>



                </tr>

              @endforeach

            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="get_employees">add employees</button>
      </div>
    </div>
  </div>
</div>
{{-- end of  sender moal ///////////////////////////////////////////////////////////////////////////////--}}


<script>
$(document).ready(function() {
  function IsDuplicated(employee_id) {
    var IsDuplicated=false;
    batch_receive_table.column(4, { search:'applied' } ).data().each(function(value, index) {
      if(employee_id==value){
        IsDuplicated=true;
      }
    });
    return IsDuplicated;
  }

  $('#get_employees').click(function () {
    var array = [];
    batch_receive_table.column(4,{ search:'applied'}).data().each(function(value, index) {
      array.push(value);
    });

    $(".material-child").each(function () {
      var employee_id=$(this).attr('id').split('_')[1];
     console.log(IsDuplicated(employee_id));
    //  console.log(employee_id);

      if ($(this).is(':checked') && !IsDuplicated(employee_id)) {
        var row_detail = batch_search_table.row( $(this).parents('tr') ).data();

        //data[0] name   //data[1]branch   //2 cat    //3 checkbo html
        row_detail[3]='<button type="button" class="btn btn-warning btn-xs delete_row">remove</button>';
        row_detail[4]= employee_id;
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



  $("#parent_checkbox").click(function () {
   $(".material-child").each(function () {
       $(this).prop("checked", $('#parent_checkbox').is(':checked'));
   });

  });



});

</script>
