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

        default:
          # code...
          break;
      }


      // if ($request->isMethod('post')){
      //       return response()->json(['response' => 'This is post method']);
      //   }
      //
      //   return response()->json(['response' => 'This is get method']);

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
}
