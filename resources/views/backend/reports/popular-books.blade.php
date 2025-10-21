@extends('backend.app')

@section('title', 'Laporan Buku Populer')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Buku Populer</h1>
            <p class="page-description">Laporan buku yang paling banyak dipinjam</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buku Populer</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    {{-- Filter Form --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter Laporan</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.popular-books') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('reports.popular-books') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Buku Populer</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
                            <th>ISBN</th>
                            <th>Total Dipinjam</th>
                            <th>Salinan Tersedia</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popularBooks as $book)
                        <tr>
                            <td>{{ $loop->iteration + ($popularBooks->currentPage() - 1) * $popularBooks->perPage() }}</td>
                            <td class="text-white">{{ $book->title }}</td>
                            <td class="text-white">{{ $book->author }}</td>
                            <td>{{ $book->category->name ?? '-' }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $book->borrowings_count }}</span>
                            </td>
                            <td>{{ $book->available_copies }}</td>
                            <td>
                                @if($book->available_copies > 0)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data buku</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $popularBooks->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- Top 5 Books Chart --}}
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Top 5 Buku Terpopuler</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($popularBooks->take(5) as $index => $book)
                <div class="col-md-12 mb-3">
                    <div class="d-flex align-items-center p-3 border rounded">
                        <div class="flex-shrink-0">
                            <div class="counter-icon bg-primary text-white me-3">
                                <span class="fw-bold">{{ $index + 1 }}</span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $book->title }}</h5>
                            <p class="text-muted mb-1">oleh {{ $book->author }}</p>
                            <small class="text-muted">Kategori: {{ $book->category->name ?? '-' }}</small>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="badge bg-primary fs-6">{{ $book->borrowings_count }} kali dipinjam</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
