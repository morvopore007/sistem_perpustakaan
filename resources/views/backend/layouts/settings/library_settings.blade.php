@extends('backend.app')

@section('title', 'Library Settings')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Library Settings</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library Settings</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-header">
                    <h4 class="card-title">Library Configuration</h4>
                    <p class="card-subtitle">Configure library settings and policies</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('library-settings.update', 1) }}">
                        @csrf
                        @method('PUT')
                        
                        {{-- Library Information Section --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fe fe-info me-2"></i>Library Information
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="library_name" class="form-label">Library Name:</label>
                                    <input type="text" class="form-control @error('library_name') is-invalid @enderror"
                                        name="library_name" placeholder="Library Name" id="library_name"
                                        value="{{ old('library_name', $settings['library_name']->value ?? '') }}">
                                    @error('library_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="library_email" class="form-label">Library Email:</label>
                                    <input type="email" class="form-control @error('library_email') is-invalid @enderror"
                                        name="library_email" placeholder="library@example.com" id="library_email"
                                        value="{{ old('library_email', $settings['library_email']->value ?? '') }}">
                                    @error('library_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="library_phone" class="form-label">Library Phone:</label>
                                    <input type="text" class="form-control @error('library_phone') is-invalid @enderror"
                                        name="library_phone" placeholder="(021) 1234-5678" id="library_phone"
                                        value="{{ old('library_phone', $settings['library_phone']->value ?? '') }}">
                                    @error('library_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="library_address" class="form-label">Library Address:</label>
                                    <textarea class="form-control @error('library_address') is-invalid @enderror"
                                        name="library_address" placeholder="Library Address" id="library_address" rows="3">{{ old('library_address', $settings['library_address']->value ?? '') }}</textarea>
                                    @error('library_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Borrowing Policies Section --}}
                        <div class="row mb-4 mt-5">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fe fe-book me-2"></i>Borrowing Policies
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_borrow_days_student" class="form-label">Max Borrow Days (Student):</label>
                                    <input type="number" class="form-control @error('max_borrow_days_student') is-invalid @enderror"
                                        name="max_borrow_days_student" placeholder="14" id="max_borrow_days_student"
                                        value="{{ old('max_borrow_days_student', $settings['max_borrow_days_student']->value ?? '') }}"
                                        min="1" max="365">
                                    @error('max_borrow_days_student')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Maximum days a student can borrow a book</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_borrow_days_teacher" class="form-label">Max Borrow Days (Teacher):</label>
                                    <input type="number" class="form-control @error('max_borrow_days_teacher') is-invalid @enderror"
                                        name="max_borrow_days_teacher" placeholder="30" id="max_borrow_days_teacher"
                                        value="{{ old('max_borrow_days_teacher', $settings['max_borrow_days_teacher']->value ?? '') }}"
                                        min="1" max="365">
                                    @error('max_borrow_days_teacher')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Maximum days a teacher can borrow a book</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_books_per_student" class="form-label">Max Books Per Student:</label>
                                    <input type="number" class="form-control @error('max_books_per_student') is-invalid @enderror"
                                        name="max_books_per_student" placeholder="3" id="max_books_per_student"
                                        value="{{ old('max_books_per_student', $settings['max_books_per_student']->value ?? '') }}"
                                        min="1" max="20">
                                    @error('max_books_per_student')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Maximum number of books a student can borrow at once</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_books_per_teacher" class="form-label">Max Books Per Teacher:</label>
                                    <input type="number" class="form-control @error('max_books_per_teacher') is-invalid @enderror"
                                        name="max_books_per_teacher" placeholder="5" id="max_books_per_teacher"
                                        value="{{ old('max_books_per_teacher', $settings['max_books_per_teacher']->value ?? '') }}"
                                        min="1" max="20">
                                    @error('max_books_per_teacher')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Maximum number of books a teacher can borrow at once</small>
                                </div>
                            </div>
                        </div>

                        {{-- Reservation Settings Section --}}
                        <div class="row mb-4 mt-5">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fe fe-calendar me-2"></i>Reservation Settings
                                </h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reservation_expiry_days" class="form-label">Reservation Expiry Days:</label>
                                    <input type="number" class="form-control @error('reservation_expiry_days') is-invalid @enderror"
                                        name="reservation_expiry_days" placeholder="7" id="reservation_expiry_days"
                                        value="{{ old('reservation_expiry_days', $settings['reservation_expiry_days']->value ?? '') }}"
                                        min="1" max="30">
                                    @error('reservation_expiry_days')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Number of days before a reservation expires</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button class="btn btn-primary" type="submit">
                                <i class="fe fe-save me-2"></i>Update Settings
                            </button>
                            <a href="{{ route('library-settings.index') }}" class="btn btn-secondary ms-2">
                                <i class="fe fe-refresh-cw me-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
