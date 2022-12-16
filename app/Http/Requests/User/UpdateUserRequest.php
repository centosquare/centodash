<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required',Rule::unique('users', 'name')->ignore($this->user)],
            'mobile_number' => ['required','numeric',Rule::unique('users', 'mobile_number')->ignore($this->user)],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'roles' => ''
        ];
    }
}
