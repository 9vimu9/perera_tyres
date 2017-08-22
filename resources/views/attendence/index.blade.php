@extends('layouts.app')

@section('content')
{!! csrf_field() !!}
<div class="container">
      <h3><p class="text-center">attendence from
      <span class="badge">{{$salary->start_date}}</span> to
      <span class="badge">{{$salary->end_date}}</span>
      <hr>{{$branch->name}}</p></h3>

      @if (count($employees)>0)
      <table id="attendence_index" class="table table-bordered  " cellspacing="0" style="table-layout: fixed" >

        @php
        $daterange = GetEveryDayBetweenTwoDates($salary->start_date,$salary->end_date);
        @endphp

          <thead>
              <tr>
                <th>name</th>
                @foreach ($daterange as $date)
                  <th>{{$date->format("M/d D")}}</th>
                @endforeach

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
                        echo GetInOutOfDayHTML($employee,$date->format("y-m-d"),$salary);
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


</div>


@endsection

@section('script')
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
