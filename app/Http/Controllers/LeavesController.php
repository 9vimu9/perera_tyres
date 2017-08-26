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
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
