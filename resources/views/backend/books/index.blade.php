@extends('backend.app')

@section('title', 'Manajemen Buku')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Buku</h1>
            <p class="page-description">Kelola koleksi buku perpustakaan</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buku</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter and Search --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filter & Pencarian</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('books.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search" class="form-label">Pencarian</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" placeholder="Cari judul, penulis, ISBN, atau penerbit...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category_id" class="form-label">Kategori</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                                        <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Books Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Buku ({{ $books->total() }} buku)</h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('books.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Tambah Buku
                            </a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fa fa-upload"></i> Import
                            </button>
                            <a href="{{ route('books.export') }}" class="btn btn-info">
                                <i class="fa fa-download"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sampul</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>ISBN</th>
                                    <th>Eksemplar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($books as $book)
                                    <tr>
                                        <td>{{ $books->firstItem() + $loop->index }}</td>
                                        <td>
                                            @if($book->book_cover)
                                                <img src="{{ asset('storage/' . $book->book_cover) }}" 
                                                     alt="{{ $book->title }}" 
                                                     class="img-thumbnail" 
                                                     style="width: 50px; height: 70px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 70px;">
                                                    <i class="fa fa-book text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $book->title }}</strong>
                                            @if($book->edition)
                                                <br><small class="text-muted">Edisi: {{ $book->edition }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $book->author }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $book->category->name }}</span>
                                        </td>
                                        <td>{{ $book->isbn ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $book->available_copies > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $book->available_copies }}/{{ $book->total_copies }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match($book->status) {
                                                    'available' => 'bg-success',
                                                    'borrowed' => 'bg-warning',
                                                    'maintenance' => 'bg-info',
                                                    'lost' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                                $statusText = match($book->status) {
                                                    'available' => 'Tersedia',
                                                    'borrowed' => 'Dipinjam',
                                                    'maintenance' => 'Perawatan',
                                                    'lost' => 'Hilang',
                                                    default => 'Tidak Diketahui'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('books.show', $book) }}" 
                                                   class="btn btn-sm btn-info" title="Lihat Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('books.edit', $book) }}" 
                                                   class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('books.destroy', $book) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fa fa-book fa-3x mb-3"></i>
                                                <p>Tidak ada buku ditemukan.</p>
                                                <a href="{{ route('books.create') }}" class="btn btn-primary">
                                                    <i class="fa fa-plus"></i> Tambah Buku Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($books->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $books->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Import Modal --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('books.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file" class="form-label">Pilih File</label>
                            <input type="file" class="form-control" id="file" name="file" 
                                   accept=".xlsx,.xls,.csv" required>
                            <div class="form-text">Format yang didukung: Excel (.xlsx, .xls) atau CSV (.csv)</div>
                        </div>
                        <div class="alert alert-info">
                            <strong>Petunjuk:</strong>
                            <ul class="mb-0">
                                <li>Pastikan file memiliki kolom: title, author, isbn, publisher, publication_year, total_copies, category_id</li>
                                <li>Download template terlebih dahulu untuk memastikan format yang benar</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
