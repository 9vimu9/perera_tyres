@extends('layouts.modalform')

@section('title')
  attendence from
  <span class="badge">{{$salary->start_date}}</span> to
  <span class="badge">{{$salary->end_date}}</span>
  <hr>{{$branch->name}}
@endsection
@section('create_new')create new holiday @endsection
@section('table')

  @if (count($employees)>0)
  <table id="attendence_index" class="table table-bordered  " cellspacing="0" style="table-layout: fixed; width: 100%" >
      <thead>
          <tr>
            <th>name</th>
            @php
              $daterange = GetEveryDayBetweenTwoDates($salary->start_date,$salary->end_date);
              foreach($daterange as $date){
                echo '<th>'.$date->format("M/d D").'</th>';
              }
            @endphp

          </tr>
      </thead>
      <tbody>
            @foreach ($employees as $employee)
            <tr>
              <td>{{$employee->name}}</td>

              @foreach ($daterange as $date)


                <td>
                  {{-- {{ $date->format('m/d/y') }}<br> --}}
                  @php
                    echo GetInOutOfDayHTML($employee,$date->format("m/d/y"),$finger_print_data);
                  @endphp

                  {{-- {{IsHoliday($employee,$date->format('Y-m-d'))}} --}}
                  {{-- <i class="fa fa-sign-out" aria-hidden="true"></i> --}}
                  {{-- <span class="badge badge-success"><i class="fa fa-sign-in" aria-hidden="true"></i>  {{$times[0]}}<br></span> --}}
                  {{-- {{$times[1]}} --}}
                  {{-- <tr>
                    <td>{{$times[0]}}</td>
                  </tr> --}}
                </td>
                {{--
                <td>{{$holiday->date}}</td>
                <td>{{$holiday->holiday_type->name}}</td>
                <td>
                  <button type="button" class="btn btn-warning btn-xs edit" id='{{$holiday->id}}' data-toggle="modal" data-target="#salarys_index_modal">edit</button> |
                  <button type="button" class="btn btn-danger btn-xs delete" id='{{$holiday->id}}'>delete</button>
                </td> --}}
              @endforeach
            </tr>
            @endforeach
      </tbody>
  </table>
  @endif


@endsection

@section('modal_form')
{{-- <div class="row">
  <div class="col-sm-3"></div>

  <div class="col-md-6" >
    <p class="text-center">select holiday date</p>
    <input type="hidden" name="date" id="selected_date">
    <div id='calendar'></div>
    <p class="text-center">select holiday type</p>
    <select id="holiday_type_id"  name="holiday_type_id" class="form-control" data-width="100%">
    </select>
  </div>

</div> --}}

@endsection

@section('form_script')
  <script>

  $(document).ready(function() {
    var table = $('#attendence_index').DataTable( {
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,

        // fixedColumns:   {
        //     leftcolumns: 1,
        //
        // },
        searching   : false,
        ordering    : false,
        info        : false

    } );
} );

  </script>



@endsection
