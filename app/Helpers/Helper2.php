<?php


function GetCheckBoxValue($checkbox_value)
{
  return $checkbox_value=="on" ? 1:0;
}

function IsRecordExist($table,$conditions)
{
  $data = Illuminate\Support\Facades\DB::table($table)->where($conditions)->get()->first();

  if (is_null($data)) {
    return false;
  }
  else {
    return $data;
  }

}



function GetDurationHumanVersion($start_date,$end_date,$duration=0)
{
  if ($duration==0) {
    $duration=strtotime($start_date)-strtotime($end_date);
  }

  $days=$duration/86400;
  $hours=($duration%86400)/3600;
  $mins=($duration%86400)%3600/60;
  if($days>=1){
    echo strtok($days, ".").'d';
  }
  if ($hours>=1) {
    echo ' '.strtok($hours, ".").'h';
  }
  if ($mins>=1) {
    echo ' '.strtok($mins, ".").'m';

  }

}


function GetFeatureTypeName($type)
{
  switch ($type) {
    case 0:
      return 'deduction';
      break;

    case 1:
      return 'allowence';
      break;

    case 2:
      return 'for slip only';
      break;
  }
}

function GetFeatureCompulsoryName($value){
  if ($value==1) {
    return "compulsory";
  }
  else {
    return 'not compulsory';
  }

}

function worked_days_in_salary_month($employee,$salary)
{
  $dates=GetEveryDayBetweenTwoDates($salary->start_date,$salary->end_date);
  // echo(count($dates).'ddd');
  $number_of_days=0;

  foreach ($dates as $date) {
    $times=is_employee_worked_that_date($employee,$date->format("Y-m-d"));
    if (count($times)>0) {
      $number_of_days++;
    }
  }
  return $number_of_days;
}

function get_date_range_from_date_ranger($request)
{
  // var_dump($request->all());
  $days=array();
  $start_date=NULL;
  $end_date=NULL;


  if (isset($request->range_by_salary) && $request->salary_id) {
    $salary=App\salarys::find($request->salary_id);
    $start_date=$salary->start_date;
    $end_date=$salary->end_date;

  }
  elseif (isset($request->range_by_custom)) {
    $start_date=explode(" ", $request->from_datetime)[0];
    $end_date=explode(" ", $request->to_datetime)[0];

  }

  $daterange = GetEveryDayBetweenTwoDates($start_date,$end_date);

  foreach ($daterange as $date) {
    $data_array=array();
    $date_in_foramt=$date->format("Y-m-d");
    $data_array['date']=$date_in_foramt;
    $data_array['working_day']=App\working_days::where('date',$date_in_foramt)->first();
    $data_array['salary']=App\salarys::where('start_date','<=',$date_in_foramt)
     ->where('end_date','>=',$date_in_foramt)
     ->first();

    array_push($days,$data_array);
  }


  return ['days'=>$days,'start_date'=>$start_date,'end_date'=>$end_date];
}

 ?>
