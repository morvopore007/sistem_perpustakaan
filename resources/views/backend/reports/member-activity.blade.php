@extends('backend.app')

@section('title', 'Laporan Aktivitas Anggota')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Aktivitas Anggota</h1>
            <p class="page-description">Laporan aktivitas peminjaman anggota perpustakaan</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Aktivitas Anggota</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    {{-- Filter Form --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Filter Laporan</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.member-activity') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Peran</label>
                        <select name="role" class="form-control">
                            <option value="">Semua Peran</option>
                            <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Siswa</option>
                            <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Guru</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('reports.member-activity') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h3 class="mb-2 fw-semibold">{{ $stats['total_members'] }}</h3>
                            <p class="text-muted fs-13 mb-0">Total Anggota</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-primary text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
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
                            <h3 class="mb-2 fw-semibold text-success">{{ $stats['active_members'] }}</h3>
                            <p class="text-muted fs-13 mb-0">Anggota Aktif</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-success text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
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
                            <h3 class="mb-2 fw-semibold text-info">{{ $stats['students'] }}</h3>
                            <p class="text-muted fs-13 mb-0">Siswa</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-info text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
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
                            <h3 class="mb-2 fw-semibold text-warning">{{ $stats['teachers'] }}</h3>
                            <p class="text-muted fs-13 mb-0">Guru</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-warning text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Aktivitas Anggota</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th>Total Peminjaman</th>
                            <th>Total Reservasi</th>
                            <th>Status</th>
                            <th>Terdaftar Sejak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr>
                            <td>{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td>
                            <td class="text-white">{{ $member->name }}</td>
                            <td class="text-white">{{ $member->email }}</td>
                            <td>
                                @switch($member->role)
                                    @case('student')
                                        <span class="badge bg-info">Siswa</span>
                                        @break
                                    @case('teacher')
                                        <span class="badge bg-warning">Guru</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $member->role }}</span>
                                @endswitch
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $member->borrowings_count }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $member->reservations_count }}</span>
                            </td>
                            <td>
                                @if($member->borrowings_count > 0)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($member->created_at)->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data anggota</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $members->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- Top Active Members --}}
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Top 5 Anggota Paling Aktif</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($members->take(5) as $index => $member)
                <div class="col-md-12 mb-3">
                    <div class="d-flex align-items-center p-3 border rounded">
                        <div class="flex-shrink-0">
                            <div class="counter-icon bg-primary text-white me-3">
                                <span class="fw-bold">{{ $index + 1 }}</span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $member->name }}</h5>
                            <p class="text-muted mb-1">{{ $member->email }}</p>
                            <small class="text-muted">
                                @switch($member->role)
                                    @case('student')
                                        Siswa
                                        @break
                                    @case('teacher')
                                        Guru
                                        @break
                                    @default
                                        {{ $member->role }}
                                @endswitch
                            </small>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="text-end">
                                <span class="badge bg-primary fs-6">{{ $member->borrowings_count }} peminjaman</span>
                                <br>
                                <span class="badge bg-success mt-1">{{ $member->reservations_count }} reservasi</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
