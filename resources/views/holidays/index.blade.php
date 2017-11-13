@extends('layouts.modalform')

@section('title')HOLIDAYS @endsection

@section('create_new')create new holiday @endsection

@section('table')


  @if (count($holidays)>0)
  <table id="holidays_index" class="table table-striped table-hover table-center " cellspacing="0" style="table-layout: fixed; width: 65%" >
      <thead>
          <tr>
              <th style="width: 30%">date</th>
              <th style="width: 50%">holiday name</th>
              <th style="width: 20%"></th>

          </tr>
      </thead>
      <tbody>
            @foreach ($holidays as $holiday)
            <tr>
              <td>{{$holiday->date}}</td>
              <td>{{$holiday->holiday_type->name}}</td>

              <form action="/holidays/{{$holiday->id}}" class="pull-right" method="POST">
                {{ csrf_field() }}
                <td>
                  <button type="button" class="btn btn-warning btn-xs edit" id='{{$holiday->id}}' data-holiday_type_id="{{$holiday->holiday_type->id}}" data-toggle="modal" data-target="#modalform_modal">edit</button> |
                  <input type="submit" name="delete" value="remove" class="btn btn-danger btn-xs">
                  <input type="hidden" name="_method" value="DELETE">
                </td>
              </form>
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
    <p class="text-center">select holiday type</p>
    <select id="holiday_type_id"  name="holiday_type_id" class="form-control" data-width="100%">
    </select>
    <p class="text-center">select holiday date</p>
    <input type="hidden" name="date" id="selected_date">
    <div id='calendar'></div>

  </div>

</div>

@endsection

@section('form_script')
  <script src="{{ asset('js/fullcalendar.js') }}"></script>
  <script>
  //
  //   $('#holiday_type_id').on('select2:select', function (evt) {
  //     var selected_holiday_type_id=evt.params.data.id;
  // });
    create_update_toggle('holidays','holiday');

      var table =$('#holidays_index').DataTable();

      $('.edit').click(function () {
        var rowData = table.row( $(this).parents('tr') ).data();
        var date=rowData[0];
        var holiday_type_name=rowData[1];
        var row_holiday_type_id=$(this).attr('data-holiday_type_id');
        $('#calendar').fullCalendar('gotoDate',date)
      });

  </script>



@endsection
