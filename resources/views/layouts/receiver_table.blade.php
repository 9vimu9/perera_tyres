{{--receiver tabel  --/////////////////////////////////////////////////////////////--}}
  <input type="hidden" name="table_data_employee_id" id="table_data_employee_id">
  <div class="content">
    <table id="batch_receive_table" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 80%" >
        <thead>
            <tr>
                <th style="width: 40%">employee name</th>
                <th style="width: 25%">branch</th>
                <th style="width: 15%">category</th>
                <th style="width: 10%">
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal_search_bulk">
                    add employees
                  </button>
                </th>
                <th></th>  {{--for employee id  --}}


            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
  </div>
  {{-- eof tabel receiver table ////////////////////////////////////////////////////////////////////////////////--}}
