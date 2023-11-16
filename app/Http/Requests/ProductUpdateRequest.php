<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        // Save maganda ata to kapag may seperation of action mga admin
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dateTime' => 'required|date',
            'images.*' => 'required|mimes:png,jpeg,jpg',
            'name' => 'required|string',
            'category_id' => 'required',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1', //|max:2000
        ];
    }
}
