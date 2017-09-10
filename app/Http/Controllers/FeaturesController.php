<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\features;
use App\Http\Requests\FeaturesRequest;


class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $features=features::OrderBy('created_at','desc')->get();
      return view("features.index")->with('features',$features);

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
    public function store(FeaturesRequest $request)
    {

      $feature=new features();
      $feature->name=$request->name;
      $feature->is_static_value=GetCheckBoxValue($request['is_static_value']);
      $feature->value_type=$request->value_type;
      $feature->static_value=$request->static_value ==NULL ? 0 : $request->static_value;
      $feature->feature_type=$request->feature_type;
      $feature->save();
      return redirect('/features');

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
}
