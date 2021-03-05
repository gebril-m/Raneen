<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUsersRequest extends FormRequest
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

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ];

        if(request()->method() == 'PUT'){
            $rules['email'] = 'required|email|unique:users,email,'.request()->route('user');
            $rules['password'] = 'nullable|confirmed|min:8';
        }

        return $rules;

    }
}
