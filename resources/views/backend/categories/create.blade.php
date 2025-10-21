@extends('backend.app')

@section('title', 'Tambah Kategori')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Kategori Baru</h1>
            <p class="page-description">Buat kategori baru untuk mengelompokkan buku</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Kategori</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Masukkan nama kategori"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Pilih Status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save me-1"></i> Simpan Kategori
                                    </button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-times me-1"></i> Batal
                                    </a>
                                </div>
                            </div>
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
                    <div class="alert alert-info">
                        <h6><i class="fa fa-info-circle me-1"></i> Tips:</h6>
                        <ul class="mb-0">
                            <li>Nama kategori akan otomatis dibuat slug untuk URL</li>
                            <li>Kategori aktif akan tampil dalam daftar kategori yang dapat dipilih</li>
                            <li>Kategori tidak aktif tidak akan muncul dalam opsi pemilihan</li>
                            <li>Deskripsi membantu menjelaskan kategori kepada pengguna</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Preview</h3>
                </div>
                <div class="card-body">
                    <div class="preview-container">
                        <div class="category-preview">
                            <h5 id="preview-name" class="text-muted">Nama Kategori</h5>
                            <p id="preview-description" class="text-muted">Deskripsi akan muncul di sini...</p>
                            <span id="preview-status" class="badge bg-secondary">Status</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const statusSelect = document.getElementById('status');
    
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewStatus = document.getElementById('preview-status');
    
    function updatePreview() {
        // Update name
        if (nameInput.value.trim()) {
            previewName.textContent = nameInput.value;
            previewName.classList.remove('text-muted');
        } else {
            previewName.textContent = 'Nama Kategori';
            previewName.classList.add('text-muted');
        }
        
        // Update description
        if (descriptionInput.value.trim()) {
            previewDescription.textContent = descriptionInput.value;
            previewDescription.classList.remove('text-muted');
        } else {
            previewDescription.textContent = 'Deskripsi akan muncul di sini...';
            previewDescription.classList.add('text-muted');
        }
        
        // Update status
        const statusValue = statusSelect.value;
        if (statusValue === 'active') {
            previewStatus.textContent = 'Aktif';
            previewStatus.className = 'badge bg-success';
        } else if (statusValue === 'inactive') {
            previewStatus.textContent = 'Tidak Aktif';
            previewStatus.className = 'badge bg-danger';
        } else {
            previewStatus.textContent = 'Status';
            previewStatus.className = 'badge bg-secondary';
        }
    }
    
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    statusSelect.addEventListener('change', updatePreview);
});
</script>
@endpush
