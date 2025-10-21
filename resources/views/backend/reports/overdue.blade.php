@extends('backend.app')

@section('title', 'Laporan Buku Terlambat')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Buku Terlambat</h1>
            <p class="page-description">Laporan buku yang terlambat dikembalikan</p>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Laporan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buku Terlambat</li>
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
            <form method="GET" action="{{ route('reports.overdue') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Terlambat Lebih Dari (Hari)</label>
                        <select name="overdue_days" class="form-control">
                            <option value="">Semua</option>
                            <option value="1" {{ request('overdue_days') == '1' ? 'selected' : '' }}>1 Hari</option>
                            <option value="7" {{ request('overdue_days') == '7' ? 'selected' : '' }}>1 Minggu</option>
                            <option value="30" {{ request('overdue_days') == '30' ? 'selected' : '' }}>1 Bulan</option>
                            <option value="90" {{ request('overdue_days') == '90' ? 'selected' : '' }}>3 Bulan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('reports.overdue') }}" class="btn btn-secondary">Reset</a>
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
                            <h3 class="mb-2 fw-semibold text-danger">{{ $stats['total_overdue'] }}</h3>
                            <p class="text-muted fs-13 mb-0">Total Terlambat</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-danger text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
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
                            <h3 class="mb-2 fw-semibold text-warning">{{ $stats['overdue_1_week'] }}</h3>
                            <p class="text-muted fs-13 mb-0">Terlambat 1 Minggu</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-warning text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
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
                            <h3 class="mb-2 fw-semibold text-danger">{{ $stats['overdue_1_month'] }}</h3>
                            <p class="text-muted fs-13 mb-0">Terlambat 1 Bulan</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-danger text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
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
                            <h3 class="mb-2 fw-semibold text-dark">{{ $stats['overdue_more_than_month'] }}</h3>
                            <p class="text-muted fs-13 mb-0">Lebih dari 1 Bulan</p>
                        </div>
                        <div class="col col-auto">
                            <div class="counter-icon bg-dark text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
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
            <h3 class="card-title">Data Buku Terlambat</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Terlambat (Hari)</th>
                            <th>No. Telepon</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($overdueBooks as $borrowing)
                        @php
                            $overdueDays = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($borrowing->due_date), false);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration + ($overdueBooks->currentPage() - 1) * $overdueBooks->perPage() }}</td>
                            <td class="text-white">{{ $borrowing->user->name }}</td>
                            <td class="text-white">{{ $borrowing->book->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</td>
                            <td>
                                @if($overdueDays > 30)
                                    <span class="badge bg-danger">{{ abs($overdueDays) }} hari</span>
                                @elseif($overdueDays > 7)
                                    <span class="badge bg-warning">{{ abs($overdueDays) }} hari</span>
                                @else
                                    <span class="badge bg-info">{{ abs($overdueDays) }} hari</span>
                                @endif
                            </td>
                            <td>{{ $borrowing->user->phone ?? '-' }}</td>
                            <td>{{ $borrowing->user->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada buku yang terlambat</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $overdueBooks->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- Actions --}}
    @if($overdueBooks->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Aksi</h3>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary" onclick="sendReminderEmails()">
                    <i class="fa fa-envelope me-1"></i> Kirim Pengingat Email
                </button>
                <button type="button" class="btn btn-success" onclick="printReport()">
                    <i class="fa fa-print me-1"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('scripts')
<script>
function sendReminderEmails() {
    if (confirm('Apakah Anda yakin ingin mengirim email pengingat ke semua anggota yang terlambat?')) {
        // Implement email reminder functionality
        alert('Fitur pengiriman email akan diimplementasikan');
    }
}

function printReport() {
    window.print();
}
</script>
@endpush
