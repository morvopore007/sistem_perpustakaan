<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backend.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::where('status', 'available')->get();
        $users = User::where('role', '!=', 'admin')->get();
        
        return view('backend.reservations.create', compact('books', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'reservation_date' => 'required|date',
            'expires_at' => 'required|date|after:reservation_date',
        ]);

        // Check if book is available
        $book = Book::find($request->book_id);
        if ($book->status !== 'available') {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipesan.');
        }

        // Check if user already has a reservation for this book
        $existingReservation = Reservation::where('user_id', $request->user_id)
            ->where('book_id', $request->book_id)
            ->where('status', 'pending')
            ->first();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'Pengguna sudah memiliki reservasi untuk buku ini.');
        }

        Reservation::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'reservation_date' => $request->reservation_date,
            'expires_at' => $request->expires_at,
            'status' => 'pending',
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'book']);
        return view('backend.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $books = Book::where('status', 'available')->get();
        $users = User::where('role', '!=', 'admin')->get();
        
        return view('backend.reservations.edit', compact('reservation', 'books', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'reservation_date' => 'required|date',
            'expires_at' => 'required|date|after:reservation_date',
            'status' => 'required|in:pending,approved,cancelled,expired',
        ]);

        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservasi berhasil dihapus.');
    }

    /**
     * Approve a reservation
     */
    public function approve(Reservation $reservation)
    {
        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya reservasi yang menunggu persetujuan yang dapat disetujui.');
        }

        $reservation->update(['status' => 'approved']);
        
        return redirect()->back()->with('success', 'Reservasi berhasil disetujui.');
    }

    /**
     * Cancel a reservation
     */
    public function cancel(Reservation $reservation)
    {
        if ($reservation->status === 'cancelled') {
            return redirect()->back()->with('error', 'Reservasi sudah dibatalkan.');
        }

        $reservation->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
