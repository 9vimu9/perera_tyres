

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

//////////////////////////////select2suggestion calls/////////////////
GetSuggestionsForSelect2("#cat_id",'name','cats');
GetSuggestionsForSelect2("#branch_id",'name','branchs');
GetSuggestionsForSelect2("#designation_id",'name','designations');

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


//////////////////////////////tables/////////////////////////



///////////////////////////salarys.index table/////////////////////
$(document).ready(function() {
    // DataTable
    var table =   $('#salarys_index').DataTable({
          'paging'      : false,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : false,
          'autoWidth'   : false

        });
    var array = {
      0:"year_only_picker",//table column:id naem
      1:"month_only_picker",
      2:'date_picker_1',
      3:'date_picker_2'};

    AddColumnSearch(table,array,'#salarys_index');
} );
////////////////////////////// eof salarys.index ////////////////////








////////////////////////////////////table functions/////////////////////
//this function will add search textbox for specific column
function AddColumnSearch(table,selected_columns,table_id) {

  $.each(selected_columns, function (key, value) {
    $(table_id+' tfoot th:eq('+key+')').html( '<input  type="text" id="'+value+'" />' );
  });

  table.columns().every( function () {
      var that = this;

      $( 'input', this.footer() ).on( 'keyup change', function () {
          if ( that.search() !== this.value ) {
              that.search( this.value ).draw();
          }
      } );
  } );
}
//////////////////////////eof tables functions////////////////////////



//////////////////////////////////ajax sellam////////////////////
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

function AjaxPOST(data,url,type) {
  $.ajax({
    url: url,
    type: type,
    data: data,
    dataType: 'JSON',
    success: function (data) {
        console.log(data);
    },

    error: function(data){
      var errors = data.responseJSON;
       console.log(errors);
       // Render the errors with js ...
     }
  });
}
