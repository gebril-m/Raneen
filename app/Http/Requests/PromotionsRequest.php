<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionsRequest extends FormRequest
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
            'type' => 'required|in:f,p', 
            'amount' => 'integer|required', 
            'start' => 'date|required|after:yesterday',
            'end' => 'date|required|after:start'
        ];

        return $rules;

    }
}
