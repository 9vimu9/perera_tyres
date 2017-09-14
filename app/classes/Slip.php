<?php
namespace App\Classes;

use App\slips;
use App\slip_features;
use App\features;

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
    $salary=$this->salary;
    $employee=$this->employee;

    $slip=new slips();
    $slip->salary_id=$salary->id;
    $slip->employee_id=$employee->id;
    $slip->basic_salary=$employee->basic_salary;
    $slip->per_day_salary=$employee->per_day_salary;
    $slip->actual_salary=$employee->actual_salary;
    $slip->is_epf=$employee->is_epf;

    if (MetaGet('is_fixed_ot_rate')==1) {
      $slip->ot_rate=MetaGet('fixed_ot_rate');
    }
    else {
      $slip->ot_rate=get_ot_rate($salary,$employee);
    }

    $slip->epf_ot_rate=get_ot_rate($salary,$employee);

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
      $slip_feature=new slip_features();
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
        $slip_feature=new slip_features();
        $slip_feature->slip_id=$slip->id;
        $slip_feature->feature_id=$feature->id;
        $slip_feature->static_value=$feature->static_value;
        $slip_feature->value_type=$feature->value_type;
        $slip_feature->value=$feature->static_value;
        $slip_feature->save();
      }
    }
  }

   function UpdateSlip($slip_id)
  {
    $salary=$this->salary;
    $employee=$this->employee;

    $slip=slips::find($slip_id);
    if(!$slip->date_paid){
      $slip->salary_id=$salary->id;
      $slip->employee_id=$employee->id;
      $slip->basic_salary=$employee->basic_salary;
      $slip->per_day_salary=$employee->per_day_salary;
      $slip->actual_salary=$employee->actual_salary;
      $slip->is_epf=$employee->is_epf;

      if (MetaGet('is_fixed_ot_rate')==1) {
        $slip->ot_rate=MetaGet('fixed_ot_rate');
      }
      else {
        $slip->ot_rate=get_ot_rate($salary,$employee);
      }

      $slip->epf_ot_rate=get_ot_rate($salary,$employee);

      $slip->nopay_rate=get_nopay_rate($salary,$employee);
      $slip->start_time=$employee->start_time;
      $slip->end_time=$employee->end_time;
      $slip->ot_available=$employee->ot_available;
      $slip->is_sat_work=$employee->is_sat_work;

      $slip->date_paid=NULL;


      $slip->save();

      $gap_allowences=$this->find_gap_allowences($slip);

      for ($i=0; $i <2; $i++) {
        $feature=features::find($i+1);//allways gap_allowences feature_ids must be 1,2
        $slip_feature=slip_features::where('slip_id',$slip->id)->where('feature_id',$feature->id)->first();
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
          $slip_feature=slip_features::where('slip_id',$slip->id)->where('feature_id',$feature->id)->first();
          $slip_feature->slip_id=$slip->id;
          $slip_feature->feature_id=$feature->id;
          $slip_feature->static_value=$feature->static_value;
          $slip_feature->value_type=$feature->value_type;
          $slip_feature->value=$feature->static_value;
          $slip_feature->save();
        }
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

}






 ?>
