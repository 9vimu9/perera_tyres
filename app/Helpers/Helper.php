<?php
function GetEveryDayBetweenTwoDates($start_date,$end_date)
{
  $begin = new DateTime($start_date);
  $end = new DateTime($end_date);
  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
  return $daterange;
}

function GetInOutOfDayHTML($employee,$date,$salary)
{
  $User_att_data=GetUserAttendenceBackGroundDetails($salary,$employee,$date);
  if (strtotime($User_att_data['join_date'])<strtotime($date)) {
    $html=GetInOutOfDay($employee,$date,$User_att_data);
  }
  else{
    $html='<span class="badge badge-default"><i class="fa fa-frown-o" aria-hidden="true"></i> not<br>reg</span>';
  }
  return $html;
}

function GetUserAttendenceBackGroundDetails($salary,$employee,$date)
{
  $in_out_details=App\slips::where('salary_id',$salary->id)->where('employee_id',$employee->id)->first();
  if($in_out_details==NULL){
    $in_out_details=App\Employees::find($employee->id);
  }
  return ['join_date'=>App\Employees::find($employee->id)->join_date,
          'is_sat_work'=>$in_out_details->is_sat_work,
          'ot_available'=>$in_out_details->ot_available,
          'planned_clock_in'=>$in_out_details->start_time,
          'planned_clock_out'=>$in_out_details->end_time,
          'day_of_date'=>date("D", strtotime($date)),
          'is_holiday'=>IsHoliday($employee,$date)
        ];

}

function GetInOutOfDay($employee,$working_date,$User_att_data)
{
  $attendences=Illuminate\Support\Facades\DB::table('attendences')
        ->leftJoin('employees', 'employees.id', '=', 'attendences.employee_id')
        ->leftJoin('working_days', 'working_days.id', '=', 'attendences.working_day_id')
        ->where('employees.id',$employee->id)
        ->where('working_days.date',$working_date)
        ->get(['attendences.date','attendences.time']);

  $times=array();
  $html;
  foreach ($attendences as $attendence) {
    array_push($times,Carbon\Carbon::parse($attendence->date.$attendence->time)->format('Y-m-d H:i'));
  }

  $entrys_for_working_day=count($times);

  if ($entrys_for_working_day==0) {
    return AbsentDayHTML($User_att_data);;
  }
  elseif ($entrys_for_working_day==1) {
    echo "1 entry";
  }
  elseif ($entrys_for_working_day>1) {
    $actual_clock_in = $times[0];
    $actual_clock_out =$times[0];

    foreach($times as $time){

      if(strtotime($time) < strtotime($times[0])){
          $actual_clock_in = $time;
      }
      if(strtotime($time) > strtotime($times[0])){
          $actual_clock_out = $time;
      }
    }

  return  CompleteDay($actual_clock_in,$actual_clock_out,$User_att_data);
  }

}

function AbsentDayHTML($User_att_data)
{
  $holiday=$User_att_data['is_holiday'];
    if ($holiday) {
      $html=HtmlCreator('info','',$holiday);
    }
    else {
      $html=HtmlCreator('inverse','plane','AB');
    }

    return $html;
}

function HtmlCreator($badge_color,$icon,$value)
{
    return '<span class="badge badge-'.$badge_color.'"><i class="fa fa-'.$icon.'" aria-hidden="true"></i> '.$value .'</span>';

}

function LeaveDeductionCal($planned_work_time_sec,$actual_work_time_sec,$late_time_min,$early_time_min,$User_att_data)
{
  if (!$User_att_data['is_holiday'] && $planned_work_time_sec>$actual_work_time_sec) {
    $LeaveDeduction_min=0;
    if ($late_time_min>MetaGet('late_threshold')) {
      $LeaveDeduction_min+=$late_time_min;
    }
    if ($early_time_min>0) {
      $LeaveDeduction_min+=$early_time_min;
    }

    if ($LeaveDeduction_min>0) {
        return HtmlCreator('error','','L: '.$LeaveDeduction_min.'m');
    }
  }
}

