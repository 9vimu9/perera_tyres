<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SalarysRequest;
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
      $salarys=salarys::OrderBy('created_at','desc')->get();
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
        $this->SaveToDb($request,$salary);
        return redirect('/salaries');
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
      //  return 'fucking update';
        $salary=salarys::find($id);
      //  return $salary;
        $this->SaveToDb($request,$salary);
        return redirect('/salaries');
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

    public function SaveToDb($request,$salary)
    {
      $salary->year=$request['year'];
      $salary->month=$request['month'];
      $salary->start_date=$request['start_date'];
      $salary->end_date=$request['end_date'];
      $salary->budget_allowence=MetaGet('budget_allowence');
      $salary->save();
    }
    public function UpdateBudgetAllowence(Request $request)
    {
      $budget_allowence=$request->budget_allowence;
      MetaSet('budget_allowence',$budget_allowence);
      return redirect('/salaries');

    }
}
