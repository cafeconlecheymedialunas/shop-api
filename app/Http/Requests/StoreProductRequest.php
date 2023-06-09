<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $options = implode(",", config("defaultfieldvalues.products.size"));
        return [
            'title' => "required|string|max:50",
            'price' => "required|numeric",
            'sale_price' => "required|numeric",
            'size' => "required|in:" . $options . "",
            'description' => "",
            'additional_info' => "",
            'tech_details' => "",
        ];
    }
}
