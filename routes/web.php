<?php

use App\Http\Controllers\Web\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

//! Route for Landing Page
Route::get('/', [HomeController::class, 'index'])->name('welcome');

//! Dashboard redirect based on user role
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if (in_array($user->role, ['admin', 'staff'])) {
            return redirect()->route('admin.dashboard');
        } elseif (in_array($user->role, ['student', 'teacher'])) {
            return redirect()->route('member.dashboard');
        }
        
        return redirect()->route('welcome');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
