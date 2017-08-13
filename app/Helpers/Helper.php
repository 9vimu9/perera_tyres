<?php

function GetInOutOfDay($employeeUserId,$date,$finger_print_data)
{

  //array('0', '1', '3'user id, 'LAKMAL', '0', '2', '0', '0', '4/20/2017', '17:07', '')
  $times=array();
  foreach ($finger_print_data as $finger_print) {
    $finger_print_user_id=$finger_print[2];
    $finger_printed_date=$finger_print[8];
    $finger_printed_time=$finger_print[9];
    if((int)$employeeUserId==(int)$finger_print_user_id && strtotime($date)==strtotime($finger_printed_date)){
       array_push($times,$finger_printed_time);
    }

  }

  if(count($times)>1){

    $lowestDate = $times[0];
    $highestDate =$times[0];

    foreach($times as $time){
      if(strtotime($time) < strtotime($times[0])){
          $lowestDate = $time;
      }

      if(strtotime($time) > strtotime($times[0])){
          $highestDate = $time;
      }
    }
    return [$lowestDate,$highestDate];
  } elseif (count($times)==1) {
    return [$times[0],''];
  }

}











 ?>
