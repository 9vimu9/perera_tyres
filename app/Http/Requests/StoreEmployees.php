<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Config;

class StoreEmployees extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name'=>'required',
          'epf_no'=>'numeric',
          'nic'=>Config::get('enums.QuickVali.nic'),
          'address'=>'required',
          'tel'=>'required|'.Config::get('enums.QuickVali.tel'),
          'join_date'=>'required|date',
          'address'=>'required',
          'basic_salary' => Config::get('enums.QuickVali.money'),
          'branch_id'=>Config::get('enums.QuickVali.fk'),
          'fingerprint_no'=>'required|numeric',
          'cat_id'=>Config::get('enums.QuickVali.fk'),
          'designation_id'=>Config::get('enums.QuickVali.fk'),
          'start_time'=>'required',//|'.Config::get('enums.QuickVali.time')
          'end_time'=>'required'//|'.Config::get('enums.QuickVali.time')

            //
        ];
    }
}
