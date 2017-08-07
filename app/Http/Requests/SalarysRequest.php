<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class SalarysRequest extends FormRequest
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
          'year'=>Config::get('enums.QuickVali.fk'),
          'month'=>Config::get('enums.QuickVali.fk'),
          'start_date'=>Config::get('enums.QuickVali.important_date'),
          'end_date'=>Config::get('enums.QuickVali.important_date')
            //
        ];
    }
}
