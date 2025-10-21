<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index()
    {
        $reports = [
            'borrowing' => [
                'title' => 'Laporan Peminjaman',
                'description' => 'Laporan detail peminjaman buku',
                'route' => 'reports.borrowing'
            ],
            'popular-books' => [
                'title' => 'Laporan Buku Populer',
                'description' => 'Laporan buku yang paling banyak dipinjam',
                'route' => 'reports.popular-books'
            ],
            'overdue' => [
                'title' => 'Laporan Buku Terlambat',
                'description' => 'Laporan buku yang terlambat dikembalikan',
                'route' => 'reports.overdue'
            ],
            'member-activity' => [
                'title' => 'Laporan Aktivitas Anggota',
                'description' => 'Laporan aktivitas peminjaman anggota',
                'route' => 'reports.member-activity'
            ]
        ];

        return view('backend.reports.index', compact('reports'));
    }

    /**
     * Display borrowing report.
     */
    public function borrowing(Request $request)
    {
        $query = Borrowing::with(['user', 'book']);

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('borrow_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('borrow_date', '<=', $request->end_date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->orderBy('borrow_date', 'desc')->paginate(15);

        $stats = [
            'total' => Borrowing::count(),
            'pending' => Borrowing::where('status', 'pending')->count(),
            'approved' => Borrowing::where('status', 'borrowed')->count(),
            'returned' => Borrowing::where('status', 'returned')->count(),
            'overdue' => Borrowing::where('status', 'borrowed')
                ->where('due_date', '<', Carbon::now())
                ->count()
        ];

        return view('backend.reports.borrowing', compact('borrowings', 'stats'));
    }

    /**
     * Display popular books report.
     */
    public function popularBooks(Request $request)
    {
        $query = Book::withCount('borrowings')
            ->with(['category']);

        // Filter by date range
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->whereHas('borrowings', function ($q) use ($request) {
                if ($request->filled('start_date')) {
                    $q->whereDate('borrow_date', '>=', $request->start_date);
                }
                if ($request->filled('end_date')) {
                    $q->whereDate('borrow_date', '<=', $request->end_date);
                }
            });
        }

        $popularBooks = $query->orderBy('borrowings_count', 'desc')->paginate(15);

        return view('backend.reports.popular-books', compact('popularBooks'));
    }

    /**
     * Display overdue books report.
     */
    public function overdue(Request $request)
    {
        $query = Borrowing::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->where('due_date', '<', Carbon::now());

        // Filter by overdue days
        if ($request->filled('overdue_days')) {
            $days = (int) $request->overdue_days;
            $query->where('due_date', '<', Carbon::now()->subDays($days));
        }

        $overdueBooks = $query->orderBy('due_date', 'asc')->paginate(15);

        $stats = [
            'total_overdue' => Borrowing::where('status', 'borrowed')
                ->where('due_date', '<', Carbon::now())
                ->count(),
            'overdue_1_week' => Borrowing::where('status', 'borrowed')
                ->where('due_date', '<', Carbon::now())
                ->where('due_date', '>=', Carbon::now()->subWeek())
                ->count(),
            'overdue_1_month' => Borrowing::where('status', 'borrowed')
                ->where('due_date', '<', Carbon::now()->subWeek())
                ->where('due_date', '>=', Carbon::now()->subMonth())
                ->count(),
            'overdue_more_than_month' => Borrowing::where('status', 'borrowed')
                ->where('due_date', '<', Carbon::now()->subMonth())
                ->count()
        ];

        return view('backend.reports.overdue', compact('overdueBooks', 'stats'));
    }

    /**
     * Display member activity report.
     */
    public function memberActivity(Request $request)
    {
        $query = User::whereIn('role', ['student', 'teacher'])
            ->withCount('borrowings')
            ->withCount('reservations');

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $members = $query->orderBy('borrowings_count', 'desc')->paginate(15);

        $stats = [
            'total_members' => User::whereIn('role', ['student', 'teacher'])->count(),
            'active_members' => User::whereIn('role', ['student', 'teacher'])
                ->whereHas('borrowings')
                ->count(),
            'students' => User::where('role', 'student')->count(),
            'teachers' => User::where('role', 'teacher')->count()
        ];

        return view('backend.reports.member-activity', compact('members', 'stats'));
    }
}
