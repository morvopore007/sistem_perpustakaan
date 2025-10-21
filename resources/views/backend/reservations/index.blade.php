@extends('backend.app')

@section('title', 'Reservasi')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Reservasi Buku</h1>
            <p class="page-description">Kelola reservasi buku perpustakaan</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservasi</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Tambah Reservasi
            </a>
        </div>
        <div class="col-md-6 text-end">
            <span class="text-muted">Total: {{ $reservations->total() }} reservasi</span>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Reservasi</h3>
        </div>
        <div class="card-body">
            @if($reservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pemesan</th>
                                <th>Buku</th>
                                <th>Tanggal Reservasi</th>
                                <th>Tanggal Kedaluwarsa</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                            <tr>
                                <td>{{ $loop->iteration + ($reservations->currentPage() - 1) * $reservations->perPage() }}</td>
                                <td>
                                    <strong>{{ $reservation->user->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $reservation->user->email }}</small>
                                </td>
                                <td>
                                    <strong>{{ $reservation->book->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $reservation->book->author }}</small>
                                </td>
                                <td>{{ $reservation->reservation_date->format('d/m/Y') }}</td>
                                <td>{{ $reservation->expires_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @switch($reservation->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success">Disetujui</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                            @break
                                        @case('expired')
                                            <span class="badge bg-secondary">Kedaluwarsa</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $reservation->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if($reservation->status == 'pending')
                                            <form action="{{ route('reservations.approve', $reservation) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($reservation->status != 'cancelled' && $reservation->status != 'expired')
                                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm" title="Batalkan">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $reservations->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-muted">Belum ada reservasi</h4>
                    <p class="text-muted">Mulai dengan menambahkan reservasi pertama Anda.</p>
                    <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> Tambah Reservasi Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mt-4">
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold">{{ $reservations->total() }}</h3>
                            <p class="text-muted fs-13 mb-0">Total Reservasi</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold text-warning">{{ $reservations->where('status', 'pending')->count() }}</h3>
                            <p class="text-muted fs-13 mb-0">Menunggu Persetujuan</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-warning text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold text-success">{{ $reservations->where('status', 'approved')->count() }}</h3>
                            <p class="text-muted fs-13 mb-0">Disetujui</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-success text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20,6 9,17 4,12"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold text-danger">{{ $reservations->where('status', 'cancelled')->count() }}</h3>
                            <p class="text-muted fs-13 mb-0">Dibatalkan</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-danger text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
