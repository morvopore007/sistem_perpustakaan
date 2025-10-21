@extends('backend.app')

@section('title', 'Detail Buku')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Buku</h1>
            <p class="page-description">{{ $book->title }}</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        {{-- Book Information --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Informasi Buku</h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('books.destroy', $book) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Judul:</strong></td>
                                    <td>{{ $book->title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penulis:</strong></td>
                                    <td>{{ $book->author }}</td>
                                </tr>
                                <tr>
                                    <td><strong>ISBN:</strong></td>
                                    <td>{{ $book->isbn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penerbit:</strong></td>
                                    <td>{{ $book->publisher }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Terbit:</strong></td>
                                    <td>{{ $book->publication_year }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Edisi:</strong></td>
                                    <td>{{ $book->edition ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Kategori:</strong></td>
                                    <td><span class="badge bg-primary">{{ $book->category->name }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Eksemplar:</strong></td>
                                    <td>{{ $book->total_copies }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tersedia:</strong></td>
                                    <td>
                                        <span class="badge {{ $book->available_copies > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $book->available_copies }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
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
                                </tr>
                                <tr>
                                    <td><strong>Bahasa:</strong></td>
                                    <td>{{ $book->language ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Halaman:</strong></td>
                                    <td>{{ $book->pages ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi:</strong></td>
                                    <td>{{ $book->location ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($book->description)
                        <hr>
                        <h5>Deskripsi</h5>
                        <p class="text-muted">{{ $book->description }}</p>
                    @endif
                </div>
            </div>

            {{-- Borrowing History --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Peminjaman</h3>
                </div>
                <div class="card-body">
                    @if($book->borrowings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Peminjam</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($book->borrowings->take(10) as $borrowing)
                                        <tr>
                                            <td>{{ $borrowing->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}</td>
                                            <td>
                                                @if($borrowing->return_date)
                                                    {{ \Carbon\Carbon::parse($borrowing->return_date)->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass = match($borrowing->status) {
                                                        'borrowed' => 'bg-warning',
                                                        'returned' => 'bg-success',
                                                        'overdue' => 'bg-danger',
                                                        default => 'bg-secondary'
                                                    };
                                                    $statusText = match($borrowing->status) {
                                                        'borrowed' => 'Dipinjam',
                                                        'returned' => 'Dikembalikan',
                                                        'overdue' => 'Terlambat',
                                                        default => 'Tidak Diketahui'
                                                    };
                                                @endphp
                                                <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($book->borrowings->count() > 10)
                            <p class="text-muted">Menampilkan 10 dari {{ $book->borrowings->count() }} peminjaman.</p>
                        @endif
                    @else
                        <p class="text-muted">Belum ada riwayat peminjaman.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Book Cover and Statistics --}}
        <div class="col-md-4">
            {{-- Book Cover --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sampul Buku</h3>
                </div>
                <div class="card-body text-center">
                    @if($book->book_cover)
                        <img src="{{ asset('storage/' . $book->book_cover) }}" 
                             alt="{{ $book->title }}" 
                             class="img-fluid rounded shadow" 
                             style="max-height: 400px;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                             style="height: 300px;">
                            <div class="text-center">
                                <i class="fa fa-book fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada sampul</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Statistics --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Statistik</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ $book->borrowings->count() }}</h4>
                                <p class="text-muted mb-0">Total Pinjam</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $book->reservations->count() }}</h4>
                            <p class="text-muted mb-0">Reservasi</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-info">{{ $book->reviews->count() }}</h4>
                                <p class="text-muted mb-0">Ulasan</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning">
                                @if($book->reviews->count() > 0)
                                    {{ number_format($book->reviews->avg('rating'), 1) }}
                                @else
                                    -
                                @endif
                            </h4>
                            <p class="text-muted mb-0">Rating</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Reviews --}}
            @if($book->reviews->count() > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Ulasan Terbaru</h3>
                    </div>
                    <div class="card-body">
                        @foreach($book->reviews->take(3) as $review)
                            <div class="border-bottom pb-2 mb-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <strong>{{ $review->user->name }}</strong>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted mb-1">{{ Str::limit($review->comment, 100) }}</p>
                                <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
