<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Dtos\UserDto;
use Spatie\LaravelData\WithData;

class UserRequest extends FormRequest
{
    use WithData;

    protected function dataClass(): string
    {
        return UserDto::class;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'     => 'bail|required|string',
            'email'    => 'bail|required|string|email',
            'password' => 'bail|required|string',
        ];
    }
}
