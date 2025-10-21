<?php

use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\UserController;
use App\Http\Controllers\Web\Backend\CategoryController;
use App\Http\Controllers\Web\Backend\BookController;
use App\Http\Controllers\Web\Backend\BorrowingController;
use App\Http\Controllers\Web\Backend\ReservationController;
use App\Http\Controllers\Web\Backend\ReportController;
use App\Http\Controllers\Web\Backend\LibrarySettingController;
use App\Http\Controllers\Web\Backend\MemberBookController;
use App\Http\Controllers\Web\Backend\MemberBorrowingController;
use App\Http\Controllers\Web\Backend\MemberReservationController;
use App\Http\Controllers\Web\Backend\MemberReviewController;
use Illuminate\Support\Facades\Route;

//! Route for Admin Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//! Route for Users Page
Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user/status/{id}', 'status')->name('user.status');
    Route::delete('/user/destroy/{id}', 'destroy')->name('user.destroy');
});

//! Library Management Routes (Admin/Staff only)
Route::middleware(['role:admin,staff'])->group(function () {
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Books
    Route::resource('books', BookController::class);
    Route::post('/books/import', [BookController::class, 'import'])->name('books.import');
    Route::get('/books/export', [BookController::class, 'export'])->name('books.export');
    
    // Borrowings
    Route::resource('borrowings', BorrowingController::class);
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'return'])->name('borrowings.return');
    Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    
    // Reservations
    Route::resource('reservations', ReservationController::class);
    Route::post('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/borrowing', [ReportController::class, 'borrowing'])->name('borrowing');
        Route::get('/popular-books', [ReportController::class, 'popularBooks'])->name('popular-books');
        Route::get('/overdue', [ReportController::class, 'overdue'])->name('overdue');
        Route::get('/member-activity', [ReportController::class, 'memberActivity'])->name('member-activity');
    });
});

//! Library Settings (Admin only)
Route::middleware(['role:admin'])->group(function () {
    Route::resource('library-settings', LibrarySettingController::class);
});


