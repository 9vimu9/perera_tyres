<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class FileUploadRequest extends FormRequest
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
          'salary_id'=>Config::get('enums.QuickVali.fk'),
          'branch_id'=>Config::get('enums.QuickVali.fk'),
          'fileToUpload'=>'required|max:1999'


            //
        ];
    }
}
