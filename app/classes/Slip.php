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

    $slips=new slips();
    $slips->salary_id=$salary->id;
    $slips->employee_id=$employee->id;
    $slips->basic_salary=$employee->basic_salary;
    $slips->ot_rate=get_ot_rate($salary,$employee);
    $slips->nopay_rate=get_nopay_rate($salary,$employee);
    $slips->start_time=$employee->start_time;
    $slips->end_time=$employee->end_time;
    $slips->ot_available=$employee->ot_available;
    $slips->is_sat_work=$employee->is_sat_work;

    if(!$slips->date_paid){
      $slips->date_paid=NULL;
    }


    $slips->save();

    $features=features::all();

    foreach ($features as $feature) {
      if ($feature->is_static_value) {
        echo "string";

        $slip_feature=new slip_features();
        $slip_feature->slip_id=$slips->id;
        $slip_feature->feature_id=$feature->id;
        $slip_feature->static_value=$feature->static_value;
        $slip_feature->value=0;
        $slip_feature->save();

      }
    }





  }

  public function UpdateSlip()
  {

  }

}






 ?>
