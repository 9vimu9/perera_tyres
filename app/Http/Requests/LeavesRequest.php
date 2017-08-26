<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;


class LeavesRequest extends FormRequest
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
          'table_data_employee_id'=>'required',
          'leave_type_id'=>Config::get('enums.QuickVali.fk'),
          'from_datetime'=>Config::get('enums.QuickVali.important_date').'|before:to_datetime',
          'to_datetime'=>Config::get('enums.QuickVali.important_date').'|after:from_datetime'
            //
        ];
    }
}
