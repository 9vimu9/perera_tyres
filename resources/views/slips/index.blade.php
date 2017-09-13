@extends('layouts.modalform')

@section('title')

  <h3 class="text-center">
    REMUNERATION RECORD
    @isset($slips)
      @php
        $salary_month=date("F", mktime(0, 0, 0, $slips[0]->salary->month, 10)).' , '.$slips[0]->salary->year;
      @endphp
    for {{$salary_month}}
    <br>
    <strong>{{$branch_name}}</strong>
    @endisset
  </h3>


@endsection

@section('create_new')select salary month @endsection


  @section('panel_heding_right_side_button')
    @isset($slips)
      <div class="text-right">
        @if (isset($is_epf_version))
          EPF
        @else
          OFFICE
        @endif
      </div>
    @endisset
  @endsection



@section('table')

  @if (isset($slips) && count($slips)>0)

@if (!isset($is_epf_version))
  <form  role="form" method="get" action="/index_with_slips">
    <input type="hidden" name="salary_id" value="{{$salary_id}}">
    <input type="hidden" name="branch_id" value="{{$branch_id}}">
    <input type="hidden" name="is_epf_version" value="1">
    <button type="submit" class="btn btn-danger btn-sm">EPF version</button>
  </form>
  @else
    <form  role="form" method="get" action="/index_with_slips">
      <input type="hidden" name="salary_id" value="{{$salary_id}}">
      <input type="hidden" name="branch_id" value="{{$branch_id}}">
      <button type="submit" class="btn btn-danger btn-sm">office version</button>
    </form>

@endif

<br>


    <table id="slips_index_table" class="table table-bordered  " cellspacing="0" style="table-layout: fixed" >
      <thead>
        <tr>
            <th >name</th>
            <th >designation</th>
            <th >primary salary</th>
            <th >budget allowence</th>
            <th >basic salary</th>
            <th >per day pay</th>
            <th >days worked</th>
            <th >monthly salary</th>

            <th >OT rate</th>
            <th >OT hours</th>
            <th >OT</th>
            <th >no pay</th>
            @foreach ($allowences as $allowence)
              <th>
                {{get_feature_column_header($allowence)}}

              </th>
            @endforeach
            <th >total earning</th>
            @foreach ($deductions as $deduction)
              <th>
                {{get_feature_column_header($deduction)}}
              </th>
            @endforeach
            <th >total deductions</th>
              <th >net payable</th>
            @foreach ($demos as $demo)
              <th >
              {{get_feature_column_header($demo)}}
              </th>
            @endforeach

            <th ></th>
            <th >signature</th>

        </tr>
      </thead>

      <tbody>
        @foreach ($slips as $slip)
          @if ($slip->employee->branch_id==$branch_id)
            @php
              $slip_feature_demos=PrintFeature($slip,2);
              $slip_feature_allowences=PrintFeature($slip,1);
              $slip_feature_deductions=PrintFeature($slip,0);//slip,feature_type

              $basic_salary=$slip->basic_salary+$slip->salary->budget_allowence;
              $ot_in_rs=get_ot_in_rs($slip->salary,$slip->employee,$slip);
              $ot_rate=$slip->ot_rate;
              $ot_hours=get_ot_hours($slip->salary,$slip->employee)['ot_hours'];

              if (isset($is_epf_version)) {
                $ot_rate=$slip->epf_ot_rate;
                if ($ot_rate!=0) {
                  $ot_hours=round($ot_in_rs/$ot_rate,2);
                }
                else {
                  $ot_hours=0;
                }
              }

              $no_pay_in_rs=0;
              $total_earning_in_rs=$slip_feature_allowences[1]+$ot_in_rs+$basic_salary;
              $total_deductions_in_rs=$slip_feature_deductions[1];
              $total_salary=$total_earning_in_rs-$total_deductions_in_rs-$no_pay_in_rs;
            @endphp
            <tr>
              <td>{{$slip->employee->name}}</td>
              <td>{{$slip->employee->designation->name}}</td>
              <td>{{$slip->basic_salary}}</td>{{-- primary slary --}}
              <td>{{$slip->salary->budget_allowence}}</td>
              <td>{{$basic_salary}}</td>
              <td>{{$slip->per_day_salary}}</td>
              <td>{{worked_days_in_salary_month($slip->employee,$slip->salary)}}</td>
              <td>{{$slip->actual_salary}}</td>
              <td>{{$ot_rate}}</td>
              <td>{{$ot_hours}}</td>
              <td>{{$ot_in_rs}}</td>
              <td>{{$no_pay_in_rs}}</td>

                @foreach ($allowences as $allowence)
                  <td>
                    @foreach ($slip_feature_allowences[0] as $slip_feature_allowence)
                      @if ($slip_feature_allowence['feature_id']==$allowence->id)
                        {{$slip_feature_allowence['value_in_rs']}}
                      @endif
                    @endforeach
                  </td>
                @endforeach
                <td>{{$total_earning_in_rs}}</td>
                  @foreach ($deductions as $deduction)
                    <td>
                      @foreach ($slip_feature_deductions[0] as $slip_feature_deduction)
                        @if ($slip_feature_deduction['feature_id']==$deduction->id)
                          {{$slip_feature_deduction['value_in_rs']}}
                        @endif
                      @endforeach
                    </td>
                  @endforeach
                  <td>{{$total_deductions_in_rs}}</td>
                  <td>{{$total_salary}}</td>
                  @foreach ($demos as $demo)
                    <td>
                      @foreach ($slip_feature_demos[0] as $slip_feature_demo)
                        @if ($slip_feature_demo['feature_id']==$demo->id)
                          {{$slip_feature_demo['value_in_rs']}}
                        @endif
                      @endforeach
                    </td>
                  @endforeach

{{-- //0767918151 --}}
              <td>
                <a href="/slips/{{$slip->id}}" class="btn btn-warning btn-xs more"><i class="fa fa-plus" aria-hidden="true"></i>  <i class="fa fa-minus" aria-hidden="true"></i></a>
              </td>
              <td></td>
            </tr>
          @endif
        @endforeach
      </tbody>
  </table>
  @endif

@endsection

@section('modal_form')

  @include('layouts.salary_month_selector')
  <input type="hidden" name="salary_id" id="salary_id" >
  <div class="form-horizontal form-group ">
    <label class="col-sm-3 control-label">workpalce name</label>
    <div class="col-sm-4">
      <select id="branch_id"  name="branch_id" class="form-control" data-width="100%"></select>
    </div>
  </div>


@endsection

@section('form_script')
  <script>
  var title='';
  @isset($slips)
    title="REMUNERATION RECORD for {{$salary_month}} {{$branch_name}}";
  @endisset
    // create_update_toggle('features','allowence/deduction');
    Route_call('index_with_slips','select salary month','get','create slips');

    ///////////////////////////////////////////////////////
    var slips_index_table = $('#slips_index_table').DataTable({

      scrollX:        true,
      scrollCollapse: true,
      paging:         true,
      searching   : true,
      ordering    : true,
      info        : true,
      dom         : 'Bfrtip',
      buttons     : [
                {
                      extend: 'print',
                      title:title,
                      exportOptions: {
                  //columns: [ 0, 1, 5 ]
              }
                  }
                 ,
                 {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                title:title,
                exportOptions: {
                  //  columns: [ 0, 1, 2, 5 ]
               }
            }
          ],

          columnDefs: [ {
           targets: -1,
           visible: false
       } ]
    });

    /////////////////////////////////////////////////////////

  </script>



@endsection
