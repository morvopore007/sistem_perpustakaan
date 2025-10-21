<?php

use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\MemberBookController;
use App\Http\Controllers\Web\Backend\MemberBorrowingController;
use App\Http\Controllers\Web\Backend\MemberReservationController;
use App\Http\Controllers\Web\Backend\MemberReviewController;
use App\Http\Controllers\Web\Backend\MemberProfileController;
use Illuminate\Support\Facades\Route;

// Member Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('member.dashboard');

// Member Profile
Route::prefix('profile')->name('member.profile.')->group(function () {
    Route::get('/', [MemberProfileController::class, 'index'])->name('index');
    Route::put('/update', [MemberProfileController::class, 'updateProfile'])->name('update');
    Route::put('/password', [MemberProfileController::class, 'updatePassword'])->name('password');
    Route::put('/avatar', [MemberProfileController::class, 'updateProfilePicture'])->name('avatar');
});

// Member Books
Route::prefix('my-books')->name('member.books.')->group(function () {
    Route::get('/', [MemberBookController::class, 'index'])->name('index');
    Route::get('/{book}', [MemberBookController::class, 'show'])->name('show');
});

// Member Borrowings
Route::prefix('my-borrowings')->name('member.borrowings.')->group(function () {
    Route::get('/', [MemberBorrowingController::class, 'index'])->name('index');
    Route::get('/history', [MemberBorrowingController::class, 'history'])->name('history');
});

// Member Reservations
Route::prefix('my-reservations')->name('member.reservations.')->group(function () {
    Route::get('/', [MemberReservationController::class, 'index'])->name('index');
    Route::post('/', [MemberReservationController::class, 'store'])->name('store');
    Route::delete('/{reservation}', [MemberReservationController::class, 'destroy'])->name('destroy');
});

// Member Reviews
Route::prefix('reviews')->name('member.reviews.')->group(function () {
    Route::post('/', [MemberReviewController::class, 'store'])->name('store');
    Route::put('/{review}', [MemberReviewController::class, 'update'])->name('update');
    Route::delete('/{review}', [MemberReviewController::class, 'destroy'])->name('destroy');
});
