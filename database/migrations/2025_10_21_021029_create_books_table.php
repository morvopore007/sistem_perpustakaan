<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title', 200);
            $table->string('author', 150);
            $table->string('isbn', 20)->unique()->nullable();
            $table->string('publisher', 100)->nullable();
            $table->year('publication_year')->nullable();
            $table->string('edition', 50)->nullable();
            $table->integer('total_copies')->default(1);
            $table->integer('available_copies')->default(1);
            $table->string('book_cover')->nullable();
            $table->text('description')->nullable();
            $table->string('location', 100)->nullable();
            $table->string('language', 50)->default('Indonesia');
            $table->integer('pages')->nullable();
            $table->enum('status', ['available', 'borrowed', 'maintenance', 'lost'])->default('available');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
