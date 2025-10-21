<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class MemberBorrowingController extends Controller
{
    /**
     * Menampilkan daftar peminjaman saat ini untuk pengguna yang login.
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['book.category'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['borrowed', 'overdue']);

        $borrowings = $query->orderBy('due_date', 'asc')->paginate(10);

        return view('backend.member.borrowings.index', compact('borrowings'));
    }

    /**
     * Menampilkan riwayat peminjaman untuk pengguna yang login.
     */
    public function history(Request $request)
    {
        $query = Borrowing::with(['book.category'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['returned', 'lost']);

        // Filter berdasarkan rentang tanggal
        if ($request->has('from_date') && $request->from_date) {
            $query->where('borrow_date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->where('borrow_date', '<=', $request->to_date);
        }

        $borrowings = $query->orderBy('borrow_date', 'desc')->paginate(10);

        return view('backend.member.borrowings.history', compact('borrowings'));
    }
}
