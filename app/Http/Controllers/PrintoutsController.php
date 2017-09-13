<?php

namespace App\Http\Controllers;
use App\slips;

use Illuminate\Http\Request;

class PrintoutsController extends Controller
{
    public function PrintSlip($slip_id)
    {
      $slip=slips::find($slip_id);
      $salary=$slip->salary;
      $employee=$slip->employee;
      $ot_rate=$slip->ot_rate;
      $ot_hours=get_ot_hours($salary,$employee)['ot_hours'];
      $allowences=PrintFeature($slip,1);//slip,feature_type
      $deductions=PrintFeature($slip,0);//slip,feature_type
      $display_only=PrintFeature($slip,2);//slip,feature_type
      $data=[
        'slip'=>$slip,
        'ot_rate'=>$ot_rate,
        'ot_hours'=>$ot_hours,
        'allowences'=>$allowences,
        'deductions'=>$deductions,
        'display_only'=>$display_only

      ];
      return view('layouts.printouts.slip',$data);
    }
}
