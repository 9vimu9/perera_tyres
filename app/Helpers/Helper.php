<?php

function GetEveryDayBetweenTwoDates($start_date,$end_date)
{
  $begin = new DateTime($start_date);
  $end = new DateTime($end_date);
  $end->add(new DateInterval('P1D'));
  $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
  return $daterange;
}

function GetInOutOfDay($employee,$date,$salary,$data_mode=NULL)
{

  $User_att_data=GetUserAttendenceBackGroundDetails($salary,$employee,$date);
  $data_array=array();
  if (strtotime($User_att_data['join_date'])<strtotime($date)) {

    $times=is_employee_worked_that_date($employee,$date);
    $entrys_for_working_day=count($times);

    if ($entrys_for_working_day==0) {
      $html= AbsentDayHTML($User_att_data);//check holidays only
      $data_array['status']=$User_att_data['is_holiday'];
      if (!$html) {//not a holiday
        $leave=$User_att_data['is_on_Leave'];
        if(!$leave){//not a leave therfore he is absent
          $html=HtmlCreator('ab','error','plane','AB');
          $data_array['status']='absent';
        }
      }

    }
    elseif ($entrys_for_working_day==1) {
      $only_time=date('H:i',reset($times));
      $attendence_id = key($times);
      $html= 'one entry<br>'.HtmlCreator('one_entry','inverse','',$only_time,$attendence_id);
      $data_array['actual_clock_in']=$only_time;
      $data_array['actual_clock_out']=$only_time;
      $data_array['one_entry_attendence_id']=$attendence_id;
      $data_array['status']='one entry';
      $data_array['1_entries']=1;


    }
    elseif ($entrys_for_working_day>1) {
      $actual_clock_in = reset($times);
      $clock_in_attendence_id = key($times);
      end($times);//going for last record
      $actual_clock_out =current($times);
      $clock_out_attendence_id = key($times);

      if ($entrys_for_working_day>2) {
        $attendence_ids=array_keys($times);

        for ($i=1; $i <count($attendence_ids)-1 ; $i++) {
          App\attendences::destroy($attendence_ids[$i]);
        }
      }
      if ($data_mode) {
        $data_array['status']='';
        $data_array['2_entries']=1;
        $data_array_2=CompleteDay($actual_clock_in,$actual_clock_out,$User_att_data,1,$clock_in_attendence_id,$clock_out_attendence_id);
        $data_array=array_merge($data_array, $data_array_2);
      }
      else {
        $html=CompleteDay($actual_clock_in,$actual_clock_out,$User_att_data,NULL,$clock_in_attendence_id,$clock_out_attendence_id);

      }
    }
    $leave=$User_att_data['is_on_Leave'];

    if ($leave) {
      $html=$html.'<span class="on_leave badge badge-inverse" data-leave_id="'.$leave->id.'"><i class="fa fa-sun-o" aria-hidden="true" ></i>LEAVE</span>';
      $data_array['status']='leave';
    }
  }
  else{
    $html='<span class="badge badge-default"><i class="fa fa-frown-o" aria-hidden="true"></i> not<br>reg</span>';
    $data_array['status']='not registered';
  }
  if ($data_mode) {
    return $data_array;
  }
  else {
    return $html;
  }
}

function GetUserAttendenceBackGroundDetails($salary,$employee,$working_date)
{

  $in_out_details=EmloyeeDetailsFromSlipForSalary($salary,$employee);
  return [
          'employee_id'=>$employee->id,
          'cat_id'=>$employee->cat_id,
          'join_date'=>$employee->join_date,
          'is_sat_work'=>$in_out_details->is_sat_work,
          'ot_available'=>$in_out_details->ot_available,
          'planned_clock_in'=>$in_out_details->start_time,
          'planned_clock_out'=>$in_out_details->end_time,
          'day_of_date'=>date("D", strtotime($working_date)),
          'is_holiday'=>IsHoliday($employee,$working_date),
          'is_on_Leave'=>IsOnLeave($employee->id,$working_date)
        ];

}

