<?php

namespace Modules\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleSearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'keyword'  => ['bail', 'nullable', 'string'],
            'category' => ['bail', 'nullable', 'string'],
            'source'   => ['bail', 'nullable', 'string'],
            'from'     => ['bail', 'nullable', 'date', 'date_format:Y-m-d'],
        ];
    }
}
