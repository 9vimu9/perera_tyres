<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmployeesRequest;
use App\Employees;



class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees=Employees::all();
        // echo "string";
        return view('employees.index')->with('employees',$employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view("employees.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeesRequest $request)
    {

      $employee=new Employees();
      $this->SaveToDb($request,$employee);

      return view("employees.create");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($employee_id)
    {
        return 'fff';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee=Employees::find($id);
        return view("employees.edit")->with('employee',$employee);
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
      $employee=Employees::find($id);
      $this->SaveToDb($request,$employee);
      return redirect('/employees/');
      // return view("employees.create");

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

    function SaveToDb($request,$employee)
    {
      // $employee->branch_id=$request['branch_id'];
      // $employee->cat_id=$request['cat_id'];
      // $employee->designation_id=$request['designation_id'];
      // $employee->fingerprint_no=$request['fingerprint_no'];
      // $employee->name=$request['name'];
      // $employee->address=$request['address'];
      // $employee->nic=$request['nic'];
      // $employee->tel=$request['tel'];
      // $employee->epf_no=$request['epf_no'];
      // $employee->start_time=$request['start_time'];
      // $employee->end_time=$request['end_time'];
      // $employee->join_date=$request['join_date'];
      // $employee->basic_salary=$request['basic_salary'];
      $employee->ot_available=GetCheckBoxValue($request['ot_available']);
      // $employee->is_sat_work=GetCheckBoxValue($request['is_sat_work']);
      // $employee->save();

      $employee->branch_id=$request['branch_id'];
      $employee->cat_id=$request['cat_id'];
      $employee->designation_id=$request['designation_id'];
      $employee->fingerprint_no=$request['fingerprint_no'];
      $employee->name=$request['name'];
      $employee->address='DFDFSDFSF';
      $employee->nic='812310310';
      $employee->tel='0123456789';
      $employee->epf_no=$request['epf_no'];
      $employee->start_time='08:00';
      $employee->end_time=$request['end_time'];
      $employee->join_date='2016-12-12';
      $employee->basic_salary=$request['basic_salary'];
      // $employee->ot_available=1;
      $employee->is_sat_work=1;

      $employee->is_epf=GetCheckBoxValue($request['is_epf']);

      if ($request['is_monthly_salary']) {
        $employee->per_day_salary=0;
        $employee->actual_salary=$request['actual_salary'];
      }
      else {
        $employee->per_day_salary=$request['per_day_salary'];
        $employee->actual_salary=0;
      }
      $employee->save();
    }
}
