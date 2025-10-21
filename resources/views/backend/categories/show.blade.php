@extends('backend.app')

@section('title', 'Detail Kategori')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Kategori</h1>
            <p class="page-description">Informasi lengkap kategori "{{ $category->name }}"</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Kategori</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-8">
            {{-- Category Information --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Kategori</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Nama Kategori:</h6>
                            <p class="mb-3">{{ $category->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Slug:</h6>
                            <p class="mb-3"><code>{{ $category->slug }}</code></p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Status:</h6>
                            <p class="mb-3">
                                @if($category->status == 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Jumlah Buku:</h6>
                            <p class="mb-3"><span class="badge bg-primary">{{ $category->books_count }} buku</span></p>
                        </div>
                    </div>
                    
                    @if($category->description)
                    <div class="row">
                        <div class="col-12">
                            <h6>Deskripsi:</h6>
                            <p class="mb-3">{{ $category->description }}</p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Dibuat:</h6>
                            <p class="mb-3">{{ $category->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Terakhir Diupdate:</h6>
                            <p class="mb-3">{{ $category->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Books in this Category --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buku dalam Kategori Ini</h3>
                </div>
                <div class="card-body">
                    @if($category->books->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Penulis</th>
                                        <th>ISBN</th>
                                        <th>Status</th>
                                        <th>Salinan Tersedia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->books as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->isbn }}</td>
                                        <td>
                                            @if($book->status == 'available')
                                                <span class="badge bg-success">Tersedia</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                        <td>{{ $book->available_copies }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                            </div>
                            <h5 class="text-muted">Belum ada buku dalam kategori ini</h5>
                            <p class="text-muted">Buku yang ditambahkan dengan kategori ini akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            {{-- Action Buttons --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aksi</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fa fa-edit me-1"></i> Edit Kategori
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            {{-- Category Stats --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Statistik</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary">{{ $category->books_count }}</h4>
                            <p class="text-muted mb-0">Total Buku</p>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $category->books->where('status', 'available')->count() }}</h4>
                            <p class="text-muted mb-0">Tersedia</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Info --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Cepat</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fa fa-info-circle me-1"></i> Info:</h6>
                        <ul class="mb-0">
                            <li>Slug digunakan untuk URL yang SEO-friendly</li>
                            <li>Kategori aktif dapat dipilih saat menambah buku</li>
                            <li>Kategori dengan buku tidak dapat dihapus</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
