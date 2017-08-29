<?php
namespace App\Classes;

/**
 *
 */
class Slip
{
  private $salary_id;
  private $employee_id;

  function __construct($salary_id,$employee_id)
  {
    $this->salary_id=$salary_id;
    $this->employee_id=$employee_id;
  }

  public function CreateSlip()
  {
    $salary_id=$this->salary_id;
    $employee_id=$this->employee_id;
    // echo "  $this->salary_id   $this->employee_id";
    get_ot_hours($salary_id,$employee_id);

  }
  public function UpdateSlip()
  {

  }

}






 ?>
