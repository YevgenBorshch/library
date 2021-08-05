<?php

namespace App\Http\Requests\Book;

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
            'author' => 'nullable|array',
            'category_id' => 'required',
            'series_id' => 'nullable|integer',
            'tag' => 'nullable|array',
            'description' => 'nullable|string',
            'title' => 'required|string|min:2',
            'pages' => 'nullable|integer',
            'year' => 'nullable|integer',
        ];
    }
}
