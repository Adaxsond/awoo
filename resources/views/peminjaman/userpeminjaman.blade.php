@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-book-user me-2 text-success"></i>Peminjaman Saya</h2>
        <a href="{{ route('indexbuku') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Pinjam Buku Baru
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center bg-primary bg-opacity-10 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $peminjaman->count() }}</h5>
                    <p class="card-text text-muted mb-0">Total Pinjaman</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-success bg-opacity-10 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ $peminjaman->where('status', 'dikembalikan')->count() }}</h5>
                    <p class="card-text text-muted mb-0">Sudah Dikembalikan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-warning bg-opacity-10 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning">{{ $peminjaman->where('status', 'dipinjam')->count() }}</h5>
                    <p class="card-text text-muted mb-0">Masih Dipinjam</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-danger bg-opacity-10 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger">{{ $peminjaman->where('status', 'dipinjam')->filter(function($p) { return optional($p->tanggal_jatuh_tempo) && \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->isPast(); })->count() }}</h5>
                    <p class="card-text text-muted mb-0">Terlambat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="d-flex flex-wrap gap-3 align-items-center">
                <div>
                    <label for="status" class="form-label">Filter Status:</label>
                    <select name="status" id="status" onchange="this.form.submit()" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                    </select>
                </div>

                <a href="{{ route('user.peminjaman') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Peminjaman List -->
    @if($peminjaman->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <div class="empty-state-icon mb-3">
                    <i class="fas fa-book-open fa-3x text-muted"></i>
                </div>
                <h5 class="text-muted">Tidak ada peminjaman</h5>
                <p class="text-muted">Anda belum memiliki peminjaman saat ini</p>
                <a href="{{ route('indexbuku') }}" class="btn btn-success">
                    <i class="fas fa-book me-1"></i> Cari Buku
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach ($peminjaman as $item)
            <div class="col-lg-6 col-md-12">
                <div class="card h-100 shadow-sm border-0 peminjaman-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="card-title mb-2 fw-semibold">
                                    <i class="fas fa-book text-muted me-2"></i>{{ optional($item->buku)->judul ?? 'Buku Tidak Ditemukan' }}
                                </h6>
                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1">
                                    <i class="fas fa-cubes me-1"></i>{{ $item->jumlah }} buku
                                </span>
                            </div>
                            <span class="badge rounded-pill bg-{{ 
                                $item->status == 'dipinjam' ? 'primary' :
                                ($item->status == 'dikembalikan' ? 'success' :
                                ($item->status == 'rusak' ? 'warning text-dark' : 'danger'))
                            }} px-3 py-2">
                                <i class="fas fa-{{
                                    $item->status == 'dipinjam' ? 'hand-holding' :
                                    ($item->status == 'dikembalikan' ? 'check-circle' :
                                    ($item->status == 'rusak' ? 'exclamation-triangle' : 'times-circle'))
                                }} me-1"></i>{{ ucfirst($item->status) }}
                            </span>
                        </div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label text-muted small">Tanggal Pinjam</label>
                                    <p class="mb-1">{{ optional($item->tanggal_pinjam) ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}</p>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label text-muted small">Jatuh Tempo</label>
                                    <p class="@if($item->status == 'dipinjam' && optional($item->tanggal_jatuh_tempo) && \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isPast()) text-danger fw-semibold @endif">
                                        {{ optional($item->tanggal_jatuh_tempo) ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label text-muted small">Tanggal Kembali</label>
                                    <p class="mb-1">{{ optional($item->tanggal_kembali) ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}</p>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label text-muted small">Kode Buku</label>
                                    <p class="mb-1">{{ optional($item->buku)->kode_buku ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($item->status == 'dipinjam' && optional($item->tanggal_jatuh_tempo) && \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->isPast())
                        <div class="alert alert-danger mt-3 mb-0">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Peminjaman ini sudah terlambat dikembalikan. Harap segera kembalikan buku ke perpustakaan.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination if needed -->
        <div class="d-flex justify-content-center mt-4">
            @if(method_exists($peminjaman, 'links'))
                {{ $peminjaman->links() }}
            @endif
        </div>
    @endif
</div>

<style>
    .peminjaman-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .peminjaman-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .empty-state-icon {
        opacity: 0.5;
    }

    .card-title {
        min-height: auto;
    }

    h6.card-title {
        font-size: 1rem;
        line-height: 1.4;
        margin-bottom: 0.5rem !important;
        min-height: auto;
    }
</style>
@endsection
