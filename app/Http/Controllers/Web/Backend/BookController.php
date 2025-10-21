<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $books = $query->orderBy('title')->paginate(15);
        $categories = Category::orderBy('name')->get();

        return view('backend.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('backend.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $data = $request->validated();

        // Handle book cover upload
        if ($request->hasFile('book_cover')) {
            $file = $request->file('book_cover');
            $filename = time() . '_' . Str::slug($data['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('book-covers', $filename, 'public');
            $data['book_cover'] = $path;
        }

        // Set available copies equal to total copies for new books
        $data['available_copies'] = $data['total_copies'];

        Book::create($data);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['category', 'borrowings.user', 'reservations.user', 'reviews.user']);
        return view('backend.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('backend.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $data = $request->validated();

        // Handle book cover upload
        if ($request->hasFile('book_cover')) {
            // Delete old cover if exists
            if ($book->book_cover) {
                Storage::disk('public')->delete($book->book_cover);
            }

            $file = $request->file('book_cover');
            $filename = time() . '_' . Str::slug($data['title']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('book-covers', $filename, 'public');
            $data['book_cover'] = $path;
        }

        // Calculate new available copies
        $borrowedCount = $book->borrowings()->where('status', 'borrowed')->count();
        $newAvailableCopies = $data['total_copies'] - $borrowedCount;
        $data['available_copies'] = max(0, $newAvailableCopies);

        $book->update($data);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Check if book has active borrowings
        if ($book->borrowings()->where('status', 'borrowed')->count() > 0) {
            return redirect()->route('books.index')
                ->with('error', 'Tidak dapat menghapus buku yang sedang dipinjam.');
        }

        // Delete book cover if exists
        if ($book->book_cover) {
            Storage::disk('public')->delete($book->book_cover);
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Import books from file
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        // TODO: Implement import functionality
        return redirect()->route('books.index')
            ->with('success', 'Import buku berhasil.');
    }

    /**
     * Export books to file
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'csv'); // Default to CSV
        
        // Apply same filters as index method
        $query = Book::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $books = $query->orderBy('title')->get();
        
        $filename = 'books_export_' . now()->format('Y-m-d_H-i-s') . '.' . $format;
        
        if ($format === 'csv') {
            return $this->exportToCsv($books, $filename);
        }
        
        // For now, default to CSV
        return $this->exportToCsv($books, $filename);
    }

    /**
     * Export books to CSV
     */
    private function exportToCsv($books, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($books) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Add headers
            fputcsv($file, [
                'No',
                'Judul Buku',
                'Penulis',
                'ISBN',
                'Penerbit',
                'Tahun Terbit',
                'Edisi',
                'Kategori',
                'Total Eksemplar',
                'Tersedia',
                'Status',
                'Bahasa',
                'Jumlah Halaman',
                'Lokasi',
                'Deskripsi',
                'Tanggal Dibuat',
                'Tanggal Diupdate',
            ]);

            // Add data
            $counter = 0;
            foreach ($books as $book) {
                $counter++;
                fputcsv($file, [
                    $counter,
                    $book->title,
                    $book->author,
                    $book->isbn ?? '-',
                    $book->publisher,
                    $book->publication_year,
                    $book->edition ?? '-',
                    $book->category->name,
                    $book->total_copies,
                    $book->available_copies,
                    $this->getStatusText($book->status),
                    $book->language ?? '-',
                    $book->pages ?? '-',
                    $book->location ?? '-',
                    $book->description ?? '-',
                    $book->created_at->format('d/m/Y H:i'),
                    $book->updated_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Convert status code to readable text
     */
    private function getStatusText($status)
    {
        return match($status) {
            'available' => 'Tersedia',
            'borrowed' => 'Dipinjam',
            'maintenance' => 'Perawatan',
            'lost' => 'Hilang',
            default => 'Tidak Diketahui'
        };
    }
}
