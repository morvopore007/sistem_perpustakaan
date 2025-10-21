@extends('backend.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Peminjaman</h1>
            <p class="page-description">Lihat riwayat peminjaman Anda</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('member.borrowings.index') }}">Peminjaman Saya</a></li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Peminjaman</h3>
                </div>
                <div class="card-body">
                    {{-- Form Filter --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('member.borrowings.history') }}" class="btn btn-outline-secondary">Bersihkan</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if($borrowings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Penulis</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Tanggal Kembali</th>
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
                                            <td>{{ $borrowing->due_date->format('d M Y') }}</td>
                                            <td>
                                                @if($borrowing->return_date)
                                                    {{ $borrowing->return_date->format('d M Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($borrowing->status == 'returned')
                                                    <span class="badge bg-success">Dikembalikan</span>
                                                @elseif($borrowing->status == 'lost')
                                                    <span class="badge bg-danger">Hilang</span>
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
                            <i class="fe fe-clock" style="font-size: 64px; color: #ccc;"></i>
                            <h4 class="mt-3">Tidak Ada Riwayat Ditemukan</h4>
                            <p class="text-muted">Tidak ada riwayat peminjaman ditemukan untuk kriteria yang dipilih.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
