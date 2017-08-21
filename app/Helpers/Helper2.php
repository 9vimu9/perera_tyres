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

 ?>
