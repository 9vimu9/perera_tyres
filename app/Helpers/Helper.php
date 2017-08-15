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
    return [$times[0]];
  }

}

function GetInOutOfDayHTML($employee,$date,$finger_print_data)
{
  $times=GetInOutOfDay($employee->fingerprint_no,$date,$finger_print_data);
    $html="";
  if(count($times)>0){
    $html='<span class="badge badge-success"><i class="fa fa-sign-in" aria-hidden="true"></i> '.$times[0].'</span>';
    if(isset($times[1])){//check is there colock-out time
      $html=$html.'<br><span class="badge badge-info"><i class="fa fa-sign-out" aria-hidden="true"></i> '.$times[1].'</span>';
    }
  }
  else {
if (!IsHoliday($employee,$date)) {
  $html='<span class="badge badge-warning"><i class="fa fa-plane" aria-hidden="true"></i>AB</span>';
}

  }
  return $html;

}

function GetEveryDayBetweenTwoDates($start_date,$end_date)
{
  $begin = new DateTime($start_date);
  $end = new DateTime($end_date);
  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
  return $daterange;
}

function IsHoliday($employee,$date_need_check)
{

    $cat_working_day=$employee->cat->cat_working_day;
    $date = strtotime($date_need_check);
    $day = date('D', $date);

    // var_dump($date_need_check);
    // var_dump(date("Y-m-d", strtotime($date_need_check)));
    // var_dump($date);
    $holiday_of_that_day=App\holidays::where('date' , date("Y-m-d", strtotime($date_need_check)))->first();
    if($holiday_of_that_day){
      return true;
    }
    if ($day=='Sun' && $cat_working_day->is_sun_work==0) {
      return true;
    }
    elseif ($day=='Mon' && $cat_working_day->is_mon_work==0) {
      return true;

    }
    elseif ($day=='Tue' && $cat_working_day->is_tue_work==0) {
      return true;

    }
    elseif ($day=='Wed' && $cat_working_day->is_wed_work==0) {
      return true;

    }
    elseif ($day=='Thu' && $cat_working_day->is_thu_work==0) {
      return true;

    }
    elseif ($day=='Fri' && $cat_working_day->is_fri_work==0) {
      return true;

    }
    elseif ($day=='Sat' && $cat_working_day->is_sat_work==0) {
      return true;

    }

}











 ?>
