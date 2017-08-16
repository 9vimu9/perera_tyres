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

function GetInOutOfDayHTML($employee,$date,$salary,$finger_print_data)
{
  $in_out_details=App\slips::where('salary_id',$salary->id)->where('employee_id',$employee->id)->first();
  if($in_out_details==NULL){
    $in_out_details=App\Employees::find($employee->id);
  }
  $join_date=$in_out_details->join_date;
  $is_sat_work=$in_out_details->is_sat_work;
  $ot_available=$in_out_details->ot_available;

  $planned_clock_in=$in_out_details->start_time;

  $planned_clock_out=$in_out_details->end_time;
  if($is_sat_work==1 && date("D", strtotime($date))=='Sat'){

    $planned_clock_out=date('H:i',strtotime($planned_clock_in.'+ 5 hour'));
  }




  $html="";
  if (strtotime($join_date)<strtotime($date)) {
    $times=GetInOutOfDay($employee->fingerprint_no,$date,$finger_print_data);

    if(count($times)>0){
      $lateTime=(strtotime($times[0])-strtotime($planned_clock_in))/60;
      $badge_color=($lateTime>0) ? 'error' : 'success' ;
      $late_data=($lateTime>0) ? '('.$lateTime.'m)' : '' ;
      $html='<span class="badge badge-'.$badge_color.'"><i class="fa fa-sign-in" aria-hidden="true"></i> '.$times[0].'<br>'.$late_data.'</span>';
      if(isset($times[1])){//check is there colock-out time
        $earlyTime=(strtotime($planned_clock_out)-strtotime($times[1]))/60;
        $badge_color=($earlyTime>0) ? 'error' : 'success' ;
        $early_data=($earlyTime>0) ? '('.$earlyTime.'m)' : '' ;
        $html=$html.'<span class="badge badge-'.$badge_color.'"><i class="fa fa-sign-out" aria-hidden="true"></i> '.$times[1].'<br>'.$early_data.'</span>';

        if ($lateTime<=0 && $earlyTime<=0 && $ot_available==1) {
          # code...
        }
      }
    }
    else {
      if (!IsHoliday($employee,$date)) {
        $html='<span class="badge badge-inverse"><i class="fa fa-plane" aria-hidden="true"></i>AB</span>';
      }
    }
  }
  else{
    $html='<span class="badge badge-default"><i class="fa fa-frown-o" aria-hidden="true"></i> not<br>reg</span>';
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
    // $cat_working_day=$employee->cat->cat_working_day;
    // $date = strtotime($date_need_check);
    // $day = date('D', $date);
    //
    // return IsCompanyHoliday($date_need_check);
}

function IsCompanyHoliday($date_need_check)
{
  $holiday_of_that_day=App\holidays::where('date' , date("Y-m-d", strtotime($date_need_check)))->first();
  if($holiday_of_that_day){
    return true;
  }
}











 ?>
