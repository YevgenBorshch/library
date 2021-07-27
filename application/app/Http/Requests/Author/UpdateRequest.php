<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'firstname' => 'string|min:3',
            'lastname' => 'string|min:3',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'id.required' => __('api.id.required'),

            'firstname.min' => __('api.firstname.min'),

            'lastname.min' => __('api.lastname.min'),
        ];
    }
}
