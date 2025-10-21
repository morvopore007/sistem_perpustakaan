<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $categoryId = $this->route('category') ? $this->route('category')->id : null;
        
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus aktif atau tidak aktif.',
        ];
    }
}
