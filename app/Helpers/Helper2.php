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

function GetDurationHumanVersion($start_date,$end_date)
{
  $duration=strtotime($start_date)-strtotime($end_date);
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



  // if ($duration>0) {
  //   return Carbon\Carbon::createFromTimeStamp($duration)->diffForHumans();
  //
  // }
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
  if ($value==0) {
    return "compulsory";
  }
  else {
    return 'not compulsory';
  }

}

 ?>
