<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class RemoveRequest extends FormRequest
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
            'author_id' => 'required|exists:authors,id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'author_id.required' => __('api.author_id.required'),
        ];
    }
}
