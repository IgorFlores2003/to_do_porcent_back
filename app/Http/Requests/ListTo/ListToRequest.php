<?php

namespace App\Http\Requests\ListTo;

use Illuminate\Foundation\Http\FormRequest;

class ListToRequest extends FormRequest
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
            'POST' => [
                'user_id' => 'required|integer',
                'name' => 'required|string',
                'color' => 'nullable|string',
            ],
            'PUT' => [
                'name' => 'required|string',
                'color' => 'nullable|string',
                'is_archived' => 'required|in:0,1',
                'position' => 'required|integer'
            ]
        ];

        return $rules[$this->method()];
    }
}
