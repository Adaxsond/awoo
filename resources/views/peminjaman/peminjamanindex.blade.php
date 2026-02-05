@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daftar Peminjaman</h2>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <select name="status" id="status" onchange="this.form.submit()" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="hilang" {{ request('status') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                        <option value="telat" {{ request('status') == 'telat' ? 'selected' : '' }}>Telat</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari buku..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-success w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center bg-primary bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $peminjaman->total() }}</h5>
                    <p class="card-text text-muted">Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-info bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-info">{{ $peminjaman->where('status', 'dipinjam')->count() }}</h5>
                    <p class="card-text text-muted">Dipinjam</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-success bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ $peminjaman->where('status', 'dikembalikan')->count() }}</h5>
                    <p class="card-text text-muted">Dikembalikan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-danger bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-danger">{{ $peminjaman->filter(function($p) { return $p->status == 'dipinjam' && \Carbon\Carbon::parse($p->tanggal_jatuh_tempo)->isPast(); })->count() }}</h5>
                    <p class="card-text text-muted">Telat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Cards Grid -->
    <div class="row g-4">
        @forelse ($peminjaman as $pinjam)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 peminjaman-card shadow-sm border-0">
                <div class="book-image-container position-relative">
                    @if($pinjam->buku->gambar)
                        <img src="{{ Storage::url($pinjam->buku->gambar) }}"
                             alt="{{ $pinjam->buku->judul }}"
                             class="img-fluid w-100 book-image"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="no-image-placeholder d-flex align-items-center justify-content-center"
                             style="height: 200px;">
                            <div class="text-center">
                                <i class="fas fa-book fa-3x text-muted"></i>
                                <p class="text-muted mt-2 mb-0">No Image</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title mb-2" title="{{ $pinjam->buku->judul }}" style="min-height: 44px; white-space: normal; line-height: 1.4;">{{ $pinjam->buku->judul }}</h6>
                    <div class="mb-2 status-badge-container">
                        <span class="badge bg-{{
                            $pinjam->status == 'dipinjam' ? 'primary' :
                            ($pinjam->status == 'dikembalikan' ? 'success' :
                            ($pinjam->status == 'rusak' ? 'warning' :
                            ($pinjam->status == 'hilang' ? 'danger' : 'secondary')))
                        }} rounded-pill px-3 py-2">
                            {{ ucfirst($pinjam->status) }}
                        </span>
                    </div>

                    <p class="text-muted small mb-2">
                        <i class="fas fa-user me-1"></i> {{ $pinjam->user->nama }}
                    </p>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-cubes me-1"></i> Jumlah: {{ $pinjam->jumlah }}
                            </small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="badge bg-success bg-opacity-10 text-success">
                            <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M') }}
                        </span>
                        <span class="badge bg-info bg-opacity-10 text-info">
                            <i class="fas fa-calendar-day me-1"></i>{{ $pinjam->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('d M') : '-' }}
                        </span>
                    </div>

                    <div class="mt-2">
                        @if($pinjam->status == 'dipinjam' && \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->isPast())
                            <span class="badge bg-danger">
                                <i class="fas fa-exclamation-triangle me-1"></i> Telat
                            </span>
                        @endif
                    </div>

                    <div class="mt-2">
                        <small class="text-muted d-block">
                            <i class="fas fa-dollar-sign me-1"></i>Denda:
                            <strong class="text-danger">Rp{{ number_format($pinjam->denda + $pinjam->denda_kondisi, 0, ',', '.') }}</strong>
                        </small>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-transparent border-0 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        @if ($pinjam->status === 'dipinjam')
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#kembaliModal{{ $pinjam->id }}">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#rusakModal{{ $pinjam->id }}">
                                <i class="fas fa-exclamation-triangle"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hilangModal{{ $pinjam->id }}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        @else
                        <div class="text-center w-100">
                            <span class="text-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Selesai
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Kembali -->
        <div class="modal fade" id="kembaliModal{{ $pinjam->id }}" tabindex="-1" aria-labelledby="kembaliModalLabel{{ $pinjam->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('peminjaman.kembali', $pinjam->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="kembaliModalLabel{{ $pinjam->id }}">Konfirmasi Pengembalian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p>Anda akan mengonfirmasi pengembalian buku <strong>{{ $pinjam->buku->judul }}</strong> oleh <strong>{{ $pinjam->user->nama }}</strong>.</p>
                            <div class="mb-3">
                                <label for="jumlah_kembali_{{ $pinjam->id }}" class="form-label">Jumlah yang dikembalikan:</label>
                                <input type="number" name="jumlah" id="jumlah_kembali_{{ $pinjam->id }}" class="form-control" min="1" max="{{ $pinjam->jumlah }}" value="{{ $pinjam->jumlah }}" required>
                                <div class="form-text">Jumlah buku yang dikembalikan</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Konfirmasi Kembali</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Rusak -->
        <div class="modal fade" id="rusakModal{{ $pinjam->id }}" tabindex="-1" aria-labelledby="rusakModalLabel{{ $pinjam->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('peminjaman.rusak', $pinjam->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="rusakModalLabel{{ $pinjam->id }}">Tandai Buku Rusak</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p>Anda akan menandai buku <strong>{{ $pinjam->buku->judul }}</strong> sebagai rusak.</p>
                            <div class="mb-3">
                                <label for="harga_rusak_{{ $pinjam->id }}" class="form-label">Masukkan biaya perbaikan:</label>
                                <input type="number" name="harga_buku" id="harga_rusak_{{ $pinjam->id }}" class="form-control" min="0" required placeholder="Contoh: 25000">
                                <div class="form-text">Biaya perbaikan atau penggantian akan dihitung sebagai denda.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Konfirmasi Rusak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Hilang -->
        <div class="modal fade" id="hilangModal{{ $pinjam->id }}" tabindex="-1" aria-labelledby="hilangModalLabel{{ $pinjam->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('peminjaman.hilang', $pinjam->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="hilangModalLabel{{ $pinjam->id }}">Tandai Buku Hilang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p>Anda akan menandai buku <strong>{{ $pinjam->buku->judul }}</strong> sebagai hilang.</p>
                            <div class="mb-3">
                                <label for="harga_hilang_{{ $pinjam->id }}" class="form-label">Masukkan harga buku pengganti:</label>
                                <input type="number" name="harga_buku" id="harga_hilang_{{ $pinjam->id }}" class="form-control" min="0" required placeholder="Contoh: 50000">
                                <div class="form-text">Harga ini akan dihitung sebagai denda tambahan.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Konfirmasi Hilang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada peminjaman ditemukan</h5>
                <p class="text-muted">Silakan coba dengan filter yang berbeda</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $peminjaman->appends(request()->query())->links() }}
    </div>
</div>


<style>
    .peminjaman-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
    }

    .peminjaman-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .info-item {
        padding: 0.5rem 0;
    }

    .status-stats .badge {
        font-size: 0.8em;
        font-weight: 500;
    }

    .card-title {
        color: #2c3e50;
        font-weight: 600;
        min-height: 44px;
    }

    .card-title {
        font-size: 0.95rem;
    }

    h6.card-title {
        font-size: 0.9rem;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        max-height: calc(1.4em * 2);
    }

    .badge {
        font-size: 0.8em;
        max-width: 100%;
        word-break: break-word;
    }

    .status-badge-container {
        max-width: 100%;
    }

    .actions .btn {
        padding: 0.375rem 0.5rem;
        margin-right: 0.25rem;
    }

    .no-image-placeholder {
        border: 2px dashed #dee2e6;
        color: #6c757d;
    }

    .book-image-container {
        overflow: hidden;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .book-image {
        transition: transform 0.3s ease;
    }

    .peminjaman-card:hover .book-image {
        transform: scale(1.05);
    }

    .card-body {
        padding: 0.75rem;
    }
</style>
@endsection
