<?php
namespace App\Classes;

use App\slips;
use App\slip_features;
use App\features;
use App\working_days;


/**
 *
 */
class Slip
{
  private $salary;
  private $employee;

  function __construct($salary,$employee)
  {
    $this->salary=$salary;
    $this->employee=$employee;
  }

  public function CreateSlip()
  {
    $this->save_to_db();
  }

   public function UpdateSlip($slip_id)
  {
    $this->save_to_db($slip_id);
  }


  function save_to_db($slip_id=0)
  {
    $salary=$this->salary;
    $employee=$this->employee;

    if ($slip_id) {
      $slip=slips::find($slip_id);
    }
    else {
      $slip=new slips();
    }
      $slip->salary_id=$salary->id;
      $slip->employee_id=$employee->id;
      $slip->basic_salary=$employee->basic_salary;
      $slip->per_day_salary=$employee->per_day_salary;
      $slip->actual_salary=$employee->actual_salary;
      $slip->is_epf=$employee->is_epf;
      $slip->ot_rate=get_ot_rate($salary,$employee);
      $slip->epf_ot_rate=get_epf_ot_rate($salary,$employee);
      $slip->nopay_rate=get_nopay_rate($salary,$employee);
      $slip->start_time=$employee->start_time;
      $slip->end_time=$employee->end_time;
      $slip->ot_available=$employee->ot_available;
      $slip->is_sat_work=$employee->is_sat_work;

      if(!$slip->date_paid){
        $slip->date_paid=NULL;
      }
      $slip->save();

      $gap_allowences=$this->find_gap_allowences($slip);

      for ($i=0; $i <2; $i++) {

        $feature=features::find($i+1);//allways gap_allowences feature_ids must be 1,2

        if ($slip_id) {
          $slip_feature=slip_features::where('slip_id',$slip->id)->where('feature_id',$feature->id)->first();
        }
        else {
          $slip_feature=new slip_features();
        }
        //attenence_in

        $slip_feature->slip_id=$slip->id;
        $slip_feature->feature_id=$feature->id;
        $slip_feature->static_value=0;
        $slip_feature->value_type=$feature->value_type;
        $slip_feature->value=$gap_allowences[$i];
        $slip_feature->save();
      }



      $features=features::all();
      foreach ($features as $feature) {

        if ($feature->is_static_value && !($slip->is_epf==0 && ($feature->id==3 || $feature->id==4 || $feature->id==5)) ) {
          //EPF FEATURE IDS MUST BE 3,4,5
          if ($slip_id) {
            $slip_feature=slip_features::where('slip_id',$slip->id)->where('feature_id',$feature->id)->first();
          }
          else {
            $slip_feature=new slip_features();
          }

          if ($feature->id==6) {
            $slip_feature->value=$this->make_attendence_incentive($slip);
          }
          else {
            $slip_feature->value=$feature->static_value;
          }
          $slip_feature->slip_id=$slip->id;
          $slip_feature->feature_id=$feature->id;
          $slip_feature->static_value=$feature->static_value;
          $slip_feature->value_type=$feature->value_type;
          $slip_feature->save();
        }
      }
  }

  public function find_gap_allowences($slip)
  {
    $epf_ot_in_rs= get_ot_in_rs($slip->salary,$slip->employee,$slip->epf_ot_rate);
    $ot_in_rs= get_ot_in_rs($slip->salary,$slip->employee,$slip->ot_rate);

    $ot_difference=$epf_ot_in_rs-$ot_in_rs;
    $salary_difference=0;
    $actual_salary=0;
    $basic_salary=$slip->basic_salary+$slip->salary->budget_allowence;

    if ($slip->actual_salary) {
      $actual_salary=$slip->actual_salary;
    }
    else {//per_day_salary employee
      $worked_days=worked_days_in_salary_month($slip->employee,$slip->salary);
      $actual_salary=$worked_days*$slip->per_day_salary;
    }
    $salary_difference=$actual_salary-$basic_salary-$ot_difference;
    if ($salary_difference>0) {
    $attendence_ratio=$this->get_work_ratio($slip);
    $salary_diffrence_with_attendence_ratio=$attendence_ratio*$salary_difference;
    if($salary_diffrence_with_attendence_ratio>432){
      $gap_allowence_1=round($salary_diffrence_with_attendence_ratio*0.6,2);
      $gap_allowence_2=round($salary_diffrence_with_attendence_ratio*0.4,2);
    }
    else {
      $gap_allowence_1=$salary_diffrence_with_attendence_ratio;
      $gap_allowence_2=0;
    }
    return [$gap_allowence_1,$gap_allowence_2];
  }
  return [0,0];
  }


  public function make_attendence_incentive($slip)
  {
    $full_attendence_incentive=MetaGet('attendence_incentive');
    $ratio=$this->get_work_ratio($slip);
    $attendence_incentive=$ratio*$full_attendence_incentive;
    return $attendence_incentive;

  }
  public function get_work_ratio($slip)
  {
    $working_days=working_days::where('salary_id',$slip->salary->id)->get();
    $planned_working_hours=count($working_days)*9;
    $total_hours_worked=0;
    foreach ($working_days as $working_day) {
      $times=is_employee_worked_that_date($slip->employee,$working_day->date);
      if (count($times)>1) {
        $actual_clock_in_sec = reset($times);
        end($times);//going for last record
        $actual_clock_out_sec =current($times);
        $hours_worked=($actual_clock_out_sec-$actual_clock_in_sec)/3600;

        $total_hours_worked+=$hours_worked;
      }

    }
    $total_hours_worked-=get_ot_hours_all($slip->salary,$slip->employee);
    return $total_hours_worked/$planned_working_hours;

  }












































}
 ?>
