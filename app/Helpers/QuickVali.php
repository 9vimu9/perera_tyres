<?php

/**
 *
 */
namespace App\Helpers;

class QuickVali
{

  public static $telephone=1;


  function __construct()
  {
    # code...
  }

  function GetValidationSnippts($value)
 {
   switch ($value) {
         case  1:
       return 'regex:/^[0-9]{9}$/';
       break;

     default:
       # code...
       break;
   }
 }
}





 ?>
