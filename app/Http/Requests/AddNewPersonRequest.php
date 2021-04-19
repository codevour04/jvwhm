<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewPersonRequest extends FormRequest
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
            'leader' => 'bail|required',
            'firstname' => 'required',
            'lastname' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'leader.required' => 'Leader name is required',
            'firstname.required' => 'Firstname is required',
            'lastname.required' => 'Surname is required' 
        ];
    }
}
