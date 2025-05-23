<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ];
        if (request()->ismethod('put')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048';
        }
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
