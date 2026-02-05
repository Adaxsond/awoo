@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daftar Buku</h2>
        @if(Auth::user()->role == 0)
        <a href="{{ route('tambahbuku') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Tambah Buku
        </a>
        @endif
    </div>

    <!-- Search and Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari judul / penerbit..." value="{{ request('keyword') }}">
                </div>
                <div class="col-md-2">
                    <select name="kategori_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="bidang_kajian_id" class="form-select">
                        <option value="">Semua Bidang Kajian</option>
                        @foreach ($bidangkajian as $b)
                            <option value="{{ $b->id }}" {{ request('bidang_kajian_id') == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-success w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row g-4">
        @forelse ($buku as $b)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 book-card shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#detailBuku{{ $b->id }}" style="cursor: pointer;">
                <div class="book-image-container position-relative">
                    @if($b->gambar)
                        <img src="{{ asset('storage/'.$b->gambar) }}"
                             class="card-img-top book-image"
                             alt="{{ $b->judul }}"
                             style="object-fit: cover; height: 220px;">
                    @else
                        <div class="no-image-placeholder d-flex align-items-center justify-content-center" style="height: 220px; background-color: #f8f9fa;">
                            <i class="fas fa-book fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="badge position-absolute top-0 start-0 m-2 bg-primary bg-opacity-75">
                        {{ $b->kode_rak }}
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title" title="{{ $b->judul }}">{{ $b->judul }}</h5>
                    <p class="text-muted small mb-1">{{ Str::limit($b->penerbit, 20) }}</p>
                    <div class="d-flex flex-column mt-auto">
                        <span class="badge bg-success bg-opacity-10 text-success mb-1">
                            <i class="fas fa-tags me-1"></i>{{ $b->kategori->nama }}
                        </span>
                        <span class="badge bg-info bg-opacity-10 text-info">
                            <i class="fas fa-graduation-cap me-1"></i>{{ $b->bidangkajian->nama }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-cubes me-1"></i> Stok: {{ $b->stok }}
                        </small>
                        <div class="actions" onclick="event.stopPropagation();">
                            @if(Auth::user()->role == 1)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalPinjam{{ $b->id }}">
                                <i class="fas fa-book"></i>
                            </button>
                            @endif

                            @if(Auth::user()->role == 0)
                            <form action="{{ route('hapusbuku', $b->id) }}" method="POST" style="display:inline-block;" onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="event.stopPropagation();">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada buku ditemukan</h5>
                <p class="text-muted">Silakan coba dengan kata kunci atau filter yang berbeda</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $buku->links() }}
    </div>
</div>

<!-- Modal Detail Buku -->
@foreach ($buku as $b)
<div class="modal fade" id="detailBuku{{ $b->id }}" tabindex="-1" aria-labelledby="detailBukuLabel{{ $b->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailBukuLabel{{ $b->id }}">Detail Buku: {{ $b->judul }}</h5>
                <div class="d-flex">
                    @if(Auth::user()->role == 0)
                    <a href="{{ route('editbuku', $b->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($b->gambar)
                            <img src="{{ asset('storage/'.$b->gambar) }}" class="img-fluid rounded" alt="{{ $b->judul }}">
                        @else
                            <div class="no-image-placeholder bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-book fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Judul</th>
                                <td>{{ $b->judul }}</td>
                            </tr>
                            <tr>
                                <th>Penulis</th>
                                <td>{{ $b->penulis }}</td>
                            </tr>
                            <tr>
                                <th>Penerbit</th>
                                <td>{{ $b->penerbit }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Terbit</th>
                                <td>{{ $b->tahun_terbit }}</td>
                            </tr>
                            <tr>
                                <th>Kode Rak</th>
                                <td>{{ $b->kode_rak }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $b->kategori->nama }}</td>
                            </tr>
                            <tr>
                                <th>Bidang Kajian</th>
                                <td>{{ $b->bidangkajian->nama }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>{{ $b->stok }}</td>
                            </tr>
                            <tr>
                                <th>ISBN</th>
                                <td>{{ $b->isbn ?? '-' }}</td>
                            </tr>
                            @if($b->deskripsi)
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $b->deskripsi }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @if(Auth::user()->role == 1)
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPinjam{{ $b->id }}" data-bs-dismiss="modal">
                    <i class="fas fa-book me-1"></i>Pinjam Buku
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Pinjam -->
@foreach ($buku as $b)
@if(Auth::user()->role == 1)
<div class="modal fade" id="modalPinjam{{ $b->id }}" tabindex="-1" aria-labelledby="modalPinjamLabel{{ $b->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('pinjam.buku') }}" >
            @csrf
            <input type="hidden" name="buku_id" value="{{ $b->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPinjamLabel{{ $b->id }}">Pinjam Buku: {{ $b->judul }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah yang ingin dipinjam</label>
                        <input type="number" class="form-control" name="jumlah" min="1" max="{{ $b->stok }}" required>
                        <small class="text-muted">Stok tersedia: {{ $b->stok }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ajukan Pinjam</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endforeach

<style>
    .book-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .book-image {
        transition: transform 0.3s ease;
    }

    .book-card:hover .book-image {
        transform: scale(1.05);
    }

    .book-image-container {
        overflow: hidden;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .card-title {
        min-height: 44px;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }

    .book-details {
        margin-top: auto;
    }

    .book-category-field {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .no-image-placeholder {
        border: 2px dashed #dee2e6;
        color: #6c757d;
    }

    .badge {
        font-size: 0.8em;
        white-space: normal;
        word-wrap: break-word;
        max-width: 100%;
    }

    .badge-category, .badge-field-of-study {
        white-space: normal;
        word-wrap: break-word;
        display: inline-block;
        max-width: 100%;
    }

    .actions .btn {
        padding: 0.375rem 0.5rem;
        margin-right: 0.25rem;
    }

    .modal-body .table th {
        color: #495057;
        font-weight: 600;
    }
</style>
@endsection
