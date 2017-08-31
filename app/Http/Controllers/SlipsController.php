<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\slips;
use App\Employees;
use App\salarys;
use Illuminate\Support\Facades\DB;

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
      $salary_id=$request->salary_id;
      $employees=Employees::all();
      $salary=salarys::find($salary_id);
      foreach ($employees as $employee) {
        $conditions=['salary_id'=>$salary_id,'employee_id'=>$employee->id];

        $slip=new slip($salary,$employee);
          if (IsRecordExist('slips',$conditions)) {
            $slip->UpdateSlip();
          }
          else {
            $slip->CreateSlip();
          }
      }
      $slips=slips::where('salary_id',$salary_id)->get();
      return view('slips.index')->with('slips',$slips);;

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
        $slip=slips::find($id);
        $salary=$slip->salary;
        $employee=$slip->employee;
        $basic_salary=$salary->basic_salary+$salary->budget_allowence;
        $data=get_ot_hours($salary,$employee);
        $ot_hours=$data['ot_hours'];
        $late_early_mins=$data['leave_deduction_mins'];

        $features=DB::table('features')
              ->leftJoin('slip_features', 'features.id', '=', 'slip_features.feature_id')
              ->where('slip_features.slip_id',$id)
              ->orWhere('slip_features.slip_id',NULL)
              ->get(
                [
                'features.name AS name',
                'features.is_compulsory_feature AS is_compulsory_feature',
                'features.is_static_value AS is_static_value',
                'features.value_type AS value_type',
                'features.static_value AS latest_static_value',
                'features.feature_type AS feature_type',
                'slip_features.slip_id AS slip_id',
                'slip_features.feature_id AS feature_id',
                'slip_features.static_value AS slip_static_value',
                'slip_features.value AS slip_value'

              ]
            );

              // var_dump($features);





        $data=['basic_salary'=>$basic_salary,'slip'=>$slip,'ot_hours'=>$ot_hours,'late_early_mins'=>$late_early_mins,'features'=>$features];
        return view('slips.slip_form',$data);
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
