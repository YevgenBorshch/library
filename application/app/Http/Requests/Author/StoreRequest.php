<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'firstname' => 'required|string|min:3',
            'lastname' => 'required|string|min:3',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'firstname.required' => __('api.firstname.required'),
            'firstname.min' => __('api.firstname.min'),

            'lastname.required' => __('api.lastname.required'),
            'lastname.min' => __('api.lastname.min'),
        ];
    }
}
