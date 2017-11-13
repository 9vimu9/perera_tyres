<?php
//composer dumpautoload
function RemoveRecord($id,$table_name,$view_name)
{
  $record= Illuminate\Support\Facades\DB::table($table_name)->where('id',$id);
  $record->delete();
  return redirect("/".$view_name);
}



?>
