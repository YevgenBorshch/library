<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:5'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.email' => trans('auth.email.email'),
            'email.required' => trans('auth.email.required'),

            'password.min' => trans('auth.password.min'),
            'password.required' => trans('auth.password.required'),
        ];
    }
}
