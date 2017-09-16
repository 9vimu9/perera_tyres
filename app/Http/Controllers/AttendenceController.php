<?php

namespace App\Http\Controllers;

use File;
use App\salarys;
use App\Employees;
use App\branchs;
use App\attendences;
use App\working_days;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FileUploadRequest;

class AttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Array ( [0] => 2 [1] => 1 [2] => 1 [3] => JAGATH [4] => [5] => [6] => [7] => 0 [8] => 1 [9] => 0 [10] => 0 [11] => 4/21/2017 [12] => 09:27 )
     //Array ( [0] => 22 [1] => 1 [2] => 0 [3] => [4] => [5] => [6] => [7] => [8] => [9] => 31 [10] => 1 [11] => 0 [12] => 0 [13] => 4/27/2017 [14] => 09:00 )

    public function index(FileUploadRequest $request)
    // public function index(Request $request)

    {
      if ($request->file('fileToUpload')!=NULL) {
        # code...
        $fileName=time().'.txt';
        $request->file('fileToUpload')->storeAs('public/attendence_files',$fileName);
        $path = storage_path("app\public\attendence_files/".$fileName);
        $finger_print_file = fopen($path, "r") or exit("Unable to open file!");
        $finger_print_data=array();

        while(!feof($finger_print_file))
        {
            $array_word_line=array();
            $var=fgetcsv($finger_print_file)[0];
            $string = str_replace("\0", '', $var);
            $string = preg_replace('/\s+/', '_', $string);

            $array_word_line=explode("_",$string);

            // for ($i=0; $i < count($array_word_line); $i++) {
            //   if (strlen($array_word_line[$i])==0) {
            //    array_splice($array_word_line,$i,1);
            //   }
            // }
            array_push($finger_print_data,$array_word_line);
        }
         array_splice($finger_print_data,0,1);
         array_splice($finger_print_data,count($finger_print_data)-1,1);

         for ($i=0; $i < count($finger_print_data); $i++) {
           if ($finger_print_data[$i][2]==0) {
            array_splice($finger_print_data,$i,1);
            $i--;
           }
         }
         foreach ($finger_print_data as $fingerprint) {
          //  var_dump($fingerprint);
          //  echo "<br>";
           if (count($fingerprint)==11) {
             $this->SaveAttendenceToDb($request->branch_id,$request->salary_id,$fingerprint[2],$fingerprint[8],$fingerprint[9]);

           }
           else {
             $this->SaveAttendenceToDb($request->branch_id,$request->salary_id,$fingerprint[2],$fingerprint[7],$fingerprint[8]);
           }
         }
        fclose($finger_print_file);
    }
    return $this->go_for_attendence_mark_view($request->salary_id,$request->branch_id);
    }

    public function go_for_attendence_mark_view($salary_id,$branch_id)
    {
      $salary=DB::table('salarys')->where('id', '=', $salary_id)->first();
      $branch=DB::table('branchs')->where('id', '=', $branch_id)->first();
      $employees = Employees::where('branch_id', '=', $branch->id)->get();

      return view("attendence.index")->with(['salary'=>$salary,
                                              'branch'=>$branch,
                                              'employees'=>$employees
                                            ]);
    }

    public function SaveAttendenceToDb($branch_id,$salary_id,$fingerprint_no,$date,$time)
    {
      $conditions_employee=['branch_id'=>$branch_id,'fingerprint_no'=>$fingerprint_no];
      $employee = IsRecordExist('employees',$conditions_employee);
      if($employee){//check for existance of a employee
      $date=date('Y-m-d', strtotime($date));
      $conditions_working_days=['date'=>$date];
      $conditions_attendence=['employee_id'=>$employee->id,'date'=>$date,'time'=>$time];
      $working_day=IsRecordExist('working_days',$conditions_working_days);

      if (!$working_day) {
        $working_day=new working_days();
        $working_day->salary_id=$salary_id;
        $working_day->date=$date;
        $working_day->save();
      }

      if ($employee && !IsRecordExist('attendences',$conditions_attendence)) {

        $employee_id=$employee->id;
        $attendence =new attendences();
        $attendence->employee_id=$employee_id;
        $attendence->working_day_id=$working_day->id;
        $attendence->date=$date;
        $attendence->time=$time;
        $attendence->save();
      }

}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // return $request->all();
    $start_datetime_attendence_id=$request->start_datetime_attendence_id;
    $end_datetime_attendence_id=$request->end_datetime_attendence_id;

    $start_datetime=explode(' ',$request->start_datetime);
    $start_date=$start_datetime[0];
    $start_time=$start_datetime[1];

    $end_datetime=explode(' ',$request->end_datetime);
    $end_date=$end_datetime[0];
    $end_time=$end_datetime[1];

    $leave_id=$request->leave_id;
    $leave_from_datetime=$request->from_datetime;
    $leave_to_datetime=$request->to_datetime;

    $working_day_id=working_days::where('date',$start_date)->first()->id;
    $employee_id=$request->employee_id;

    $start_attendence=attendences::find($start_datetime_attendence_id);
    if(!$start_attendence && $start_time){
      $start_attendence=new attendences();
      $start_attendence->working_day_id=$working_day_id;
      $start_attendence->employee_id=$employee_id;


    }
    $start_attendence->date=$start_date;
    $start_attendence->time=$start_time;
    $start_attendence->save();

    $end_attendence=attendences::find($end_datetime_attendence_id);
    if(!$end_attendence && $end_time){
      $end_attendence=new attendences();
      $end_attendence->working_day_id=$working_day_id;
      $end_attendence->employee_id=$employee_id;


    }
    $end_attendence->date=$end_date;
    $end_attendence->time=$end_time;
    $end_attendence->save();

    return $this->go_for_attendence_mark_view($request->salary_id,$request->branch_id);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($attendence_id)
    {
        return $attendence_id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function input_fingerprint_data()
    {
    //  return "DDD";
        return view("attendence.input_fingerprint_data");
    }
}
