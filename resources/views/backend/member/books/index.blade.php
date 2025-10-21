@extends('backend.app')

@section('title', 'Buku Saya')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Buku Saya</h1>
            <p class="page-description">Jelajahi dan cari buku yang tersedia</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buku Saya</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buku Tersedia</h3>
                </div>
                <div class="card-body">
                    {{-- Pencarian dan Filter --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control" placeholder="Cari buku..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>

                    {{-- Grid Buku --}}
                    <div class="row">
                        @forelse($books as $book)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            @if($book->book_cover)
                                                <img src="{{ asset('storage/' . $book->book_cover) }}" 
                                                     alt="{{ $book->title }}" 
                                                     class="img-fluid rounded" 
                                                     style="height: 200px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="height: 200px;">
                                                    <i class="fe fe-book" style="font-size: 48px; color: #ccc;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <h5 class="card-title">{{ Str::limit($book->title, 30) }}</h5>
                                        <p class="text-muted">{{ $book->author }}</p>
                                        <p class="text-muted small">{{ $book->category->name ?? 'Tidak Ada Kategori' }}</p>
                                        
                                        <div class="mb-2">
                                            <span class="badge bg-success">{{ $book->available_copies }} Tersedia</span>
                                        </div>
                                        
                                        <a href="{{ route('member.books.show', $book) }}" class="btn btn-primary btn-sm">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fe fe-book" style="font-size: 64px; color: #ccc;"></i>
                                    <h4 class="mt-3">Tidak ada buku ditemukan</h4>
                                    <p class="text-muted">Coba sesuaikan kriteria pencarian Anda</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
