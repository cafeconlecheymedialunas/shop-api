<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => "required|string|max:50",
            'last_name' => "required|string|max:50",
            'address_street' => "string|max:50",
            'address_appartment' => "string|max:30",
            'address_town' => "string|max:50",
            'address_state' => "string|max:50",
            'address_country' => "string|max:50",
            'address_postcode' => "string|max:6",
            'phone' => "string|max:12"
        ];
    }
}
