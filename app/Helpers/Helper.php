<?php

namespace App\Helpers;

use App\Models\LibrarySetting;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Helper {
    //! File or Image Upload
    public static function fileUpload($file, string $folder, string $name): ?string {
        if (!$file->isValid()) {
            return null;
        }

        $imageName = Str::slug($name) . '.' . $file->extension();
        $path      = public_path('uploads/' . $folder);
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $file->move($path, $imageName);
        return 'uploads/' . $folder . '/' . $imageName;
    }

    //! File or Image Delete
    public static function fileDelete(string $path): void {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    //! Generate Slug
    public static function makeSlug($model, string $title): string {
        $slug = Str::slug($title);
        while ($model::where('slug', $slug)->exists()) {
            $randomString = Str::random(5);
            $slug         = Str::slug($title) . '-' . $randomString;
        }
        return $slug;
    }

    //! Get Library Setting Value
    public static function getLibrarySetting(string $key, $default = null) {
        $setting = LibrarySetting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    //! Calculate Due Date Based on Role
    public static function calculateDueDate(Carbon $borrowDate, string $role): Carbon {
        $maxDays = $role === 'teacher' ? 
            (int) self::getLibrarySetting('max_borrow_days_teacher', 30) : 
            (int) self::getLibrarySetting('max_borrow_days_student', 14);
        
        return $borrowDate->copy()->addDays($maxDays);
    }

    //! Generate Unique Member ID
    public static function generateMemberId(string $role): string {
        $prefix = match($role) {
            'admin' => 'ADM',
            'staff' => 'STF',
            'teacher' => 'GRU',
            'student' => 'SIS',
            default => 'MEM'
        };
        
        $lastMember = User::where('member_id', 'like', $prefix . '%')
            ->orderBy('member_id', 'desc')
            ->first();
        
        if ($lastMember) {
            $lastNumber = (int) substr($lastMember->member_id, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    //! Check if Book is Available
    public static function isBookAvailable(int $bookId): bool {
        $book = Book::find($bookId);
        return $book && $book->available_copies > 0 && $book->status === 'available';
    }

    //! Check if User Can Borrow More Books
    public static function canBorrowMore(int $userId): bool {
        $user = User::find($userId);
        if (!$user) return false;
        
        $maxBooks = $user->role === 'teacher' ? 
            (int) self::getLibrarySetting('max_books_per_teacher', 5) : 
            (int) self::getLibrarySetting('max_books_per_student', 3);
        
        $currentBorrowings = Borrowing::where('user_id', $userId)
            ->where('status', 'borrowed')
            ->count();
        
        return $currentBorrowings < $maxBooks;
    }

    //! Check if User Has Overdue Books
    public static function hasOverdueBooks(int $userId): bool {
        return Borrowing::where('user_id', $userId)
            ->where('status', 'borrowed')
            ->where('due_date', '<', now()->toDateString())
            ->exists();
    }

    //! Get User's Current Borrowings Count
    public static function getCurrentBorrowingsCount(int $userId): int {
        return Borrowing::where('user_id', $userId)
            ->where('status', 'borrowed')
            ->count();
    }

    //! Format Indonesian Date
    public static function formatIndonesianDate(Carbon $date): string {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return $date->day . ' ' . $months[$date->month] . ' ' . $date->year;
    }

    //! Get Role Display Name
    public static function getRoleDisplayName(string $role): string {
        return match($role) {
            'admin' => 'Administrator',
            'staff' => 'Staff Perpustakaan',
            'teacher' => 'Guru',
            'student' => 'Siswa',
            default => 'Anggota'
        };
    }

    //! Get Status Display Name
    public static function getStatusDisplayName(string $status, string $type = 'general'): string {
        if ($type === 'borrowing') {
            return match($status) {
                'borrowed' => 'Dipinjam',
                'returned' => 'Dikembalikan',
                'overdue' => 'Terlambat',
                default => $status
            };
        }
        
        if ($type === 'reservation') {
            return match($status) {
                'pending' => 'Menunggu',
                'approved' => 'Disetujui',
                'cancelled' => 'Dibatalkan',
                'expired' => 'Kedaluwarsa',
                default => $status
            };
        }
        
        return match($status) {
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'available' => 'Tersedia',
            'borrowed' => 'Dipinjam',
            'maintenance' => 'Perawatan',
            'lost' => 'Hilang',
            default => $status
        };
    }

    //! JSON Response
    public static function jsonResponse(bool $status, string $message, int $code, $data = null): JsonResponse {
        $response = [
            'status'  => $status,
            'message' => $message,
            'code'    => $code,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }
        return response()->json($response, $code);
    }
}
