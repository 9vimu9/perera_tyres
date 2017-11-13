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
    public function show(Request $request,$employee_id)
    {
      // $employee=Employees::find($employee_id);
      //
      //   if(count($request->all())>0){
      //     $date_range_data=get_date_range_from_date_ranger($request);
      //     $date_range=$date_range_data['days'];
      //     $year=explode('-',$date_range_data['start_date'])[0];
      //     // var_dump($year);
      //
      //     $leaves=leaves::where('start_date',>=,$date_range_data['start_date'])
      //       ->where('end_date',<=,$date_range_data['end_date'])
      //       ->where('employee_id',$employee->id)->get();
      //
      //     $employee_leave_data=array();
      //
      //     $added_leaves=array();
      //
      //     foreach ($date_range as $date) {
      //
      //         if ($date['salary'] && $employee->join_date<=$date['date']) {
      //
      //           $data_array=GetInOutOfDay($employee,$date['date'],$date['salary'],1);
      //
      //           if ($data_array['status']=='absent') {
      //             $leave_data=[
      //             'date'=>$date['date'],
      //             'type'=>'absent(without notifying)',
      //             'days'=>'1 d'
      //             ];
      //             array_push($employee_leave_data,$leave_data);
      //           }else {
      //             if (isset($data_array['leave_deduction']) && $data_array['leave_deduction']>0) {
      //               $leave_data=[
      //               'date'=>$date['date'],
      //               'type'=>'effective late',
      //               'days'=>$data_array['leave_deduction'].' m'
      //               ];
      //               array_push($employee_leave_data,$leave_data);
      //             }
      //             foreach ($leaves as $leave) {
      //               if (!in_array($leave->id, $added_leaves)) {
      //                 if (strtotime($date['date'])>=strtotime($date_range_data['start_date']) && strtotime($date['date'])<=strtotime($date_range_data['end_date'])) {
      //                   array_push($added_leaves,$leave->id);
      //
      //                 }
      //             }
      //
      //           }
      //
      //
      //         }
      //       }
      //
      //     $data=[
      //       'employee'=>$employee,
      //       'employee_leave_data'=>$employee_leave_data,
      //       'year'=>$year
      //
      //     ];
      //     //
      //     // foreach ($employee_leave_data as $leave_data) {
      //     //   var_dump($leave_data);
      //     //   echo "<br>";
      //     // }
      //   }
      //   else {
      //     $data=[
      //       'employee'=>$employee
      //
      //     ];
      //   }
      //   return view("leaves.employee_leaves",$data);
      //

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
      // return $request->all();
      $leave=leaves::find($id);
      $leave->leave_type_id=$request['leave_type_id'];

      $from_datetime=explode(' ',$request['from_datetime']);
      $to_datetime=explode(' ',$request['to_datetime']);

      $leave->from_date=$from_datetime[0];
      $leave->to_date=$to_datetime[0];
      $leave->from_time=$from_datetime[1];
      $leave->to_time=$to_datetime[1];
      $leave->save();

      return redirect('/leaves');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return RemoveRecord($id,'leaves','leaves');
    }
}
