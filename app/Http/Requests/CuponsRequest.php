<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CuponsRequest extends FormRequest
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
            'code' => 'required|unique:cupons',
            'type' => 'required|in:f,p', 
            'amount' => 'integer|required', 
            'start' => 'date|required||after:yesterday', 
            'end' => 'date|required|after:start', 
            'usage_times' => 'integer|required', 
            'user_usage_times' => 'integer|required'
        ];

        # for update action in resource controller
        if(request()->method() == 'PUT'){
            $rules['code'] = 'required|unique:cupons,code,'.request()->route('cupon');
        }

        return $rules;

    }
}
