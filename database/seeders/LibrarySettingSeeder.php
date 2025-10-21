<?php

namespace Database\Seeders;

use App\Models\LibrarySetting;
use Illuminate\Database\Seeder;

class LibrarySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'max_borrow_days_student',
                'value' => '14',
                'description' => 'Maksimal hari peminjaman untuk siswa',
            ],
            [
                'key' => 'max_borrow_days_teacher',
                'value' => '30',
                'description' => 'Maksimal hari peminjaman untuk guru',
            ],
            [
                'key' => 'max_books_per_student',
                'value' => '3',
                'description' => 'Maksimal jumlah buku yang bisa dipinjam siswa',
            ],
            [
                'key' => 'max_books_per_teacher',
                'value' => '5',
                'description' => 'Maksimal jumlah buku yang bisa dipinjam guru',
            ],
            [
                'key' => 'reservation_expiry_days',
                'value' => '7',
                'description' => 'Berapa hari reservasi berlaku sebelum expired',
            ],
            [
                'key' => 'library_name',
                'value' => 'Perpustakaan Digital',
                'description' => 'Nama perpustakaan',
            ],
            [
                'key' => 'library_address',
                'value' => 'Jl. Pendidikan No. 123, Jakarta',
                'description' => 'Alamat perpustakaan',
            ],
            [
                'key' => 'library_phone',
                'value' => '(021) 1234-5678',
                'description' => 'Nomor telepon perpustakaan',
            ],
            [
                'key' => 'library_email',
                'value' => 'perpustakaan@sekolah.edu',
                'description' => 'Email perpustakaan',
            ],
        ];

        foreach ($settings as $setting) {
            LibrarySetting::create($setting);
        }
    }
}