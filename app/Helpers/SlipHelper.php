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
  return round($ot_rate, 2);

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

function is_date_has_over_time($date,$salary,$employee)
{
  $attendences=Illuminate\Support\Facades\DB::table('attendences')
        ->leftJoin('employees', 'employees.id', '=', 'attendences.employee_id')
        ->leftJoin('working_days', 'working_days.id', '=', 'attendences.working_day_id')
        ->where('employees.id',$employee->id)
        ->where('working_days.date',$date)
        ->get();
        if(count($attendences)==2){
          $clock_in_datetime_sec=strtotime($attendences[0]->date.$attendences[0]->time);
          $clock_out_datetime_sec=strtotime($attendences[1]->date.$attendences[1]->time);
          $User_att_data=GetUserAttendenceBackGroundDetails($salary,$employee,$date);
          $data=CompleteDay($clock_in_datetime_sec,$clock_out_datetime_sec,$User_att_data,"data");
// echo $data;
          return $data;

        }
}



function get_ot_hours($salary,$employee)
{
  $working_days=App\working_days::where('salary_id',$salary->id)->get();
  $ot_mins=0;
  $leave_deduction_mins=0;
  foreach ($working_days as $working_day) {
    $data=is_date_has_over_time($working_day->date,$salary,$employee);
// echo "string";
    if ($data) {
      $ot_mins+=$data["OT"];
      $leave_deduction_mins+=$data['leave_deduction'];
    }
  }
  return ['ot_hours'=>round($ot_mins/60, 2),'leave_deduction_mins'=>round($leave_deduction_mins,2)];
}

function PrintFeature($slip,$feature_type)
{
  $basic_salary=$slip->basic_salary+$slip->salary->budget_allowence;
  $processed_features=array();
  $total_feature_value=0;

  $features=DB::table('slip_features')
        ->leftJoin('features', 'features.id', '=', 'slip_features.feature_id')
        ->where('slip_features.value','>',0)
        ->where('slip_features.slip_id',$slip->id)
        ->where('features.feature_type',$feature_type)
        ->get([
          'slip_features.feature_id AS feature_id',//
          'features.name AS name',//
          'slip_features.value AS value',//
          'slip_features.value_type AS value_type'//0=fixed value from salary 1=precentage
        ]);

  foreach ($features as $feature) {
    $name=$feature->name;
    $value_type=$feature->value_type;

    if ($value_type==0) {
      $value="Rs ".$feature->value;
      $value_in_rs=$feature->value;
    }
    else {
      $value=$feature->value."%";
      $value_in_rs=$basic_salary*($feature->value/100);
    }

    $total_feature_value+=$value_in_rs;

    $processed_feature=['feature_id'=>$feature->feature_id,'name'=>$name,'value'=>$value,'value_in_rs'=>$value_in_rs];
    // var_dump ($processed_feature);

    array_push($processed_features,$processed_feature);

  }
  // var_dump ("$processed_features");
  return [$processed_features,$total_feature_value];
}



function get_ot_in_rs($salary,$employee)
{
  $ot_in_rs= get_ot_hours($salary,$employee)['ot_hours']*get_ot_rate($salary,$employee);
  return round($ot_in_rs, 2);
}


function get_feature_column_header($feature)
{
  $value_type=$feature->value_type;
  $feature_name=$feature->name;
  $static_value=$feature->static_value;
  $is_static_value=$feature->is_static_value;

  if ($is_static_value) {
    if ($value_type==0) {
      return $feature_name." (Rs ".$static_value.")";
    }
    else {
      return $feature_name." (".$static_value."%)";
    }
  }
  else {
      return $feature_name;
  }

}

 ?>
