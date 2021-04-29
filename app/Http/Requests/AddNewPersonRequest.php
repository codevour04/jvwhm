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
            'avatar'    => 'mimes:jpg,bmp,png|file|max:2000000',
            'firstname' => 'required',
            'lastname'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'avatar.max'         => 'Should upload file size less than 2 MB!',
            'avatar.mimes'       => 'Only file type images are allowed',
            'firstname.required' => 'First name is required',
            'lastname.required'  => 'Last name is required' 
        ];
    }
}
