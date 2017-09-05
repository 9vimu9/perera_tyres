<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\slips;
use App\Employees;
use App\salarys;
use App\features;

use App\slip_features;
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
      $slip_id=$request->slip_id;
      $slip_feature_value_array=$request->slip_feature_value;
      $slip_feature_id_array=$request->slip_feature_id;
      $feature_id_array=$request->feature_id;
      $slip_feature_static_value_array=$request->slip_feature_static_value;
      $slip_feature_value_type_array=$request->slip_feature_value_type;

      // return $request->all();
      for ($i=0; $i <count($slip_feature_id_array); $i++) {

        $slip_feature_id=$slip_feature_id_array[$i];

        if ($slip_feature_value_array[$i]!=NULL) {

          if ($slip_feature_id) {
            $slip_feature=slip_features::find($slip_feature_id);
          }
          else {
            $slip_feature=new slip_features();
          }

          $slip_feature->slip_id=$slip_id;
          $slip_feature->feature_id=$feature_id_array[$i];
          $slip_feature->static_value=$slip_feature_static_value_array[$i];
          $slip_feature->value=$slip_feature_value_array[$i]=='' ? '0' :$slip_feature_value_array[$i] ;
// if ($slip_feature_value_array[$i]!='') {
//   $slip_feature->value=$slip_feature_value_array[$i];
// }

          $slip_feature->value_type=$slip_feature_value_type_array[$i];
          $slip_feature->save();
        }
      }
      // return $request->all();

     return redirect('slips/'.$slip_id);
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
        $ot_rate=get_ot_rate($salary,$employee);
        $late_early_mins=$data['leave_deduction_mins'];



              // var_dump($features);
              $features=features::orderBy('is_static_value', 'desc')->get();
              $slip_features=slip_features::where('slip_id',$id)->get();
              foreach ($features as $feature) {
                $slip_feature=slip_features::where('slip_id',$id)->where('feature_id',$feature->id)->first();
// echo($slip_feature);
                $feature['slip_feature']=$slip_feature;
              }

echo "$ot_hours";
// return $features;


        $data=['basic_salary'=>$basic_salary,'slip'=>$slip,'ot_rate'=>$ot_rate,'ot_hours'=>$ot_hours,'late_early_mins'=>$late_early_mins,'features'=>$features];
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
