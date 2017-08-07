<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\BasicSalary;
use App\Helpers\designation;
use App\Http\Requests\StoreEmployees;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // $d=new QuickVali();
      // return QuickVali::$telephone;
       return view("employees.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployees $request)
    {
      $employee=new Employees();
      $this->SaveToDb($request,$employee);
      return redirect()->back();


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
        $employee=Employees::find($id);
        $employee['basic_salary']=BasicSalary::Latest($employee->id);
        $employee['latest_designation']=Designation::Latest($employee->id);
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
      return "updatd";
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
      $employee->branch_id=$request['branch_id'];
      $employee->cat_id=$request['cat_id'];
      $employee->fingerprint_no=$request['fingerprint_no'];
      $employee->name=$request['name'];
      $employee->address=$request['address'];
      $employee->nic=$request['nic'];
      $employee->tel=$request['tel'];
      $employee->epf_no=$request['epf_no'];
      $employee->start_time=$request['start_time'];
      $employee->join_date=$request['join_date'];

      $employee->save();
      $saved_employee_id=$employee->id;

      $saved_employee_basic_salary=$request['basic_salary'];
      $saved_employee_designation_id=$request['designation_id'];

      BasicSalary::Store($saved_employee_id,$saved_employee_basic_salary);
      designation::Store($saved_employee_id,$saved_employee_designation_id);
    }



}
