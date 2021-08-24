<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:5'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => trans('auth.name.required'),
            'name.min' => trans('auth.name.min'),

            'email.required' => trans('auth.email.required'),
            'email.email' => trans('auth.email.email'),
            'email.unique' => trans('auth.email.unique'),

            'password.required' => trans('auth.password.required'),
            'password.confirmed' => trans('auth.password.confirmed'),
        ];
    }
}
