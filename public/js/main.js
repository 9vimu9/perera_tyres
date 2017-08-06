
/////////////////////////////////time date picker//////////////
$('[id^="date_picker"]').datetimepicker({
    format: 'YYYY/MM/DD'
});
  $('[id^="time_picker"]').datetimepicker({
    format: 'HH:mm'
});
/////////////////////////////////end of tim date picker/////////////////





function GetSuggestionsForSelect2(select2_id,showingCol,table) {

  $(select2_id).select2({
        //  theme: "bootstrap",
          minimumInputLength: 1,
          ajax: {
              url: '/get_suggestions_for_select2',
              dataType: 'json',
              data: function (params) {
                console.log(params.term);
                  return {
                      q: $.trim(params.term),
                      c:showingCol,
                      t:table
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data, function(obj)
                      {

                           return { id: obj.id, text: obj.value };

                      })
                  };
              },
              cache: true
          }
      });




}
