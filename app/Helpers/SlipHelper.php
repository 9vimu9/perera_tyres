<?php

function EmloyeeDetailsFromSlipForSalary($salary,$employee)
{
  $in_out_details=App\slips::where('salary_id',$salary->id)->where('employee_id',$employee->id)->first();
  if($in_out_details==NULL){
    $in_out_details=App\Employees::find($employee->id);
  }
  return $in_out_details;
}

function get_ot_rate($salary,$employee)
{
  // echo "$salary";
  $relevent_salary_details=EmloyeeDetailsFromSlipForSalary($salary,$employee);
  $salary=$salary->budget_allowence+$relevent_salary_details->basic_salary;
  $demnominator=$employee->cat->ot_denominator;
  $multiplier=$employee->cat->ot_multiplier;
  $ot_rate=($salary/$demnominator)*$multiplier;
  return $ot_rate;
}


function get_nopay_rate($salary,$employee)
{
  $relevent_salary_details=EmloyeeDetailsFromSlipForSalary($salary,$employee);
  $salary=$salary->budget_allowence+$relevent_salary_details->basic_salary;
  $demnominator=$employee->cat->ot_denominator;
  $multiplier=$employee->cat->ot_multiplier;
  $ot_rate=($salary/$demnominator)*$multiplier;
  return $ot_rate;
}

function get_ot_hours($salary,$employee)
{
  $working_days=App\working_days::where('salary_id',$salary->id)->get();
  $ot_mins=0;
  $leave_deduction_mins=0;
  foreach ($working_days as $working_day) {
    $attendences=Illuminate\Support\Facades\DB::table('attendences')
          ->leftJoin('employees', 'employees.id', '=', 'attendences.employee_id')
          ->leftJoin('working_days', 'working_days.id', '=', 'attendences.working_day_id')
          ->where('employees.id',$employee->id)
          ->where('working_days.date',$working_day->date)
          ->get();
          if(count($attendences)==2){
            $clock_in_datetime_sec=strtotime($attendences[0]->date.$attendences[0]->time);
            $clock_out_datetime_sec=strtotime($attendences[1]->date.$attendences[1]->time);
            $User_att_data=GetUserAttendenceBackGroundDetails($salary,$employee,$working_day->date);
            $data=CompleteDay($clock_in_datetime_sec,$clock_out_datetime_sec,$User_att_data,"data");
            $ot_mins+=$data["OT"];
            $leave_deduction_mins+=$data['leave_deduction'];

          }
  }
  return ['ot_hours'=>$ot_mins/60,'leave_deduction_mins'=>$leave_deduction_mins];
}

 ?>
