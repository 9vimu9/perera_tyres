<?php

/**
 *
 */
 namespace App\Helpers;
 use App\basic_salarys;
class BasicSalary
{

  function __construct()
  {
    # code...
  }

  public static function Store($employee_id,$amount)
  {
    $basic_salary=new basic_salarys();
    $basic_salary->employee_id=$employee_id;
    $basic_salary->amount=$amount;
    $basic_salary->save();
  // //  echo "SDFFEF";
  //   var_dump($employee_id);
  //   var_dump($amount);
  }

  public static function Latest($employee_id)
  {
    $employee_latest_basic_salary=basic_salarys::where('employee_id',$employee_id)->latest()->first();
    return $employee_latest_basic_salary->amount;
  }
}



 ?>
