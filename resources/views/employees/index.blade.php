@extends('layouts.form')

@section('title')EMPLOYEES @endsection


@section('panels')

  <div class="panel panel-info">
    <div class="panel-heading">
      <a href="/employees/create" class="btn btn-success "><i class="fa fa-plus" aria-hidden="true"></i> new employee</a>
    </div>
    <div class="panel-body" >
      @if (count($employees)>0)

        <table id="employees_index" class="table table-striped table-hover table-center" cellspacing="0" style="table-layout: fixed; width: 230%" >
          <thead>
              <tr>
                <th style="width: 60%" >branch name</th>
                <th style="width: 35%" >employee name</th>
                <th style="width: 20%" >designation</th>
                <th style="width: 15%" >category</th>
                <th style="width: 40%" >address</th>
                <th style="width: 10%" >telephone</th>
                <th style="width: 12%" >join date</th>
                <th style="width: 8%" >fp id</th>
                <th style="width: 15%" >EPF </th>
                <th style="width: 8%" >salary type</th>
                <th style="width: 10%" >primary salary</th>
                <th style="width: 8%" >ot </th>
                <th style="width: 10%" >planned in</th>
                <th style="width: 10%" >planned out</th>
                <th style="width: 20%" ></th>
              </tr>
          </thead>
          <tbody>
                @foreach ($employees  as $employee)
                <tr>
                  <td>{{$employee->branch->name}}</td>
                  <td>{{$employee->name}}</td>
                  <td>{{$employee->designation->name}}</td>
                  <td>{{$employee->cat->name}}</td>
                  <td>{{$employee->address}}</td>
                  <td>{{$employee->tel}}</td>
                  <td>{{$employee->join_date}}</td>
                  <td>{{$employee->fingerprint_no}}</td>
                  <td>{{$employee->is_epf==1 ? 'yes-#'.$employee->epf_no : 'no'}}</td>
                  <td>{{$employee->per_day_salary>0 ? 'per day' : 'monthly'}}</td>
                  <td>{{$employee->basic_salary}}</td>
                  <td>{{$employee->ot_available==1 ? 'yes' : 'no'}}</td>
                  <td>{{$employee->start_time}}</td>
                  <td>{{$employee->end_time}}</td>
                  <td>
                    <a href="/employees/{{$employee->id}}/edit" class="btn btn-warning btn-xs edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>edit</a>
                    <button type="button" class="btn btn-danger btn-xs delete">delete</button>
                  </td>
                </tr>
                @endforeach
          </tbody>
      </table>
      @endif
    </div>
  </div>


@endsection
