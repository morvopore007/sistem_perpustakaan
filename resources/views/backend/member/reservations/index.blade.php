@extends('backend.app')

@section('title', 'Reservasi Saya')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Reservasi Saya</h1>
            <p class="page-description">Kelola reservasi buku Anda</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservasi Saya</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reservasi Saya</h3>
                    <div class="card-options">
                        <a href="{{ route('member.books.index') }}" class="btn btn-outline-primary">
                            <i class="fe fe-search"></i> Jelajahi Buku
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Form Filter --}}
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('member.reservations.index') }}" class="btn btn-outline-secondary">Bersihkan</a>
                            </div>
                        </div>
                    </form>

                    @if($reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Penulis</th>
                                        <th>Tanggal Reservasi</th>
                                        <th>Berlaku Sampai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($reservation->book->book_cover)
                                                        <img src="{{ asset('storage/' . $reservation->book->book_cover) }}" 
                                                             alt="{{ $reservation->book->title }}" 
                                                             class="rounded me-3" 
                                                             style="width: 50px; height: 70px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 50px; height: 70px;">
                                                            <i class="fe fe-book text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $reservation->book->title }}</h6>
                                                        <small class="text-muted">{{ $reservation->book->category->name ?? 'Tidak Ada Kategori' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $reservation->book->author }}</td>
                                            <td>{{ $reservation->reservation_date->format('d M Y') }}</td>
                                            <td>
                                                <span class="{{ $reservation->expires_at < now() ? 'text-danger' : '' }}">
                                                    {{ $reservation->expires_at->format('d M Y H:i') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($reservation->status == 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif($reservation->status == 'confirmed')
                                                    <span class="badge bg-success">Dikonfirmasi</span>
                                                @elseif($reservation->status == 'expired')
                                                    <span class="badge bg-danger">Kedaluwarsa</span>
                                                @elseif($reservation->status == 'cancelled')
                                                    <span class="badge bg-secondary">Dibatalkan</span>
                                                @else
                                                    <span class="badge bg-info">{{ ucfirst($reservation->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('member.books.show', $reservation->book) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fe fe-eye"></i> Lihat Buku
                                                    </a>
                                                    @if(in_array($reservation->status, ['pending', 'confirmed']))
                                                        <form action="{{ route('member.reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                                                <i class="fe fe-x"></i> Batal
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-center">
                            {{ $reservations->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fe fe-calendar" style="font-size: 64px; color: #ccc;"></i>
                            <h4 class="mt-3">Tidak Ada Reservasi</h4>
                            <p class="text-muted">Anda tidak memiliki reservasi buku saat ini.</p>
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
