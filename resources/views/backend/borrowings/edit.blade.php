@extends('backend.app')

@section('title', 'Edit Peminjaman')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Peminjaman</h1>
            <p class="page-description">Edit informasi peminjaman buku</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('borrowings.index') }}">Peminjaman</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Peminjaman</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('borrowings.update', $borrowing) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Peminjam <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                        <option value="">Pilih Peminjam</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $borrowing->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="book_id" class="form-label">Buku <span class="text-danger">*</span></label>
                                    <select name="book_id" id="book_id" class="form-select @error('book_id') is-invalid @enderror" required>
                                        <option value="">Pilih Buku</option>
                                        @foreach($books as $book)
                                            <option value="{{ $book->id }}" {{ old('book_id', $borrowing->book_id) == $book->id ? 'selected' : '' }}>
                                                {{ $book->title }} - {{ $book->author }} (Tersedia: {{ $book->available_copies }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('book_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="borrow_date" class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                                    <input type="date" name="borrow_date" id="borrow_date" class="form-control @error('borrow_date') is-invalid @enderror" value="{{ old('borrow_date', $borrowing->borrow_date->format('Y-m-d')) }}" required>
                                    @error('borrow_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                    <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date', $borrowing->due_date->format('Y-m-d')) }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="return_date" class="form-label">Tanggal Kembali</label>
                                    <input type="date" name="return_date" id="return_date" class="form-control @error('return_date') is-invalid @enderror" value="{{ old('return_date', $borrowing->return_date ? $borrowing->return_date->format('Y-m-d') : '') }}">
                                    @error('return_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="pending" {{ old('status', $borrowing->status) == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ old('status', $borrowing->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="borrowed" {{ old('status', $borrowing->status) == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="returned" {{ old('status', $borrowing->status) == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="overdue" {{ old('status', $borrowing->status) == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Catatan tambahan...">{{ old('notes', $borrowing->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('borrowings.show', $borrowing) }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h5 class="alert-heading">Perhatian:</h5>
                        <ul class="mb-0">
                            <li>Ubah status dengan hati-hati</li>
                            <li>Jika mengubah status ke "Dikembalikan", pastikan tanggal kembali sudah diisi</li>
                            <li>Status "Terlambat" akan otomatis dihitung berdasarkan tanggal jatuh tempo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
