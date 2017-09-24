<?php

function EmloyeeDetailsFromSlipForSalary($salary,$employee)
{
  $in_out_details=App\slips::where('salary_id',$salary->id)->where('employee_id',$employee->id)->first();
  if($in_out_details==NULL){
    $in_out_details=App\Employees::find($employee->id);
  }
  return $in_out_details;
}

function get_epf_ot_rate($salary,$employee)
{
  $multiplier=$employee->cat->ot_multiplier;
  return get_epf_ot_rate_core($salary,$employee,$multiplier);

}

function get_double_ot_rate($salary,$employee)
{
  return get_epf_ot_rate_core($salary,$employee,2);
}

function get_epf_ot_rate_core($salary,$employee,$multiplier)
{
  $relevent_salary_details=EmloyeeDetailsFromSlipForSalary($salary,$employee);
  $salary=$salary->budget_allowence+$relevent_salary_details->basic_salary;
  $demnominator=$employee->cat->ot_denominator;
  $ot_rate=($salary/$demnominator)*$multiplier;
  return round($ot_rate, 2);
}

function get_ot_rate($salary,$employee)
{
  if (MetaGet('is_fixed_ot_rate')==1) {
    return MetaGet('fixed_ot_rate');
  }
  else {
    return get_epf_ot_rate($salary,$employee);
  }
}

// function get_slip_ot_rate($slip)
// {
//   $salary=$slip->salary;
//   $employee=$slip->employee;
//   if ($slip->ot_available) {
//     if (MetaGet('is_fixed_ot_rate')==1) {
//       return MetaGet('fixed_ot_rate');
//     }
//     else {
//       return get_epf_ot_rate($salary,$employee);
//     }
//   }
//   else {
//     return 0;
//   }
//
// }


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
  $times=is_employee_worked_that_date($employee,$date);

  $actual_clock_in = reset($times);
  end($times);//going for last record
  $actual_clock_out =current($times);

  if(count($times)==2){
    $User_att_data=GetUserAttendenceBackGroundDetails($salary,$employee,$date);
    $data=CompleteDay($actual_clock_in,$actual_clock_out,$User_att_data,"data");
    return $data;

  }
}


function get_ot_hours_leave_deduction_mins($salary,$employee)
{
  $working_days=App\working_days::where('salary_id',$salary->id)->get();
  $ot_mins=0;
  $double_ot_mins=0;
  $leave_deduction_mins=0;
  foreach ($working_days as $working_day) {
    $data=is_date_has_over_time($working_day->date,$salary,$employee);
// echo "string";
    if ($data) {
      $ot_mins+=$data["OT"];
      // echo $employee->name.$data["OT"];
      // echo "<br>";
      $double_ot_mins+=$data["double_OT"];
      $leave_deduction_mins+=$data['leave_deduction'];
    }
  }
  return ['ot_hours'=>round($ot_mins/60, 2),'double_ot_hours'=>round($double_ot_mins/60, 2),'leave_deduction_mins'=>round($leave_deduction_mins,2)];
}

function get_ot_hours_normal($salary,$employee)
{
  return get_ot_hours_leave_deduction_mins($salary,$employee)['ot_hours'];
}

function get_ot_hours_double($salary,$employee)
{
  return get_ot_hours_leave_deduction_mins($salary,$employee)['double_ot_hours'];
}

function get_ot_hours_all($salary,$employee)
{
  return get_ot_hours_normal($salary,$employee)+get_ot_hours_double($salary,$employee);
}


function get_ot_in_rs($salary,$employee,$rate)
{
  $ot_in_rs=$rate*get_ot_hours_normal($salary,$employee)+get_double_ot_rate($salary,$employee)*get_ot_hours_double($salary,$employee);
  return round($ot_in_rs, 2);
}

function get_leave_deduction_mins($salary,$employee)
{
  return get_ot_hours_leave_deduction_mins($salary,$employee)['leave_deduction_mins'];
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
