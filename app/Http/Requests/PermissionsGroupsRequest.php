<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionsGroupsRequest extends FormRequest
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
            'name' => 'required|unique:permissions_groups'
        ];

        if(request()->method() == 'PUT'){
            $rules['name'] = 'required|unique:permissions_groups,name,'.request()->route('permgroup');
        }

        return $rules;
    }
}
