@extends('backend.app')

@section('title', 'Edit Kategori')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Kategori</h1>
            <p class="page-description">Ubah informasi kategori</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Kategori</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Kategori</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $category->name) }}" 
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
                                              placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description', $category->description) }}</textarea>
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
                                        <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
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
                                        <i class="fa fa-save me-1"></i> Update Kategori
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
                    <h3 class="card-title">Informasi Kategori</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h6>Slug:</h6>
                            <p class="text-muted">{{ $category->slug }}</p>
                        </div>
                        <div class="col-12">
                            <h6>Jumlah Buku:</h6>
                            <p class="text-muted">{{ $category->books_count }} buku</p>
                        </div>
                        <div class="col-12">
                            <h6>Dibuat:</h6>
                            <p class="text-muted">{{ $category->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-12">
                            <h6>Terakhir Diupdate:</h6>
                            <p class="text-muted">{{ $category->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
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
            
            @if($category->books_count > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Peringatan Buang</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h6><i class="fa fa-exclamation-triangle me-1"></i> Perhatian:</h6>
                        <p class="mb-0">Kategori ini memiliki {{ $category->books_count }} buku. Kategori tidak dapat dihapus jika masih memiliki buku.</p>
                    </div>
                </div>
            </div>
            @endif
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
    
    // Initial preview update
    updatePreview();
});
</script>
@endpush
