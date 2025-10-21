@extends('backend.app')

@section('title', 'Tambah Reservasi')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Reservasi Baru</h1>
            <p class="page-description">Buat reservasi buku untuk anggota perpustakaan</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
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
                    <h3 class="card-title">Form Tambah Reservasi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        
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
                                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                                                    {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                                {{ $book->title }} - {{ $book->author }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('book_id')
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
                                           value="{{ old('reservation_date', date('Y-m-d')) }}" required>
                                    @error('reservation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="expires_at" class="form-label">Tanggal Kedaluwarsa <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" 
                                           id="expires_at" name="expires_at" 
                                           value="{{ old('expires_at', date('Y-m-d\TH:i', strtotime('+7 days'))) }}" required>
                                    <div class="form-text">Reservasi akan kedaluwarsa pada tanggal dan waktu yang ditentukan.</div>
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Info Card --}}
                        <div class="alert alert-info">
                            <h5 class="alert-heading">
                                <i class="fa fa-info-circle me-2"></i>Informasi Reservasi
                            </h5>
                            <ul class="mb-0">
                                <li>Reservasi akan dibuat dengan status <strong>"Menunggu"</strong></li>
                                <li>Anggota yang dipilih harus memiliki role selain admin</li>
                                <li>Buku yang dipilih harus dalam status "Tersedia"</li>
                                <li>Jika anggota sudah memiliki reservasi untuk buku yang sama, reservasi tidak akan dibuat</li>
                            </ul>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Buat Reservasi
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
    });
</script>
@endpush
