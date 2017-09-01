
//////////////////////////////select2suggestion calls/////////////////
GetSuggestionsForSelect2("#cat_id",'name','cats',0);
GetSuggestionsForSelect2("#branch_id",'name','branchs',0);
GetSuggestionsForSelect2("#designation_id",'name','designations',0);
GetSuggestionsForSelect2("#holiday_type_id",'name','holiday_types',0);
GetSuggestionsForSelect2("#leave_type_id",'name','leave_types',0);
GetSuggestionsForSelect2("#employee_id",'name','employees',0);
GetSuggestionsForSelect2("#allowence_not_compulsory_id",'name','features',1);


///////////////////////////eof selct2 suggestion cals//////////////////////

function GetSuggestionsForSelect2(select2_id,showingCol,table,no) {

  $(select2_id).select2({
        //  theme: "bootstrap",
          minimumInputLength: 1,
          placeholder:"",
          allowClear: true,
          ajax: {
              url: '/get_suggestions_for_select2',
              dataType: 'json',
              data: function (params) {
                  return {
                      id:no,
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
