// $('[id^="date_picker"]').datetimepicker({
//     format: 'YYYY/MM/DD'
// });
//
//
// $('[id^="time_picker"]').datetimepicker({
//     format: 'HH:mm'
// });

$('.date_picker_input').datetimepicker({
    format: 'YYYY/MM/DD'
});

$('.datetime_picker_input').datetimepicker({
    format: 'YYYY/MM/DD HH:mm'
});


$('.time_picker_input').datetimepicker({
    format: 'HH:mm'
});
SetDateTimePicker('.datetime_picker_fix','YYYY/MM/DD HH:mm',true,true);

SetDateTimePicker('.date_picker_fix','YYYY/MM/DD',true,true);
SetDateTimePicker('.month_picker_fix','YYYY/MM',true,false);

function SetDateTimePicker(id,format,is_inline,is_sideBySide) {
  $(id).datetimepicker({
      format: format,
      inline: is_inline,
      sideBySide: is_sideBySide
  });

}
