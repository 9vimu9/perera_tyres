<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\slips;
use App\Employees;
use App\Classes\Slip;

class SlipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('slips.index');
    }

    public function IndexWithSlips(Request $request)
    {
      $employees=Employees::all();
      foreach ($employees as $employee) {
        $conditions=['salary_id'=>$request->salary_id,'employee_id'=>$employee->id];
        $slip=new slip($request->salary_id,$employee->id);
          if (IsRecordExist('slips',$conditions)) {
            $slip->UpdateSlip();

          }
          else {
            $slip->CreateSlip();
          }
      }
      return $request->all();

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
    public function store(Request $request)
    {
        //
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
