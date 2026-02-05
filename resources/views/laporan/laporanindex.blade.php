@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-chart-bar me-2 text-success"></i>Laporan Peminjaman</h2>
        <a href="{{ route('laporan.download', request()->all()) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf me-1"></i> Download PDF
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center bg-primary bg-opacity-10 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $peminjaman->count() }}</h5>
                    <p class="card-text text-muted mb-0">Total Peminjaman</p>
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
                    <h5 class="card-title text-danger">{{ $peminjaman->where('status', 'telat')->count() + $peminjaman->filter(function($p) { return $p->status == 'dipinjam' && \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->isPast(); })->count() }}</h5>
                    <p class="card-text text-muted mb-0">Terlambat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="from" class="form-label">Dari Tanggal</label>
                    <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-3">
                    <label for="to" class="form-label">Sampai Tanggal</label>
                    <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                        <option value="telat" {{ request('status') == 'telat' ? 'selected' : '' }}>Telat</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success me-2 w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light border-bottom">
                        <tr class="align-middle">
                            <th width="50" class="text-center text-sm">No</th>
                            <th class="text-center text-sm">Nama Peminjam</th>
                            <th class="text-center text-sm">Judul Buku</th>
                            <th class="text-center text-sm">Jumlah</th>
                            <th class="text-center text-sm">Tanggal Pinjam</th>
                            <th class="text-center text-sm">Jatuh Tempo</th>
                            <th class="text-center text-sm">Tanggal Kembali</th>
                            <th class="text-center text-sm">Status</th>
                            <th class="text-center text-sm">Denda</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($peminjaman as $index => $pinjam)
                        <tr class="align-middle border-bottom hover-row" style="@if($pinjam->status == 'dipinjam' && \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->isPast()) background-color: #fff5f5; @endif">
                            <td class="text-center text-muted text-sm">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="position-relative">
                                        <div class="user-avatar-sm">
                                            {{ strtoupper(substr($pinjam->user->nama ?? 'U', 0, 1)) }}
                                        </div>
                                        @if($pinjam->status == 'dipinjam' && \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->isPast())
                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                                <span class="visually-hidden">New</span>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="ms-2">
                                        <span class="mb-0 text-sm">{{ $pinjam->user->nama }}</span>
                                        <small class="text-muted d-block"><i class="fas fa-id-card me-1"></i> ID: {{ $pinjam->user->id }}</small>
                                        <small class="text-muted d-block"><i class="fas fa-envelope me-1"></i> {{ $pinjam->user->email }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="book-icon-container">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="ms-2">
                                        <span class="mb-0 text-sm">{{ $pinjam->buku->judul }}</span>
                                        <small class="text-muted d-block"><i class="fas fa-barcode me-1"></i> {{ $pinjam->buku->kode_buku }}</small>
                                        <small class="text-muted d-block"><i class="fas fa-tag me-1"></i> {{ $pinjam->buku->kategori->nama ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="badge bg-info bg-opacity-10 text-info px-2 py-1">
                                        <i class="fas fa-cubes me-1"></i>{{ $pinjam->jumlah }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="d-block text-sm">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('M Y') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="d-block @if(\Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->isPast() && $pinjam->status != 'dikembalikan') text-danger @endif text-sm">
                                        {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('d') }}
                                    </span>
                                    <small class="text-muted {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->isPast() && $pinjam->status != 'dikembalikan' ? 'text-danger' : '' }}">
                                        {{ \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('M Y') }}
                                    </small>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($pinjam->tanggal_kembali)
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="d-block text-sm">{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d') }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('M Y') }}</small>
                                    </div>
                                @else
                                    <span class="text-muted text-sm">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <span class="badge rounded-pill bg-{{
                                        $pinjam->status == 'dipinjam' ? 'primary' :
                                        ($pinjam->status == 'dikembalikan' ? 'success' :
                                        ($pinjam->status == 'rusak' ? 'warning text-dark' :
                                        ($pinjam->status == 'hilang' ? 'danger' : 'secondary')))
                                    }} px-2 py-1">
                                        <i class="fas fa-{{
                                            $pinjam->status == 'dipinjam' ? 'hand-holding' :
                                            ($pinjam->status == 'dikembalikan' ? 'check-circle' :
                                            ($pinjam->status == 'rusak' ? 'exclamation-triangle' :
                                            ($pinjam->status == 'hilang' ? 'times-circle' : 'clock')))
                                        }}"></i>
                                        {{ ucfirst(str_replace('_', ' ', $pinjam->status)) }}
                                    </span>

                                    @if($pinjam->status == 'dipinjam' && \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->isPast())
                                        <span class="badge rounded-pill bg-danger ms-1 px-2 py-1">
                                            <i class="fas fa-clock"></i> Telat
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    @if($pinjam->denda > 0)
                                        <span class="text-danger d-flex align-items-center text-sm">
                                            <i class="fas fa-money-bill-wave me-1"></i>
                                            Rp{{ number_format($pinjam->denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-success text-sm">
                                            <i class="fas fa-check-circle"></i> Gratis
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="empty-state-icon mb-3">
                                        <i class="fas fa-chart-bar fa-2x text-muted"></i>
                                    </div>
                                    <h6 class="text-muted mb-2">Tidak ada laporan ditemukan</h6>
                                    <small class="text-muted mb-3">Silakan gunakan filter untuk mencari data yang diinginkan</small>
                                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-sync-alt me-1"></i> Reset Filter
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .user-avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #059669;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
</style>
@endsection
