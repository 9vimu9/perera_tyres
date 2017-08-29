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
  $relevent_salary_details=EmloyeeDetailsFromSlipForSalary($salary,$employee);
  $salary=$salary->budget_allowence+$relevent_salary_details->basic_salary;
  $demnominator=$employee->cat->ot_denominator;
  $multiplier=$employee->cat->ot_multiplier;
  $ot_rate=[($salary)/($demnominator)]*($multiplier);
  return $ot_rate;
}

function get_ot_hours($salary_id,$employee_id)
{
  // echo "$salary_id <br> $employee_id";

  $working_days=App\working_days::where('salary_id',$salary_id)->get();
  foreach ($working_days as $working_day) {
      echo "<br>";
    $attendences=Illuminate\Support\Facades\DB::table('attendences')
          ->leftJoin('employees', 'employees.id', '=', 'attendences.employee_id')
          ->leftJoin('working_days', 'working_days.id', '=', 'attendences.working_day_id')
          ->where('employees.id',$employee_id)
          ->where('working_days.date',$working_day->date)
          ->get();
    foreach ($attendences as $attendence) {
      echo $attendence->date;
      echo $attendence->time;
      echo "<br>";

    }

    echo count($attendences);
echo "///////";
  }




}




 ?>
