@extends('backend.app')

@section('title', 'Detail Reservasi')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Reservasi</h1>
            <p class="page-description">Informasi lengkap reservasi buku</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
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

    <div class="row">
        {{-- Main Information --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Reservasi</h3>
                    <div class="card-options">
                        <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">ID Reservasi:</td>
                                    <td>#{{ $reservation->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
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
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Reservasi:</td>
                                    <td>{{ $reservation->reservation_date->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kedaluwarsa:</td>
                                    <td>{{ $reservation->expires_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Dibuat:</td>
                                    <td>{{ $reservation->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Diperbarui:</td>
                                    <td>{{ $reservation->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Durasi:</td>
                                    <td>
                                        @php
                                            $days = $reservation->created_at->diffInDays($reservation->expires_at);
                                        @endphp
                                        {{ $days }} hari
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Member Information --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Anggota</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="avatar avatar-xl mb-3">
                                    <img src="{{ $reservation->user->profile_picture ? asset($reservation->user->profile_picture) : asset('frontend/profile-avatar.png') }}" 
                                         alt="Profile" class="rounded-circle">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Nama:</td>
                                    <td>{{ $reservation->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>{{ $reservation->user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Role:</td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($reservation->user->role) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Bergabung:</td>
                                    <td>{{ $reservation->user->created_at->format('d F Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Book Information --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Buku</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                @if($reservation->book->book_cover)
                                    <img src="{{ asset($reservation->book->book_cover) }}" 
                                         alt="Book Cover" class="img-fluid rounded" style="max-height: 200px;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fa fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Judul:</td>
                                    <td>{{ $reservation->book->title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Penulis:</td>
                                    <td>{{ $reservation->book->author }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Penerbit:</td>
                                    <td>{{ $reservation->book->publisher }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tahun Terbit:</td>
                                    <td>{{ $reservation->book->publication_year }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">ISBN:</td>
                                    <td>{{ $reservation->book->isbn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status Buku:</td>
                                    <td>
                                        @switch($reservation->book->status)
                                            @case('available')
                                                <span class="badge bg-success">Tersedia</span>
                                                @break
                                            @case('borrowed')
                                                <span class="badge bg-warning">Dipinjam</span>
                                                @break
                                            @case('maintenance')
                                                <span class="badge bg-info">Perawatan</span>
                                                @break
                                            @case('lost')
                                                <span class="badge bg-danger">Hilang</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $reservation->book->status }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Actions --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Aksi</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($reservation->status == 'pending')
                            <form action="{{ route('reservations.approve', $reservation) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fa fa-check"></i> Setujui Reservasi
                                </button>
                            </form>
                        @endif

                        @if($reservation->status != 'cancelled' && $reservation->status != 'expired')
                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100" 
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                    <i class="fa fa-times"></i> Batalkan Reservasi
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-primary w-100">
                            <i class="fa fa-edit"></i> Edit Reservasi
                        </a>

                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fa fa-trash"></i> Hapus Reservasi
                            </button>
                        </form>

                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary w-100">
                            <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            {{-- Status Timeline --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Timeline Status</h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Reservasi Dibuat</h6>
                                <p class="timeline-text">{{ $reservation->created_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($reservation->status == 'approved')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Reservasi Disetujui</h6>
                                    <p class="timeline-text">{{ $reservation->updated_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        @elseif($reservation->status == 'cancelled')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Reservasi Dibatalkan</h6>
                                    <p class="timeline-text">{{ $reservation->updated_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        @elseif($reservation->status == 'expired')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-secondary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Reservasi Kedaluwarsa</h6>
                                    <p class="timeline-text">{{ $reservation->expires_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    
    .timeline-content {
        padding-left: 10px;
    }
    
    .timeline-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .timeline-text {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 0;
    }
    
    .avatar {
        width: 80px;
        height: 80px;
    }
    
    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush
