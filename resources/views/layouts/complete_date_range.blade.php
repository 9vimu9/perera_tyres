
<div class="form-group">
  <div class="col-sm-1">
    <div class="material-switch">
      <input id="range_by_salary" name="range_by_salary" type="checkbox"  class="checkbox"/>
        <label for="range_by_salary" class="label-warning"></label>
    </div>
  </div>
  <label class="control-label">get date range by salary session</label>
</div>
<br>
@include('layouts.salary_month_selector')
{{-- $salary_id for salary_month_selector --}}
<br>
<div class="form-group">
  <div class="col-sm-1">
    <div class="material-switch">
      <input id="range_by_custom" name="range_by_custom" type="checkbox" class="checkbox"/>
        <label for="range_by_custom" class="label-warning"></label>
    </div>
  </div>
  <label class="control-label">get custom date range</label>
</div>
<br>
@include('layouts/date_range_template')


<script>

$('.checkbox').click(function(){
    $('.checkbox').each(function(){
        $(this).prop('checked', false);
    });
    $(this).prop('checked', true);
});




</script>
