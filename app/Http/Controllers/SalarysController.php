<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SalarysRequest;
use App\budget_allowances;
use App\salarys;

class SalarysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $salarys=salarys::all();
      return view("salarys.index")->with('salarys',$salarys);

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
    public function store(SalarysRequest $request)
    {
      //  $budget_allowance=
        $salary=new salarys();
        $budget_allowance_id=budget_allowances::latest()->first()->id;
        //return $budget_allowance_id;
        $this->SaveToDb($request,$salary,$budget_allowance_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return 'fucking update';
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

    public function SaveToDb($request,$salary,$latest_budget_allowence_id=0)
    {
      $salary->year=$request['year'];
      $salary->month=$request['month'];
      $salary->start_date=$request['start_date'];
      $salary->end_date=$request['end_date'];
      if ($latest_budget_allowence_id>0) {
       $salary->budget_allowance_id=$latest_budget_allowence_id;
      }

      $salary->save();



    }
}
