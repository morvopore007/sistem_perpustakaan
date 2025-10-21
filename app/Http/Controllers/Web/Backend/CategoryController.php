<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('books')->orderBy('name')->paginate(15);
        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        
        Category::create($data);
        
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('books');
        return view('backend.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        
        $category->update($data);
        
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has books
        if ($category->books()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki buku.');
        }
        
        $category->delete();
        
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
