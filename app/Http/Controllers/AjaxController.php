<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function AjaxCall(request $request)
    {
      $path=$request->path;
      $qyeryData=$request->input('query');

      switch ($path) {
        case 1://salarys getData from year and month
        //  return $this->GetSalaryData($qyeryData);
         return response()->json($this->GetSalaryData($qyeryData));
         break;

         case 2:
          return response()->json($this->GetAllHolidays());
          break;

        case 3:
         return response()->json($this->GetLeaveFromId($qyeryData));
         break;

        default:
          # code...
          break;
      }

    }


    public function GetSalaryData($query)
    {
     $users = DB::table('salarys')->where('year',$query['year'])->where('month',$query['month'])->get();
     return $users;
    }

    public function GetAllHolidays()
    {
      $holidays = DB::table('holidays')
            ->leftJoin('holiday_types', 'holidays.holiday_type_id', '=', 'holiday_types.id')
            ->get(['date AS start','name AS title']);
      return $holidays;

    }

    public function GetLeaveFromId($query)
    {
      $leaves= DB::table('leaves')->where('id',$query['leave_id'])->get();
      return $leaves;
    }
}
