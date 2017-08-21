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

  $join_date=App\Employees::find($employee->id)->join_date;
  $is_sat_work=$in_out_details->is_sat_work;
  $ot_available=$in_out_details->ot_available;
  $planned_clock_in=$in_out_details->start_time;
  $planned_clock_out=$in_out_details->end_time;
  $day_of_date=date("D", strtotime($date));


  if($is_sat_work==1 && $day_of_date=='Sat'){
    $planned_clock_out=date('H:i',strtotime($planned_clock_in.'+ 5 hour'));
  }

  $html="";
  if (strtotime($join_date)<strtotime($date)) {
    $times=GetInOutOfDay($employee->fingerprint_no,$date,$finger_print_data);

    if(count($times)==2){
      $lateTime=(strtotime($times[0])-strtotime($planned_clock_in))/60;
      $badge_color=($lateTime>0) ? 'warning' : 'success' ;
      $late_data=($lateTime>0) ? '('.$lateTime.'m)' : '' ;
      $html='<span class="badge badge-'.$badge_color.'"><i class="fa fa-sign-in" aria-hidden="true"></i> '.$times[0].'<br>'.$late_data.'</span>';

      $earlyTime=(strtotime($planned_clock_out)-strtotime($times[1]))/60;
      $badge_color=($earlyTime>0) ? 'warning' : 'success' ;
      $early_data=($earlyTime>0) ? '('.$earlyTime.'m)' : '' ;
      $html=$html.'<span class="badge badge-'.$badge_color.'"><i class="fa fa-sign-out" aria-hidden="true"></i> '.$times[1].'<br>'.$early_data.'</span>';

      $planned_work_time=(strtotime($planned_clock_out)-strtotime($planned_clock_in))/60;

      if($earlyTime<0 && $lateTime<0){
        $actual_work_time=(strtotime($times[1])-strtotime($planned_clock_in))/60;
      }else {
        $actual_work_time=(strtotime($times[1])-strtotime($times[0]))/60;
      }

      $ot_time=$actual_work_time-$planned_work_time;

      if ($ot_available==1 && ($ot_time-MetaGet('ot_threshold')>0|| IsCompanyHoliday($date)) && !($employee->cat->id==2 && $day_of_date=="Sun")) {

        if (IsCompanyHoliday($date)) {
          $ot_time=$planned_work_time;
        }
        $html=$html.'<span class="badge badge-info"><i class="fa fa-clock-o" aria-hidden="true"></i> '.$ot_time .'m</span>';
      }

      if ($ot_time<0) {
        $leave_deduction=0;
        if ($earlyTime>0) {
          $leave_deduction=$earlyTime;
        }
        if ($lateTime>MetaGet('late_threshold')) {
          $leave_deduction+=$lateTime;
        }

        if ($leave_deduction>0) {
          $html=$html.'<span class="badge badge-error">LD: '.$leave_deduction .'m</span>';
        }
      }


    }
      if (count($times)==0) {
        if (IsHoliday($employee,$date)) {
          $html='<span class="badge badge-info">holiday</span>';
        }
        elseif ($day_of_date=="Sun") {
          $html='<span class="badge badge-info">weekend</span>';
        }
        else {
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
  return ($employee->is_sat_work==0 && date("D", strtotime($date_need_check))=="Sat")
  ||
  (IsCompanyHoliday($date_need_check));
}

function IsCompanyHoliday($date_need_check)
{
  return App\holidays::where('date' , date("Y-m-d", strtotime($date_need_check)))->first()||(date("D", strtotime($date_need_check))=="Sun");
}











 ?>
