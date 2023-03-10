<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePacketRequest extends FormRequest
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
            'name' => 'required|min:2|max:200',
            'producer_id' => [
                'integer', 'exists:producers,id',
            ],
            'expiration_date' => 'nullable|date_format:Y.m.d',
            'purchase_date' => 'nullable|date_format:Y.m.d',
        ];
    }
}
