///////////////////////////////////////leaves_index_table/////////////////////////

var leaves_index_table =   $('#leaves_index_table').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false,
      "order"       : [[ 4, "desc" ]]

    });


///////////////////////////////////////eof leaves_index_table//////////////////////




////////////////////////////////batch_receiver_table//////////////////
var batch_receive_table =   $('#batch_receive_table').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false

    });
    batch_receive_table.column(4).visible(false);


/////////////////////////////eof batch_receiver_table/////////////////

///////////////////////////////batch_search_tbl///////////////////////////
var batch_search_table =   $('#batch_search_table').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false

    });
/////////////////////////////////eof batch search tabe//////////////////
///////////////////////////salarys.index table/////////////////////


    var salarys_index_table =   $('#salarys_index').DataTable({
          'paging'      : true,
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

///////////////////////////////emloyees.index///////////////////////////////
var employees_index_table =   $('#employees_index').DataTable({
    scrollY:        '300px',
   scrollX:        true,
   scrollCollapse: true,
    paging:         true,
    searching   : true,
    ordering    : true,
    info        : true,
    autoWidth   : true,
    dom         : 'Bfrtip',
    buttons     : [

               {
              extend: 'pdfHtml5',
              orientation: 'landscape',
              pageSize: 'LEGAL',
              title:'employee details',
              exportOptions: {
                  columns: [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12 ]
             }
          }
        ]

    });





    // var searchArray = {
    //   0:"branch",//table column:id date
    //   1:"name"
    // };
    //
    // AddColumnSearch(employees_index_table,searchArray,'#employees_index');
//////////////////////////////////eof emplouees.index////////////////////

/////////////////////////////////holidays.index table//////////////////////////////

var holidays_index_table =   $('#holidays_index').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });

    var searchArray = {
      0:"date",//table column:id date
      1:"name"
    };

    AddColumnSearch(holidays_index_table,searchArray,'#holidays_index');

////////////////////////////////////eof holidays.index////////////////////////////////




var employee_attendence_index =   $('#employee_attendence_index').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });

var salarys_index_table =   $('#input_fingerprint_data').DataTable({
      'paging'      : false,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });


    var attendence_index = $('#attendence_index').DataTable( {
        scrollY:        '400px',
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        searching   : true,
        ordering    : false,
        info        : false,

    } );



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
