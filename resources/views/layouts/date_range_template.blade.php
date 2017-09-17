<div class="row">
  <div class="col-md-1"></div>

  <div class="col-md-4" >
    <p class="text-center">from</p>
    <div  class="datetime_picker_fix" id="from_datetime_picker"></div>
    <input type="hidden" name="from_datetime" id="from_datetime">

  </div>

<div class="col-md-2"></div>
  <div class="col-md-4">
      <p class="text-center">to</p>
      <div  class="datetime_picker_fix" id="to_datetime_picker"></div>
      <input type="hidden" name="to_datetime" id="to_datetime">
  </div>
</div>

<script>

$( document ).ready(function() {

$('.save').click(function () {//modalform save buttton(submit button)
  var from_datetime=$('#from_datetime_picker').data("date");
  var to_datetime=$('#to_datetime_picker').data("date");
  $('#from_datetime').val(from_datetime);
  $('#to_datetime').val(to_datetime);
});

});


</script>
