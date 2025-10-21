<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Buku-buku fiksi seperti novel, cerpen, dan karya sastra lainnya',
                'slug' => 'fiksi',
                'status' => 'active',
            ],
            [
                'name' => 'Non-Fiksi',
                'description' => 'Buku-buku non-fiksi seperti biografi, sejarah, dan buku pengetahuan umum',
                'slug' => 'non-fiksi',
                'status' => 'active',
            ],
            [
                'name' => 'Referensi',
                'description' => 'Buku-buku referensi seperti kamus, ensiklopedia, dan buku panduan',
                'slug' => 'referensi',
                'status' => 'active',
            ],
            [
                'name' => 'Majalah',
                'description' => 'Koleksi majalah dan publikasi berkala',
                'slug' => 'majalah',
                'status' => 'active',
            ],
            [
                'name' => 'Jurnal',
                'description' => 'Jurnal akademik dan publikasi ilmiah',
                'slug' => 'jurnal',
                'status' => 'active',
            ],
            [
                'name' => 'Teknologi',
                'description' => 'Buku-buku tentang teknologi, komputer, dan ilmu pengetahuan',
                'slug' => 'teknologi',
                'status' => 'active',
            ],
            [
                'name' => 'Pendidikan',
                'description' => 'Buku-buku pendidikan dan pembelajaran',
                'slug' => 'pendidikan',
                'status' => 'active',
            ],
            [
                'name' => 'Agama',
                'description' => 'Buku-buku keagamaan dan spiritual',
                'slug' => 'agama',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}