<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class MemberBookController extends Controller
{
    /**
     * Menampilkan daftar buku untuk anggota.
     */
    public function index(Request $request)
    {
        $query = Book::with(['category', 'reviews'])
            ->where('status', 'available')
            ->where('available_copies', '>', 0);

        // Fungsi pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $books = $query->paginate(12);

        return view('backend.member.books.index', compact('books'));
    }

    /**
     * Menampilkan detail buku tertentu.
     */
    public function show(Book $book)
    {
        $book->load(['category', 'reviews.user']);
        
        // Ambil rating rata-rata
        $averageRating = $book->reviews()->avg('rating') ?? 0;
        
        // Ambil review pengguna jika ada
        $userReview = $book->reviews()
            ->where('user_id', auth()->id())
            ->first();

        return view('backend.member.books.show', compact('book', 'averageRating', 'userReview'));
    }
}
