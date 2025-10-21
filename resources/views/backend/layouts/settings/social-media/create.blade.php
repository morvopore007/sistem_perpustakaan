@extends('backend.app')

@section('title', 'Social Media Create')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Social Media Form</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Table</a></li>
                <li class="breadcrumb-item active" aria-current="page">Social Media </li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER END --}}


    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form method="post" action="{{ route('social.store') }}" >
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name" class="form-label">Social Media Name:</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" placeholder="Social Media Name" id="name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="icon" class="form-label">Social Media Icon:</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                name="icon" placeholder="Social Media Icon" id="icon" value="{{ old('icon') }}">
                            @error('icon')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="back_color" class="form-label">Social Media Background Color:</label>
                            <input type="text" class="form-control @error('back_color') is-invalid @enderror"
                                name="back_color" placeholder="Social Media Background Color" id="back_color" value="{{ old('back_color') }}">
                            @error('back_color')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="link" class="form-label">Social Media Link:</label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror"
                                name="link" placeholder="Social Media Link" id="link" value="{{ old('link') }}">
                            @error('link')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{ route('social.index') }}" class="btn btn-danger me-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
