@extends('backend.app')

@section('title', 'Peminjaman Saya')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Peminjaman Saya</h1>
            <p class="page-description">Lihat buku yang sedang Anda pinjam</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Peminjaman Saya</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Peminjaman Saat Ini</h3>
                    <div class="card-options">
                        <a href="{{ route('member.borrowings.history') }}" class="btn btn-outline-primary">
                            <i class="fe fe-clock"></i> Lihat Riwayat
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($borrowings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Penulis</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrowings as $borrowing)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($borrowing->book->book_cover)
                                                        <img src="{{ asset('storage/' . $borrowing->book->book_cover) }}" 
                                                             alt="{{ $borrowing->book->title }}" 
                                                             class="rounded me-3" 
                                                             style="width: 50px; height: 70px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 50px; height: 70px;">
                                                            <i class="fe fe-book text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $borrowing->book->title }}</h6>
                                                        <small class="text-muted">{{ $borrowing->book->category->name ?? 'Tidak Ada Kategori' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $borrowing->book->author }}</td>
                                            <td>{{ $borrowing->borrow_date->format('d M Y') }}</td>
                                            <td>
                                                <span class="{{ $borrowing->due_date < now() ? 'text-danger' : '' }}">
                                                    {{ $borrowing->due_date->format('d M Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($borrowing->status == 'borrowed')
                                                    <span class="badge bg-primary">Dipinjam</span>
                                                @elseif($borrowing->status == 'overdue')
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($borrowing->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('member.books.show', $borrowing->book) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fe fe-eye"></i> Lihat Buku
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center">
                            {{ $borrowings->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fe fe-book-open" style="font-size: 64px; color: #ccc;"></i>
                            <h4 class="mt-3">Tidak Ada Peminjaman Saat Ini</h4>
                            <p class="text-muted">Anda tidak memiliki buku yang sedang dipinjam saat ini.</p>
                            <a href="{{ route('member.books.index') }}" class="btn btn-primary">
                                <i class="fe fe-search"></i> Jelajahi Buku
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
