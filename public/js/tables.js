
///////////////////////////salarys.index table/////////////////////


    var salarys_index_table =   $('#salarys_index').DataTable({
          'paging'      : false,
          'lengthChange': true,
          'searching'   : true,
          'ordering'    : true,
          'info'        : false,
          'autoWidth'   : false

        });

    var searchArray = {
      0:"year_only_picker",//table column:id naem
      1:"month_only_picker",
      2:'date_picker_1',
      3:'date_picker_2',
      4:'budget_allowance'
    };

    AddColumnSearch(salarys_index_table,searchArray,'#salarys_index');

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
