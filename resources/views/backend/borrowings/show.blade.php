@extends('backend.app')

@section('title', 'Detail Peminjaman')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Peminjaman</h1>
            <p class="page-description">Informasi detail peminjaman buku</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('borrowings.index') }}">Peminjaman</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Peminjaman</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Peminjam:</label>
                                <p class="mb-0">{{ $borrowing->user->name }}</p>
                                <small class="text-muted">{{ $borrowing->user->email }}</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Buku:</label>
                                <p class="mb-0">{{ $borrowing->book->title }}</p>
                                <small class="text-muted">{{ $borrowing->book->author }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Pinjam:</label>
                                <p class="mb-0">{{ $borrowing->borrow_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Jatuh Tempo:</label>
                                <p class="mb-0">{{ $borrowing->due_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Kembali:</label>
                                <p class="mb-0">
                                    @if($borrowing->return_date)
                                        {{ $borrowing->return_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Belum dikembalikan</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <p class="mb-0">
                                    @switch($borrowing->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-info">Disetujui</span>
                                            @break
                                        @case('borrowed')
                                            <span class="badge bg-primary">Dipinjam</span>
                                            @break
                                        @case('returned')
                                            <span class="badge bg-success">Dikembalikan</span>
                                            @break
                                        @case('overdue')
                                            <span class="badge bg-danger">Terlambat</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $borrowing->status }}</span>
                                    @endswitch
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Disetujui Oleh:</label>
                                <p class="mb-0">
                                    @if($borrowing->approvedBy)
                                        {{ $borrowing->approvedBy->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($borrowing->notes)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan:</label>
                        <p class="mb-0">{{ $borrowing->notes }}</p>
                    </div>
                    @endif

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('borrowings.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <a href="{{ route('borrowings.edit', $borrowing) }}" class="btn btn-warning me-2">Edit</a>
                        @if($borrowing->status == 'pending')
                            <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success me-2">Setujui</button>
                            </form>
                        @endif
                        @if($borrowing->status == 'borrowed')
                            <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-info">Kembalikan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Buku</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($borrowing->book->book_cover)
                            <img src="{{ asset('storage/' . $borrowing->book->book_cover) }}" alt="Cover" class="img-fluid rounded" style="max-height: 200px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fa fa-book fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h5>{{ $borrowing->book->title }}</h5>
                    <p class="text-muted">{{ $borrowing->book->author }}</p>
                    
                    <div class="mb-2">
                        <strong>Kategori:</strong> {{ $borrowing->book->category->name ?? '-' }}
                    </div>
                    
                    <div class="mb-2">
                        <strong>ISBN:</strong> {{ $borrowing->book->isbn ?? '-' }}
                    </div>
                    
                    <div class="mb-2">
                        <strong>Tahun Terbit:</strong> {{ $borrowing->book->publication_year ?? '-' }}
                    </div>
                    
                    <div class="mb-2">
                        <strong>Jumlah Tersedia:</strong> {{ $borrowing->book->available_copies }}
                    </div>
                    
                    @if($borrowing->book->description)
                    <div class="mt-3">
                        <strong>Deskripsi:</strong>
                        <p class="text-muted small">{{ \Illuminate\Support\Str::limit($borrowing->book->description, 150) }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
