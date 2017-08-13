@extends('layouts.modalform')

@section('title')HOLIDAYS @endsection

@section('create_new')create new holiday @endsection

@section('table')


  @if (count($holidays)>0)
  <table id="holidays_index" class="table table-striped table-hover " cellspacing="0" style="table-layout: fixed; width: 65%" >
      <thead>
          <tr>
              <th style="width: 30%">date</th>
              <th style="width: 50%">holiday name</th>
              <th style="width: 20%"></th>

          </tr>
      </thead>
      <tfoot>
       <tr>
           <th>date</th>
           <th>holiday name</th>
           <th></th>
       </tr>
     </tfoot>

      <tbody>
            @foreach ($holidays as $holiday)
            <tr>
              <td>{{$holiday->date}}</td>
              <td>{{$holiday->holiday_type->name}}</td>
              <td>
                <button type="button" class="btn btn-warning btn-xs edit" id='{{$holiday->id}}' data-toggle="modal" data-target="#salarys_index_modal">edit</button> |
                <button type="button" class="btn btn-danger btn-xs delete" id='{{$holiday->id}}'>delete</button>
              </td>
            </tr>
            @endforeach
      </tbody>
  </table>
  @endif
@endsection

@section('modal_form')
<div class="row">
  <div class="col-sm-3"></div>

  <div class="col-md-6" >
    <p class="text-center">select holiday date</p>
    <input type="hidden" name="date" id="selected_date">
    <div id='calendar'></div>
    <p class="text-center">select holiday type</p>
    <select id="holiday_type_id"  name="holiday_type_id" class="form-control" data-width="100%">
    </select>
  </div>

</div>

@endsection

@section('form_script')
  <script>

    $('#holiday_type_id').on('select2:select', function (evt) {
      var selected_holiday_type_id=evt.params.data.id;
  });
    create_update_toggle('holidays','holiday');

    
  </script>



@endsection
