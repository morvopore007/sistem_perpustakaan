@extends('backend.app')

@section('title', 'Edit Reservasi')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Reservasi</h1>
            <p class="page-description">Ubah informasi reservasi buku</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservasi</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reservations.show', $reservation) }}">Detail</a></li>
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
                    <h3 class="card-title">Form Edit Reservasi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('reservations.update', $reservation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            {{-- Left Column --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="user_id" class="form-label">Anggota <span class="text-danger">*</span></label>
                                    <select class="form-control @error('user_id') is-invalid @enderror" 
                                            id="user_id" name="user_id" required>
                                        <option value="">Pilih Anggota</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                    {{ old('user_id', $reservation->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="book_id" class="form-label">Buku <span class="text-danger">*</span></label>
                                    <select class="form-control @error('book_id') is-invalid @enderror" 
                                            id="book_id" name="book_id" required>
                                        <option value="">Pilih Buku</option>
                                        @foreach($books as $book)
                                            <option value="{{ $book->id }}" 
                                                    {{ old('book_id', $reservation->book_id) == $book->id ? 'selected' : '' }}>
                                                {{ $book->title }} - {{ $book->author }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('book_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="approved" {{ old('status', $reservation->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                        <option value="expired" {{ old('status', $reservation->status) == 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Right Column --}}
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="reservation_date" class="form-label">Tanggal Reservasi <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" 
                                           id="reservation_date" name="reservation_date" 
                                           value="{{ old('reservation_date', $reservation->reservation_date->format('Y-m-d')) }}" required>
                                    @error('reservation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="expires_at" class="form-label">Tanggal Kedaluwarsa <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" 
                                           id="expires_at" name="expires_at" 
                                           value="{{ old('expires_at', $reservation->expires_at->format('Y-m-d\TH:i')) }}" required>
                                    <div class="form-text">Reservasi akan kedaluwarsa pada tanggal dan waktu yang ditentukan.</div>
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Current Information Card --}}
                        <div class="alert alert-info">
                            <h5 class="alert-heading">
                                <i class="fa fa-info-circle me-2"></i>Informasi Saat Ini
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Anggota:</strong> {{ $reservation->user->name }}</p>
                                    <p><strong>Buku:</strong> {{ $reservation->book->title }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Status:</strong> 
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
                                        @endswitch
                                    </p>
                                    <p><strong>Dibuat:</strong> {{ $reservation->created_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-set expiration date when reservation date changes
        const reservationDateInput = document.getElementById('reservation_date');
        const expiresAtInput = document.getElementById('expires_at');
        
        reservationDateInput.addEventListener('change', function() {
            if (this.value) {
                const reservationDate = new Date(this.value);
                const expirationDate = new Date(reservationDate);
                expirationDate.setDate(expirationDate.getDate() + 7); // Add 7 days
                expirationDate.setHours(23, 59, 0, 0); // Set to end of day
                
                const formattedDate = expirationDate.toISOString().slice(0, 16);
                expiresAtInput.value = formattedDate;
            }
        });

        // Status change warning
        const statusSelect = document.getElementById('status');
        const originalStatus = '{{ $reservation->status }}';
        
        statusSelect.addEventListener('change', function() {
            if (this.value !== originalStatus) {
                const statusText = this.options[this.selectedIndex].text;
                if (confirm(`Apakah Anda yakin ingin mengubah status reservasi menjadi "${statusText}"?`)) {
                    // Status change confirmed
                } else {
                    // Revert to original status
                    this.value = originalStatus;
                }
            }
        });
    });
</script>
@endpush
