<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first available category or create one
        $category = Category::first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Fiksi',
                'slug' => 'fiksi',
                'description' => 'Buku fiksi dan novel'
            ]);
        }

        // Create sample books
        $books = [
            [
                'category_id' => $category->id,
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '9789793062792',
                'publisher' => 'Bentang Pustaka',
                'publication_year' => 2005,
                'edition' => '1',
                'total_copies' => 5,
                'available_copies' => 5,
                'description' => 'Novel tentang persahabatan dan pendidikan di Belitung',
                'location' => 'Rak A1',
                'language' => 'Indonesia',
                'pages' => 529,
                'status' => 'available'
            ],
            [
                'category_id' => $category->id,
                'title' => 'Ayat-Ayat Cinta',
                'author' => 'Habiburrahman El Shirazy',
                'isbn' => '9789793062793',
                'publisher' => 'Republika',
                'publication_year' => 2004,
                'edition' => '1',
                'total_copies' => 3,
                'available_copies' => 2,
                'description' => 'Novel romantis dengan nilai-nilai Islam',
                'location' => 'Rak A2',
                'language' => 'Indonesia',
                'pages' => 418,
                'status' => 'available'
            ],
            [
                'category_id' => $category->id,
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'M.C. Ricklefs',
                'isbn' => '9789793062794',
                'publisher' => 'Gadjah Mada University Press',
                'publication_year' => 2008,
                'edition' => '2',
                'total_copies' => 2,
                'available_copies' => 1,
                'description' => 'Buku referensi sejarah Indonesia',
                'location' => 'Rak B1',
                'language' => 'Indonesia',
                'pages' => 720,
                'status' => 'available'
            ],
            [
                'category_id' => $category->id,
                'title' => 'Matematika Dasar',
                'author' => 'Prof. Dr. Suharsimi Arikunto',
                'isbn' => '9789793062795',
                'publisher' => 'Rineka Cipta',
                'publication_year' => 2010,
                'edition' => '3',
                'total_copies' => 10,
                'available_copies' => 8,
                'description' => 'Buku pelajaran matematika untuk SMA',
                'location' => 'Rak C1',
                'language' => 'Indonesia',
                'pages' => 350,
                'status' => 'available'
            ],
            [
                'category_id' => $category->id,
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'isbn' => '9789793062796',
                'publisher' => 'Bloomsbury',
                'publication_year' => 1997,
                'edition' => '1',
                'total_copies' => 4,
                'available_copies' => 0,
                'description' => 'Novel fantasi tentang penyihir muda',
                'location' => 'Rak A3',
                'language' => 'English',
                'pages' => 223,
                'status' => 'maintenance'
            ]
        ];

        foreach ($books as $bookData) {
            Book::firstOrCreate(
                ['isbn' => $bookData['isbn']],
                $bookData
            );
        }

        $this->command->info('Sample books created successfully!');
    }
}