function is_employee_worked_that_date($employee,$working_date)
{
  $attendences=Illuminate\Support\Facades\DB::table('attendences')
        ->leftJoin('employees', 'employees.id', '=', 'attendences.employee_id')
        ->leftJoin('working_days', 'working_days.id', '=', 'attendences.working_day_id')
        ->where('employees.id',$employee->id)
        ->where('working_days.date',  date('Y-m-d',strtotime($working_date)))
        ->get(['attendences.date','attendences.time','attendences.id']);

  $times=array();
  foreach ($attendences as $attendence) {
    $date_time=$attendence->date." ".$attendence->time;
    $times[$attendence->id] = strtotime($date_time);
  }
  asort($times);
  return $times;
}


function AbsentDayHTML($User_att_data)
{
  $holiday=$User_att_data['is_holiday'];


    if ($holiday) {
      $html=HtmlCreator('holiday','info','',$holiday);
      return $html;
    }



}

function HtmlCreator($class,$badge_color,$icon,$value,$attendence_id=0)
{
  ///////////class names
  //clock_in,
  // early,
  // clock_out,
  // ot,
  // leave_deduction,
  // on_leave,
  // ab,
  //one_entry,
  // holiday
  if ($attendence_id>0) {
    $attendence_id_attr=" data-attendence_id='$attendence_id'";
  }
  else {
    $attendence_id_attr="";
  }

  return '<span class="'.$class.' badge badge-'.$badge_color.'" '.$attendence_id_attr.'><i class="fa fa-'.$icon.'" aria-hidden="true"></i> '.$value .'</span>';

}

function LeaveDeductionCal($work_time_diff_sec,$late_time_min,$early_time_min,$User_att_data)
{
  if (!$User_att_data['is_holiday'] && $work_time_diff_sec<0) {
    $LeaveDeduction_min=$work_time_diff_sec/(-60);
    if ($late_time_min<=MetaGet('late_threshold')) {//if employee late for coming $late_time_min>0
      $LeaveDeduction_min-=$late_time_min;
    }
    // if ($early_time_min>0) {//if employee went early $early_time_min>0
    //   $LeaveDeduction_min+=$early_time_min;
    // }

    if ($LeaveDeduction_min>0) {
        // return HtmlCreator('error','','L: '.$LeaveDeduction_min.'m');
        return $LeaveDeduction_min;
    }
  }
}


function OTcal($actual_clock_in_sec,$actual_clock_out_sec,$planned_clock_in_sec,$planned_clock_out_sec,$work_time_diff_sec,$actual_work_time_sec,$User_att_data)
{

  if ($User_att_data['ot_available'] ) {
    $ot_in_sec=$work_time_diff_sec;

    if ($User_att_data['is_holiday']) {
      $ot_time_min=$actual_work_time_sec/60;
    }
    elseif($work_time_diff_sec>0) {
      $early_ot=$planned_clock_in_sec-$actual_clock_in_sec;
      $after_ot=$actual_clock_out_sec-$planned_clock_out_sec;

      if (MetaGet('is_early_OT')==0 && $early_ot>0) {
        $ot_in_sec=$ot_in_sec-$early_ot;
      }
      if (MetaGet('is_after_OT')==0 && $after_ot>0) {
        $ot_in_sec=$ot_in_sec-$after_ot;
      }

       $ot_time_min=($ot_in_sec)/60;

       if ($User_att_data['day_of_date']=="Sat") {
         if ($ot_time_min>60) {
           $ot_time_min-=60;
         }
         else {
           $ot_time_min=0;
         }
       }
    }


    if (isset($ot_time_min) && $ot_time_min>MetaGet('ot_threshold') && (MetaGet('is_early_OT') || MetaGet('is_after_OT'))) {
      return $ot_time_min;
    }

  }
}



