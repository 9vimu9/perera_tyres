<?php
namespace App\Classes;

use App\slips;
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




  }

  public function UpdateSlip()
  {

  }

}






 ?>
