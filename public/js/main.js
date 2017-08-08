

/////////////////////////////////time date picker//////////////


  $('[id^="date_picker"]').datetimepicker({
      format: 'YYYY/MM/DD'
  });


  $('[id^="time_picker"]').datetimepicker({
      format: 'HH:mm'
  });

  function SetDateTimePicker(id,format,is_inline,is_sideBySide) {
    $(id).datetimepicker({
        format: format,
        inline: is_inline,
        sideBySide: is_sideBySide
    });

  }


/////////////////////////////////end of tim date picker/////////////////
