<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $rules = [
            'name' => 'required',
        ];

        if (strlen($this->input('password')) > 0) {
            $rules['old_password'] = 'required|min:4';
            $rules['password'] = 'min:4|confirmed';
            $rules['password_confirmation'] = 'same:password';
        }

        return $rules;


        return [];
    }
}
