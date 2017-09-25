<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LeavesRequest;
use App\leaves;
use App\Employees;


class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $leaves=leaves::OrderBy('created_at','desc')->get();
      $employees=Employees::all();
      $data=['leaves'=>$leaves,'employees'=>$employees];
      return view("leaves.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeavesRequest $request)
    {//	id	leave_type_id	employee_id	from_date	from_time	to_date	to_time	remarks	created_at	updated_at
        $from_datetime=explode(' ',$request['from_datetime']);
        $to_datetime=explode(' ',$request['to_datetime']);

        $bulk_employee_id=explode(",",$request->table_data_employee_id);
        foreach ($bulk_employee_id as $employee_id) {
          $leave=new leaves();
          $leave->leave_type_id=$request['leave_type_id'];
          $leave->employee_id=$employee_id;
          $leave->from_date=$from_datetime[0];
          $leave->to_date=$to_datetime[0];
          $leave->from_time=$from_datetime[1];
          $leave->to_time=$to_datetime[1];
          $leave->save();
        }
        return redirect('/leaves/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($request,$employee_id)
    {
        if(count($request->all())>0){
          $date_range_data=get_date_range_from_date_ranger($request);
          $date_range=$date_range_data['days'];
          $employee=Employees::find($employee_id);

          $days_worked=0;
          $times_onleave=0;
          $times_absent_without_leave=0;
          $times_early=0;
          $times_late=0;
          $ot_hours_working_days=0;
          $ot_hours_holidays=0;
          $mins_early=0;
          $mins_late=0;
          $effective_leave_deduction=0;
          // var_dump();
          foreach ($date_range as $date) {
              $date_in_format=$date['date'];
              $data_array=GetInOutOfDay($employee,$date_in_format,$date['salary'],1);

              if (isset($data_array['2_entries']) && $data_array['2_entries']==1) {
                $days_worked++;

              }
              if (isset($data_array['1_entries']) && $data_array['1_entries']==1) {
                $days_worked++;

              }
              if ($data_array['status']=='leave') {
                $times_onleave++;
              }

              if ($data_array['status']=='absent') {
                $times_absent_without_leave++;
              }

              if (isset($data_array['late_time_min']) && $data_array['late_time_min']>0 ) {
                $times_late++;
                $mins_late+=$data_array['late_time_min'];
              }

              if (isset($data_array['early_time_min']) && $data_array['early_time_min']>0 ) {
                $times_early++;
                $mins_early+=$data_array['early_time_min'];
              }

              if (isset($data_array['OT'])) {
                $ot_hours_working_days+=$data_array['OT'];
              }

              if (isset($data_array['double_OT'])) {
                $ot_hours_holidays+=$data_array['double_OT'];
              }

              if (isset($data_array['late_time_min'])) {
                $effective_leave_deduction+=$data_array['late_time_min'];
              }

            }

            $employee_attendence_data=[
            'employee'=>$employee,
            'days_worked'=>$days_worked,
            'times_onleave'=>$times_onleave,
            'times_absent_without_leave'=>$times_absent_without_leave,
            'times_early'=>$times_early,
            'times_late'=>$times_late,
            'ot_hours_working_days'=>$ot_hours_working_days,
            'ot_hours_holidays'=>$ot_hours_holidays,
            'mins_early'=>$mins_early,
            'mins_late'=>$mins_late,
            'effective_leave_deduction'=>$effective_leave_deduction

          ];
          array_push($employees_attendence_data,$employee_attendence_data);
          $branch_name=branchs::find($request->branch_id)->name;


          $date_range_data['end_date'];

          $data=[
            'employees_attendence_data'=>$employees_attendence_data,
            'branch_name'=>$branch_name,
            'start_date'=>$date_range_data['start_date'],
            'end_date'=>$date_range_data['end_date'],

          ];
          // var_dump($employees_attendence_data);

          return view("attendence.attenedence_daily_monthly",$data);
        }
        else {
          return view("attendence.attenedence_daily_monthly");
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
