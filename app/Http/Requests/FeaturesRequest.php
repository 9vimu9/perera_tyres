<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;


class FeaturesRequest extends FormRequest
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
          'feature_type'=>'required',
          'value_type'=>'required_if:is_static_value,on',
          'static_value'=>'required_if:is_static_value,on',
          'name'=>'required'
        ];
    }
}
