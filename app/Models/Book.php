<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'isbn',
        'publisher',
        'publication_year',
        'edition',
        'total_copies',
        'available_copies',
        'book_cover',
        'description',
        'location',
        'language',
        'pages',
        'status',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'total_copies' => 'integer',
        'available_copies' => 'integer',
        'pages' => 'integer',
        'status' => 'string',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(BookReview::class);
    }
}