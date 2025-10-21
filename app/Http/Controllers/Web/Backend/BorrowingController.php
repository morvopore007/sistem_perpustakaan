<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('backend.borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereIn('role', ['teacher', 'student'])->orderBy('name')->get();
        $books = Book::where('available_copies', '>', 0)->orderBy('title')->get();
        
        return view('backend.borrowings.create', compact('users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
            'status' => 'required|in:pending,approved,borrowed',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if book is available
        $book = Book::findOrFail($request->book_id);
        if ($book->available_copies <= 0) {
            return redirect()->back()
                ->with('error', 'Buku tidak tersedia untuk dipinjam.')
                ->withInput();
        }

        $data = $request->all();
        $data['approved_by'] = Auth::id();
        
        // If status is 'approved', change it to 'borrowed' since approved means the book is actually borrowed
        if ($data['status'] === 'approved') {
            $data['status'] = 'borrowed';
        }
        
        Borrowing::create($data);

        return redirect()->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'book', 'approvedBy']);
        return view('backend.borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        $users = User::whereIn('role', ['teacher', 'student'])->orderBy('name')->get();
        $books = Book::orderBy('title')->get();
        
        return view('backend.borrowings.edit', compact('borrowing', 'users', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
            'return_date' => 'nullable|date|after:borrow_date',
            'status' => 'required|in:pending,approved,borrowed,returned,overdue',
            'notes' => 'nullable|string|max:500',
        ]);

        $data = $request->all();
        
        // If status is returned and return_date is not set, set it to today
        if ($data['status'] == 'returned' && empty($data['return_date'])) {
            $data['return_date'] = Carbon::today();
        }

        $borrowing->update($data);

        return redirect()->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        
        return redirect()->route('borrowings.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }

    /**
     * Approve a borrowing request.
     */
    public function approve(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya peminjaman dengan status menunggu yang dapat disetujui.');
        }

        // Check if book is still available
        if ($borrowing->book->available_copies <= 0) {
            return redirect()->back()
                ->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        $borrowing->update([
            'status' => 'borrowed',
            'approved_by' => Auth::id(),
        ]);

        // Decrease available copies
        $borrowing->book->decrement('available_copies');

        return redirect()->back()
            ->with('success', 'Peminjaman berhasil disetujui.');
    }

    /**
     * Mark a borrowing as returned.
     */
    public function return(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return redirect()->back()
                ->with('error', 'Hanya peminjaman yang sedang dipinjam yang dapat dikembalikan.');
        }

        $borrowing->update([
            'status' => 'returned',
            'return_date' => Carbon::today(),
        ]);

        // Increase available copies
        $borrowing->book->increment('available_copies');

        return redirect()->back()
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}