function OTcal($actual_clock_in_sec,$planned_clock_in_sec,$actual_work_time_sec,$planned_work_time_sec,$User_att_data)
{
  if ($User_att_data['ot_available'] ) {
    if ($User_att_data['is_holiday']) {
      $ot_time=$actual_work_time_sec/60;
    }
    else {
      $early_ot_time=$planned_clock_in_sec-$actual_clock_in_sec;
      if ($early_ot_time<0) {
        $early_ot_time=0;
      }
      $real_ot_time_min=($actual_work_time_sec-$planned_work_time_sec-$early_ot_time)/60;

      if ($real_ot_time_min>MetaGet('ot_threshold')) {
        $ot_time=$real_ot_time_min;
      }
    }
    if (isset($ot_time)) {
      return HtmlCreator('info','clock-o',$ot_time.'m');
    }
  }
}

function CompleteDay($in_date_time,$out_date_time,$User_att_data)
{
    $in_date=date('Y-m-d',strtotime($in_date_time));
    $out_date=date('Y-m-d',strtotime($out_date_time));

    $planned_clock_in_sec =strtotime($User_att_data['planned_clock_in']);

    if($User_att_data['is_sat_work'] && $User_att_data['day_of_date']=="Sat") {
      $planned_clock_out_sec=strtotime($User_att_data['planned_clock_in'].'+ 5 hour');
    }
    else {
      $planned_clock_out_sec =strtotime($User_att_data['planned_clock_out']);
    }
    $planned_work_time_sec=$planned_clock_out_sec-$planned_clock_in_sec;
    $html="";


    if($in_date==$out_date)
    {
      $actual_clock_in = date('H:i',strtotime($in_date_time));
      $actual_clock_out =date('H:i',strtotime($out_date_time));
      $actual_clock_out_sec=strtotime($actual_clock_out);
      $actual_clock_in_sec=strtotime($actual_clock_in);
      $actual_work_time_sec=$actual_clock_out_sec-$actual_clock_in_sec;

      $late_time_min = ($actual_clock_in_sec-$planned_clock_in_sec)/60;
      $early_time_min = ($planned_clock_out_sec-$actual_clock_out_sec)/60;

      if($late_time_min>0 && !$User_att_data['is_holiday']){
        $html=$html.HtmlCreator('warning','sign-in',$actual_clock_in.'<br>'.$late_time_min.'m');
      }
      else {
        $html=$html.HtmlCreator('success','sign-in',$actual_clock_in);
      }

      if($early_time_min>0 && !$User_att_data['is_holiday']){
        $html=$html.HtmlCreator('warning','sign-out',$actual_clock_out.'<br>'.$early_time_min.'m');
      }
      else {
        $html=$html.HtmlCreator('success','sign-out',$actual_clock_out);
      }

      $html=$html.OTcal($actual_clock_in_sec,$planned_clock_in_sec,$actual_work_time_sec,$planned_work_time_sec,$User_att_data);
      $html=$html.LeaveDeductionCal($planned_work_time_sec,$actual_work_time_sec,$late_time_min,$early_time_min,$User_att_data);
      echo $html;
    }
    else {
      return('spcal');
    }

}


function IsHoliday($employee,$date_need_check)//returns name of holidayname or weeend_day_name Sat,Sun
{
  $company_holiday=IsCompanyHoliday($date_need_check);
  $weekend_day=IsWeekend($employee,$date_need_check);

  if($company_holiday){
    return $company_holiday;
  }elseif ($weekend_day) {
    return $weekend_day;
  }

}

function IsCompanyHoliday($date_need_check)
{
  $holiday=App\holidays::where('date' , date("Y-m-d", strtotime($date_need_check)))->first();
  // print();
  if ($holiday) {
    return $holiday->holiday_type->name;
  //  return $holiday['name'];
  }
}

function IsWeekend($employee,$date_need_check)
{
  $day_of_date=date("D", strtotime($date_need_check));
  if(($employee->is_sat_work==0 && $day_of_date=="Sat")||$day_of_date=="Sun"){
    return $day_of_date;
  }
}











 ?>
