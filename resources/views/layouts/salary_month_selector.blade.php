<div class="row">

  <div class="col-sm-2"></div>
    <div class="col-sm-4">
        <div id="month_picker" class="month_picker_fix"></div>
    </div>
    <div class="col-sm-4 text-center">
      <div class="salary_month_display">
        <h3><p class="text-center" id="year"></p></h3>
        <h3><p class="text-center" id="month"></p></h3>
        <hr>
        <h4><p class="text-center" id="start_date"></p></h4>
        <h4><p class="text-center" >to</p></h4>
        <h4><p class="text-center" id="end_date"></p></h4>
      </div>


      <div class="no_salary_month_dispaly ">
        <h4><p class="text-center">no salary session created</p></h4>
        <a href="/salaries" class="btn btn-info btn-sm ">new salary month</a>
      </div>

    </div>

</div>

<script>
$(document).ready(function() {
  month_picker_change();

  function month_picker_change(){
          var year_month=$('#month_picker').data('date')
          var year=year_month.split('/')[0];
          var month=year_month.split('/')[1];
          queryData={year:year,month:month};

          AjaxGetData(1,'get',queryData).success(function (data) {
            if (data[0]==null) {
              $('.salary_month_display').hide();
                $('.no_salary_month_dispaly').show();
            }
            else
            {
              $('.no_salary_month_dispaly').hide();
              $('.salary_month_display').show();
              $('#month').html(moment(data[0].month, 'MM').format('MMMM'));
              $('#year').html(data[0].year);
              $('#start_date').html(data[0].start_date);
              $('#end_date').html(data[0].end_date);
              $('#salary_id').val(data[0].id);
          }
          });
      }
$('#month_picker').on('dp.change', month_picker_change)

  });
</script>
