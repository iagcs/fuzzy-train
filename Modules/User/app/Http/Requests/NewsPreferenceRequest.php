<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsPreferenceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'authors' => [
                'nullable',
                'array'
            ],
            'authors.*' => [
                'required',
                'uuid',
                'exists:preferred_authors,id'
            ],
            'sources' => [
                'nullable',
                'array'
            ],
            'sources.*' => [
                'required',
                'uuid',
                'exists:preferred_sources,id'
            ],
            'categories' => [
                'nullable',
                'array'
            ],
            'categories.*' => [
                'required',
                'uuid',
                'exists:preferred_categories,id'
            ]
        ];
    }
}
