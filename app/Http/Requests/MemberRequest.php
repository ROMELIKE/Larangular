<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name'=>"required|max:100|not_in:undefined",
            'address'=>'required|max:300|not_in:undefined',
            'age'=>'required|numeric|digits_between:1,2',
        ];
    }
    public function messages()
    {
        return [
            'name.not_in'=>'Enter your name ( < 100)',
            'name.required'=>'Enter your name',
            'name.max'=>'can not be greater than 100 characters',
            'age.numeric'=>'age must be a number',
            'age.digits_between:1,2'=>'age must only has 2 digits',
            'age.required'=>'Enter the age',
            'address.required'=>'address is necessary',
            'address.not_in'=>'address is necessary ( < 300)',
            'address.max'=>'address can not be more than 300 character',
        ];
    }

}
