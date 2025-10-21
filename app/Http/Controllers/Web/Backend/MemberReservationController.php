<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberReservationController extends Controller
{
    /**
     * Menampilkan daftar reservasi untuk pengguna yang login.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['book.category'])
            ->where('user_id', auth()->id());

        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderBy('reservation_date', 'desc')->paginate(10);

        return view('backend.member.reservations.index', compact('reservations'));
    }

    /**
     * Menyimpan reservasi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Cek apakah buku tersedia
        if ($book->available_copies <= 0) {
            return back()->with('error', 'Buku tidak tersedia untuk reservasi.');
        }

        // Cek apakah pengguna sudah memiliki reservasi aktif untuk buku ini
        $existingReservation = Reservation::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingReservation) {
            return back()->with('error', 'Anda sudah memiliki reservasi aktif untuk buku ini.');
        }

        // Cek apakah pengguna sudah meminjam buku ini
        $existingBorrowing = DB::table('borrowings')
            ->where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->exists();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        // Buat reservasi
        Reservation::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'reservation_date' => now(),
            'status' => 'pending',
            'expires_at' => now()->addDays(7), // Reservasi berlaku selama 7 hari
        ]);

        return back()->with('success', 'Buku berhasil direservasi.');
    }

    /**
     * Menghapus reservasi tertentu.
     */
    public function destroy(Reservation $reservation)
    {
        // Cek apakah pengguna memiliki reservasi ini
        if ($reservation->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Hanya izinkan pembatalan untuk reservasi pending atau confirmed
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Tidak dapat membatalkan reservasi ini.');
        }

        $reservation->delete();

        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
