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
    $salary_difference=$actual_salary-$basic_salary;
    if($salary_difference>981){
      $random_min=$salary_difference/2;
      $random_max=($salary_difference/3)*2;
      $gap_allowence_1=round(mt_rand($random_min,$random_max),2);
      $gap_allowence_2=round($salary_difference-$gap_allowence_1,2);
    }
    else {
      $gap_allowence_1=$salary_difference;
      $gap_allowence_2=0;
    }
    return [$gap_allowence_1,$gap_allowence_2];
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
    return $this->get_worked_hours($slip)/$this->get_planned_work_hours($slip);
  }

  public function get_planned_work_hours($slip)
  {
    $salary_start_date=$slip->salary->start_date;
    $salary_end_date=$slip->salary->end_date;

    $total_hrs=0;
    $total_hours_worked=0;

    $daterange = GetEveryDayBetweenTwoDates($salary_start_date,$salary_end_date);

    foreach ($daterange as $date) {
      $date=$date->format("Y-m-d");
      $day_of_date=date("D", strtotime($date));

      if(!IsHoliday($slip->employee,$date)) {
        if($day_of_date=="Sat"){
          $total_hrs+=5;
        }
        else {
          $total_hrs+=9;
        }
      }
    }
    return $total_hrs;
  }

  public function get_worked_hours($slip)
  {
      $salary_start_date=$slip->salary->start_date;
      $salary_end_date=$slip->salary->end_date;

      $total_hours_worked=0;

      $daterange = GetEveryDayBetweenTwoDates($salary_start_date,$salary_end_date);
      foreach ($daterange as $date) {
        $date=$date->format("Y-m-d");
        $day_of_date=date("D", strtotime($date));
        $times=is_employee_worked_that_date($slip->employee,$date);
        if (count($times)>1) {
          $actual_clock_in_sec = reset($times);
          end($times);//going for last record
          $actual_clock_out_sec =current($times);
          $hours_worked=($actual_clock_out_sec-$actual_clock_in_sec)/3600;


          if ($hours_worked>9) {
            $hours_worked=9;
          }
          if($slip->employee->is_sat_work==1 && $day_of_date=="Sat" && $hours_worked>5){
            $hours_worked=5;
          }
          $total_hours_worked+=$hours_worked;
        }
    }
    return $total_hours_worked;
  }












































}
 ?>
