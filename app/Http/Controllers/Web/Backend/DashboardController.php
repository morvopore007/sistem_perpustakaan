<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\User;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return View
     */
    public function index(): View
    {
        $user = Auth::user();
        $data = [];

        if (in_array($user->role, ['admin', 'staff'])) {
            // Admin/Staff Dashboard Statistics
            $data = [
                'total_books' => Book::count(),
                'available_books' => Book::where('available_copies', '>', 0)->count(),
                'total_categories' => Category::count(),
                'active_borrowings' => Borrowing::where('status', 'borrowed')->count(),
                'overdue_borrowings' => Borrowing::where('status', 'borrowed')
                    ->where('due_date', '<', now()->toDateString())
                    ->count(),
                'pending_reservations' => Reservation::where('status', 'pending')->count(),
                'total_members' => User::whereIn('role', ['teacher', 'student'])->count(),
                'members_by_role' => [
                    'teachers' => User::where('role', 'teacher')->count(),
                    'students' => User::where('role', 'student')->count(),
                ],
                'recent_borrowings' => Borrowing::with(['user', 'book'])
                    ->latest()
                    ->limit(5)
                    ->get(),
                'recent_books' => Book::with('category')
                    ->latest()
                    ->limit(5)
                    ->get(),
            ];
        } elseif (in_array($user->role, ['teacher', 'student'])) {
            // Member Dashboard Statistics
            $data = [
                'my_current_borrowings' => Borrowing::where('user_id', $user->id)
                    ->where('status', 'borrowed')
                    ->count(),
                'my_overdue_books' => Borrowing::where('user_id', $user->id)
                    ->where('status', 'borrowed')
                    ->where('due_date', '<', now()->toDateString())
                    ->count(),
                'my_reservations' => Reservation::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->count(),
                'my_borrowing_history' => Borrowing::where('user_id', $user->id)
                    ->where('status', 'returned')
                    ->count(),
                'current_borrowings' => Borrowing::where('user_id', $user->id)
                    ->where('status', 'borrowed')
                    ->with('book')
                    ->get(),
                'recent_books' => Book::with('category')
                    ->where('available_copies', '>', 0)
                    ->latest()
                    ->limit(6)
                    ->get(),
                'can_borrow_more' => Helper::canBorrowMore($user->id),
                'max_books_allowed' => $user->role === 'teacher' ? 
                    (int) Helper::getLibrarySetting('max_books_per_teacher', 5) : 
                    (int) Helper::getLibrarySetting('max_books_per_student', 3),
            ];
        }

        return view('backend.layouts.dashboard.index', compact('data', 'user'));
    }
}