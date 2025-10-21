<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'edition' => 'nullable|string|max:50',
            'total_copies' => 'required|integer|min:1',
            'book_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'status' => 'required|in:available,borrowed,maintenance,lost',
        ];

        // For update requests, make ISBN unique except for current book
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['isbn'] = 'nullable|string|max:20|unique:books,isbn,' . $this->route('book')->id;
            $rules['book_cover'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori harus dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'title.required' => 'Judul buku harus diisi.',
            'title.max' => 'Judul buku maksimal 255 karakter.',
            'author.required' => 'Penulis harus diisi.',
            'author.max' => 'Nama penulis maksimal 255 karakter.',
            'isbn.unique' => 'ISBN sudah digunakan oleh buku lain.',
            'isbn.max' => 'ISBN maksimal 20 karakter.',
            'publisher.required' => 'Penerbit harus diisi.',
            'publisher.max' => 'Nama penerbit maksimal 255 karakter.',
            'publication_year.required' => 'Tahun terbit harus diisi.',
            'publication_year.integer' => 'Tahun terbit harus berupa angka.',
            'publication_year.min' => 'Tahun terbit minimal 1900.',
            'publication_year.max' => 'Tahun terbit tidak boleh lebih dari tahun sekarang.',
            'total_copies.required' => 'Jumlah eksemplar harus diisi.',
            'total_copies.integer' => 'Jumlah eksemplar harus berupa angka.',
            'total_copies.min' => 'Jumlah eksemplar minimal 1.',
            'book_cover.image' => 'File harus berupa gambar.',
            'book_cover.mimes' => 'Gambar harus berformat jpeg, png, jpg, atau gif.',
            'book_cover.max' => 'Ukuran gambar maksimal 2MB.',
            'status.required' => 'Status buku harus dipilih.',
            'status.in' => 'Status buku tidak valid. Pilih: available, borrowed, maintenance, atau lost.',
            'pages.integer' => 'Jumlah halaman harus berupa angka.',
            'pages.min' => 'Jumlah halaman minimal 1.',
        ];
    }
}