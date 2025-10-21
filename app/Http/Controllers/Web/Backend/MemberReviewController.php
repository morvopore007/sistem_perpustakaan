<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\BookReview;
use App\Models\Book;
use Illuminate\Http\Request;

class MemberReviewController extends Controller
{
    /**
     * Menyimpan review baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Cek apakah pengguna sudah mereview buku ini
        $existingReview = BookReview::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah mereview buku ini.');
        }

        // Cek apakah pengguna sudah meminjam buku ini sebelumnya (validasi opsional)
        $hasBorrowed = auth()->user()->borrowings()
            ->where('book_id', $book->id)
            ->where('status', 'returned')
            ->exists();

        if (!$hasBorrowed) {
            return back()->with('error', 'Anda hanya dapat mereview buku yang sudah pernah dipinjam.');
        }

        BookReview::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => 'approved', // Auto-approve untuk sementara
        ]);

        return back()->with('success', 'Review berhasil dikirim.');
    }

    /**
     * Mengupdate review tertentu.
     */
    public function update(Request $request, BookReview $review)
    {
        // Cek apakah pengguna memiliki review ini
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review berhasil diperbarui.');
    }

    /**
     * Menghapus review tertentu.
     */
    public function destroy(BookReview $review)
    {
        // Cek apakah pengguna memiliki review ini
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus.');
    }
}
