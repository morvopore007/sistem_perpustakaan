@extends('backend.app')

@section('title', $book->title)

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $book->title }}</h1>
            <p class="page-description">Detail Buku</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('member.books.index') }}">Buku Saya</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($book->title, 20) }}</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    @if($book->book_cover)
                        <img src="{{ asset('storage/' . $book->book_cover) }}" 
                             alt="{{ $book->title }}" 
                             class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                             style="height: 300px;">
                            <i class="fe fe-book" style="font-size: 64px; color: #ccc;"></i>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <span class="badge bg-success fs-6">{{ $book->available_copies }} Tersedia</span>
                    </div>
                    
                    @if($book->available_copies > 0)
                        <form action="{{ route('member.reservations.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-plus"></i> Reservasi Buku
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary" disabled>
                            <i class="fe fe-x"></i> Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Buku</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Judul:</strong></td>
                                    <td>{{ $book->title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penulis:</strong></td>
                                    <td>{{ $book->author }}</td>
                                </tr>
                                <tr>
                                    <td><strong>ISBN:</strong></td>
                                    <td>{{ $book->isbn }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penerbit:</strong></td>
                                    <td>{{ $book->publisher }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kategori:</strong></td>
                                    <td>{{ $book->category->name ?? 'Tidak Ada Kategori' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Tahun Terbit:</strong></td>
                                    <td>{{ $book->publication_year }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Edisi:</strong></td>
                                    <td>{{ $book->edition }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Halaman:</strong></td>
                                    <td>{{ $book->pages }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bahasa:</strong></td>
                                    <td>{{ $book->language }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi:</strong></td>
                                    <td>{{ $book->location }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($book->description)
                        <div class="mt-4">
                            <h5>Deskripsi</h5>
                            <p>{{ $book->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bagian Review --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Ulasan</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <span class="me-2">Rating Rata-rata:</span>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $averageRating)
                                        <i class="fe fe-star text-warning"></i>
                                    @else
                                        <i class="fe fe-star text-muted"></i>
                                    @endif
                                @endfor
                                <span class="ms-2">{{ number_format($averageRating, 1) }}/5</span>
                            </div>
                        </div>
                    </div>

                    {{-- Form Review Pengguna --}}
                    @if(!$userReview && auth()->user()->borrowings()->where('book_id', $book->id)->where('status', 'returned')->exists())
                        <div class="mb-4">
                            <h5>Tulis Ulasan</h5>
                            <form action="{{ route('member.reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <select name="rating" class="form-control" required>
                                        <option value="">Pilih Rating</option>
                                        <option value="1">1 Bintang</option>
                                        <option value="2">2 Bintang</option>
                                        <option value="3">3 Bintang</option>
                                        <option value="4">4 Bintang</option>
                                        <option value="5">5 Bintang</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ulasan</label>
                                    <textarea name="review" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                            </form>
                        </div>
                    @elseif($userReview)
                        <div class="mb-4">
                            <h5>Ulasan Anda</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="rating mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $userReview->rating)
                                                        <i class="fe fe-star text-warning"></i>
                                                    @else
                                                        <i class="fe fe-star text-muted"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p>{{ $userReview->review }}</p>
                                        </div>
                                        <div>
                                            <form action="{{ route('member.reviews.destroy', $userReview) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Ulasan Lainnya --}}
                    @if($book->reviews->count() > 0)
                        <h5>Ulasan Lainnya</h5>
                        @foreach($book->reviews->where('user_id', '!=', auth()->id()) as $review)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="rating mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fe fe-star text-warning"></i>
                                                    @else
                                                        <i class="fe fe-star text-muted"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="mb-1"><strong>{{ $review->user->name }}</strong></p>
                                            <p>{{ $review->review }}</p>
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Belum ada ulasan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
