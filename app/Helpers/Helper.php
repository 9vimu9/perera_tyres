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
          'day_of_date'=>date("D", strtotime($date))
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
    $html=AbsentDay($employee,$working_date);
    return $html;

  }
  elseif ($entrys_for_working_day==1) {
    # code...
  }
  elseif ($entrys_for_working_day>1) {
    $in_time = $times[0];
    $out_time =$times[0];

    foreach($times as $time){

      if(strtotime($time) < strtotime($times[0])){
          $in_time = $time;
      }
      if(strtotime($time) > strtotime($times[0])){
          $out_time = $time;
      }
    }

  return  CompleteDay($in_time,$out_time,$User_att_data);
  }

}

function AbsentDay($employee,$working_day)
{
  $holiday=IsHoliday($employee,$working_day);
    if ($holiday) {
      $html='<span class="badge badge-info">'.$holiday.'</span>';
    }
    else {
      $html='<span class="badge badge-inverse"><i class="fa fa-plane" aria-hidden="true"></i>AB</span>';
    }

    return $html;

}

function HtmlCreator($badge_color,$icon,$value)
{
    return '<span class="badge badge-'.$badge_color.'"><i class="fa fa-'.$icon.'" aria-hidden="true"></i> '.$value .'</span>';

}

function CompleteDay($in_date_time,$out_date_time,$User_att_data)
{
    $in_date=date('Y-m-d',strtotime($in_date_time));
    $out_date=date('Y-m-d',strtotime($out_date_time));

    $planned_clock_in_sec =strtotime($User_att_data['planned_clock_in']);
    $planned_clock_out_sec =strtotime($User_att_data['planned_clock_out']);
    $planned_work_time_sec=$planned_clock_out_sec-$planned_clock_in_sec;

    $html="";
    if($in_date==$out_date)
    {
      $in_time = date('H:i',strtotime($in_date_time));
      $out_time =date('H:i',strtotime($out_date_time));
      $out_time_sec=strtotime($out_time);
      $in_time_sec=strtotime($in_time);

      $late_time_min = ($in_time_sec-$planned_clock_in_sec)/60;
      $early_time_min = ($planned_clock_out_sec-$out_time_sec)/60;

      if($late_time_min>0){
        $html=$html.HtmlCreator('warning','-sign-in',$in_time.'<br>'.$late_time_min.'m');
      }
      else {
        $html=$html.HtmlCreator('success','-sign-in',$in_time);
      }

      if($early_time_min>0){
        $html=$html.HtmlCreator('warning','-sign-out',$out_time.'<br>'.$early_time_min.'m');
      }
      else {
        $html=$html.HtmlCreator('success','-sign-out',$out_time);
      }

      echo $html;
    }
    else {
      return('spcal');
    }

}


function IsHoliday($employee,$date_need_check)
{
  $company_holiday=IsCompanyHoliday($date_need_check);
  $weekend_day=IsWeekend($employee,$date_need_check);

  if($company_holiday){
    return $company_holiday;
  }
  if ($weekend_day) {
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
