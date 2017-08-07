<?php

/**
 *
 */
 namespace App\Helpers;
 use App\employee__designations;
class Designation
{

  function __construct()
  {
    # code...
  }

  public static function Store($employee_id,$designation_id)
  {
    $employee__designation=new employee__designations();
    $employee__designation->employee_id=$employee_id;
    $employee__designation->designation_id=$designation_id;
    $employee__designation->save();

  }

  public static function Latest($employee_id)
  {
    $employee_latest_designation=employee__designations::where('employee_id',$employee_id)->latest()->first();
    return $employee_latest_designation;
  }
}



 ?>
