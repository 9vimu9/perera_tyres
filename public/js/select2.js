
//////////////////////////////select2suggestion calls/////////////////
GetSuggestionsForSelect2("#cat_id",'name','cats');
GetSuggestionsForSelect2("#branch_id",'name','branchs');
GetSuggestionsForSelect2("#designation_id",'name','designations');
GetSuggestionsForSelect2("#holiday_type_id",'name','holiday_types');

///////////////////////////eof selct2 suggestion cals//////////////////////

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
