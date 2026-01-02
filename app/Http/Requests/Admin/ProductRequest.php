<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
        ];

        if ($this->isMethod('POST')) {
            $rules['slug'] = 'required|string|max:255|unique:products,slug';
            $rules['first_image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['second_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['third_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } else {
            $rules['slug'] = 'required|string|max:255|unique:products,slug,' . $this->product->id;
            $rules['first_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['second_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            $rules['third_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }
}
