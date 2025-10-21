@extends('backend.app')

@section('title', 'Edit Buku')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Buku</h1>
            <p class="page-description">{{ $book->title }}</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Buku</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            {{-- Left Column --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $book->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="author" class="form-label">Penulis <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('author') is-invalid @enderror" 
                                           id="author" name="author" value="{{ old('author', $book->author) }}" required>
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                           id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}">
                                    @error('isbn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="publisher" class="form-label">Penerbit <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('publisher') is-invalid @enderror" 
                                           id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}" required>
                                    @error('publisher')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="publication_year" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('publication_year') is-invalid @enderror" 
                                           id="publication_year" name="publication_year" 
                                           value="{{ old('publication_year', $book->publication_year) }}" 
                                           min="1900" max="{{ date('Y') + 1 }}" required>
                                    @error('publication_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="edition" class="form-label">Edisi</label>
                                    <input type="text" class="form-control @error('edition') is-invalid @enderror" 
                                           id="edition" name="edition" value="{{ old('edition', $book->edition) }}">
                                    @error('edition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pages" class="form-label">Jumlah Halaman</label>
                                    <input type="number" class="form-control @error('pages') is-invalid @enderror" 
                                           id="pages" name="pages" value="{{ old('pages', $book->pages) }}" min="1">
                                    @error('pages')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Right Column --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="total_copies" class="form-label">Jumlah Eksemplar <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('total_copies') is-invalid @enderror" 
                                           id="total_copies" name="total_copies" 
                                           value="{{ old('total_copies', $book->total_copies) }}" min="1" required>
                                    <div class="form-text">
                                        Saat ini tersedia: <strong>{{ $book->available_copies }}</strong> dari {{ $book->total_copies }} eksemplar
                                    </div>
                                    @error('total_copies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="borrowed" {{ old('status', $book->status) == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="maintenance" {{ old('status', $book->status) == 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                                        <option value="lost" {{ old('status', $book->status) == 'lost' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="language" class="form-label">Bahasa</label>
                                    <input type="text" class="form-control @error('language') is-invalid @enderror" 
                                           id="language" name="language" value="{{ old('language', $book->language) }}">
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="location" class="form-label">Lokasi Buku</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location', $book->location) }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="book_cover" class="form-label">Sampul Buku</label>
                                    <input type="file" class="form-control @error('book_cover') is-invalid @enderror" 
                                           id="book_cover" name="book_cover" accept="image/*">
                                    <div class="form-text">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB.</div>
                                    @if($book->book_cover)
                                        <div class="mt-2">
                                            <small class="text-muted">Sampul saat ini:</small><br>
                                            <img src="{{ asset('storage/' . $book->book_cover) }}" 
                                                 alt="{{ $book->title }}" 
                                                 class="img-thumbnail mt-1" 
                                                 style="width: 100px; height: 140px; object-fit: cover;">
                                        </div>
                                    @endif
                                    @error('book_cover')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">
                                <i class="fa fa-eye"></i> Lihat Detail
                            </a>
                            <a href="{{ route('books.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