function CompleteDay($in_date_time_sec,$out_date_time_sec,$User_att_data,$data_mode=NULL,$clock_in_attendence_id=0,$clock_out_attendence_id=0)
{
  $data_array;
  $data_array['late_time_min']=0;
  $data_array['early_time_min']=0;
  $data_array['OT']=0;
  $data_array['double_OT']=0;
  $data_array['leave_deduction']=0;



    $in_date=date('Y-m-d',$in_date_time_sec);
    $out_date=date('Y-m-d',$out_date_time_sec);

    $planned_clock_in_sec =strtotime($User_att_data['planned_clock_in']);

    if($User_att_data['is_sat_work'] && $User_att_data['day_of_date']=="Sat") {
      $planned_clock_out_sec=strtotime($User_att_data['planned_clock_in'].'+ 5 hour');
    }
    else {
      $planned_clock_out_sec =strtotime($User_att_data['planned_clock_out']);
    }
    $planned_work_time_sec=$planned_clock_out_sec-$planned_clock_in_sec;

    if($in_date==$out_date)
    {
      $actual_clock_in = date('H:i',$in_date_time_sec);
      $data_array['actual_clock_in']=$actual_clock_in;

      $actual_clock_out =date('H:i',$out_date_time_sec);
      $data_array['actual_clock_out']=$actual_clock_out;

      $actual_clock_out_sec=strtotime($actual_clock_out);
      $actual_clock_in_sec=strtotime($actual_clock_in);
      $actual_work_time_sec=$actual_clock_out_sec-$actual_clock_in_sec;

      $work_time_diff_sec=$actual_work_time_sec-$planned_work_time_sec;

      $late_time_min = ($actual_clock_in_sec-$planned_clock_in_sec)/60;
      $early_time_min = ($planned_clock_out_sec-$actual_clock_out_sec)/60;

      if($late_time_min>0 && !$User_att_data['is_holiday']){
        $html=HtmlCreator('late','warning','sign-in',$actual_clock_in.'<br>'.$late_time_min.'m',$clock_in_attendence_id);
        $data_array['late_time_min']=$late_time_min;

      }
      else {
        $html=HtmlCreator('clock_in','success','sign-in',$actual_clock_in,$clock_in_attendence_id);
      }

      if($early_time_min>0 && !$User_att_data['is_holiday']){
        $html=$html.HtmlCreator('early','warning','sign-out',$actual_clock_out.'<br>'.$early_time_min.'m',$clock_out_attendence_id);
        $data_array['early_time_min']=$early_time_min;
      }
      else {
        $html=$html.HtmlCreator('clock_out','success','sign-out',$actual_clock_out,$clock_out_attendence_id);
      }


      // echo $work_time_diff_sec/60;
      $OT=OTcal($actual_clock_in_sec,$actual_clock_out_sec,$planned_clock_in_sec,$planned_clock_out_sec,$work_time_diff_sec,$actual_work_time_sec,$User_att_data);



      if ($OT && !($User_att_data['cat_id']==2 && $User_att_data['day_of_date']=="Sun") ) {

        $html=$html.HtmlCreator('ot','info','clock-o',$OT.'m');
        $data_array['OT']=$OT;
        // echo   $data_array['OT'];


        if (($User_att_data['cat_id']!=2 && $User_att_data['day_of_date']=="Sun") || IsCompanyHoliday($in_date)) {
          $data_array['double_OT']=$OT;
          $data_array['OT']=0;

        }
      }

      if (!$User_att_data['is_on_Leave']) {
        $leave_deduction=LeaveDeductionCal($work_time_diff_sec,
                                            $late_time_min,
                                            $early_time_min,
                                            $User_att_data);

        if ($leave_deduction) {
          $html=$html.HtmlCreator('leave_deduction','error','','L: '.$leave_deduction.'m');
          $data_array['leave_deduction']=$leave_deduction;

        }

    }
      if ($data_mode) {
        return $data_array;
      }
      else {
        return $html;
      }


    }
    else {
      return('special');
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
  $holiday=App\holidays::where('date' , date('Y-m-d',strtotime($date_need_check)))->first();
  // print();
  if ($holiday) {
    return $holiday->holiday_type->name;
  //  return $holiday['name'];
  }
}

function IsWeekend($employee,$date_need_check)
{
  $day_of_date=date("D", strtotime($date_need_check));
  if((($employee->is_sat_work==0 && $day_of_date=="Sat")||$day_of_date=="Sun")){
    return $day_of_date;
  }
}

function IsOnLeave($employee_id,$date)
{
  $date=date('Y-m-d',strtotime($date));
  return App\leaves::
  where('employee_id','=', $employee_id)
  ->where('from_date', '<=', $date)
  ->where('to_date', '>=', $date)
  ->first();
}














 ?>
