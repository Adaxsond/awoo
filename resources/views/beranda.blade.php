@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container-fluid px-4">
    <div class="row g-4">

        <!-- Stats Cards - Only for Admin -->
        @if(Auth::user()->role == 0)
        <div class="col-12">
            <div class="row g-4">
                <div class="col-sm-6 col-md-3">
                    <div class="stat-card bg-primary text-white p-4 rounded-4 shadow-sm text-center h-100 d-flex flex-column">
                        <div class="icon mb-3 mx-auto">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $jumlahBuku ?? \App\Models\Buku::count() }}</h3>
                        <p class="mb-0 text-white-75">Total Buku</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-card bg-success text-white p-4 rounded-4 shadow-sm text-center h-100 d-flex flex-column">
                        <div class="icon mb-3 mx-auto">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $jumlahAnggota ?? \App\Models\User::where('role', 1)->count() }}</h3>
                        <p class="mb-0 text-white-75">Jumlah Anggota</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-card bg-info text-white p-4 rounded-4 shadow-sm text-center h-100 d-flex flex-column">
                        <div class="icon mb-3 mx-auto">
                            <i class="fas fa-book-reader fa-2x"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $jumlahPeminjaman ?? \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</h3>
                        <p class="mb-0 text-white-75">Buku Dipinjam</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-card bg-warning text-white p-4 rounded-4 shadow-sm text-center h-100 d-flex flex-column">
                        <div class="icon mb-3 mx-auto">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ $jumlahSelesai ?? \App\Models\Peminjaman::where('status', 'selesai')->count() }}</h3>
                        <p class="mb-0 text-white-75">Peminjaman Selesai</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Popular Books -->
        <div class="col-12">
            <div class="books-card p-4 rounded-4 bg-white shadow-sm">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                    <h3 class="fw-bold text-success border-bottom pb-2 mb-2 mb-md-0">
                        Buku Terpopuler
                    </h3>
                    <a href="{{ route('indexbuku') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @php
                        $popularBuku = \App\Models\Peminjaman::select('buku_id', \DB::raw('count(*) as total_peminjaman'))
                            ->groupBy('buku_id')
                            ->orderBy('total_peminjaman', 'desc')
                            ->limit(4)
                            ->with(['buku'])
                            ->get()
                            ->pluck('buku');
                        $popularBuku = $popularBuku->filter(function ($buku) {
                            return $buku !== null;
                        })->take(4);
                    @endphp

                    @forelse($popularBuku as $buku)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 book-card shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#detailBuku{{ $buku->id }}" style="cursor: pointer;">
                            <div class="book-image-container position-relative">
                                @if($buku->gambar)
                                    <img src="{{ asset('storage/'.$buku->gambar) }}"
                                         class="card-img-top book-image"
                                         alt="{{ $buku->judul }}"
                                         style="object-fit: cover; height: 220px;">
                                @else
                                    <div class="no-image-placeholder d-flex align-items-center justify-content-center" style="height: 220px; background-color: #f8f9fa;">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="badge position-absolute top-0 start-0 m-2 bg-primary bg-opacity-75">
                                    Populer
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" title="{{ $buku->judul }}">{{ $buku->judul }}</h5>
                                <p class="text-muted small mb-1">{{ Str::limit($buku->penerbit, 20) }}</p>
                                <div class="d-flex flex-column mt-auto">
                                    <span class="badge bg-success bg-opacity-10 text-success mb-1">
                                        <i class="fas fa-tags me-1"></i>{{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <i class="fas fa-graduation-cap me-1"></i>{{ $buku->bidangkajian->nama ?? 'Umum' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-cubes me-1"></i> Stok: {{ $buku->stok }}
                                    </small>
                                    <div class="actions" onclick="event.stopPropagation();">
                                        @if(Auth::user()->role == 1)
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalPinjamPopular{{ $buku->id }}" onclick="event.stopPropagation();">
                                            <i class="fas fa-book"></i>
                                        </button>
                                        @endif

                                        @if(Auth::user()->role == 0)
                                        <form action="{{ route('hapusbuku', $buku->id) }}" method="POST" style="display:inline-block;" onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus buku ini?');">
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
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data buku terpopuler</p>
                        <a href="{{ route('indexbuku') }}" class="btn btn-outline-success rounded-pill px-4">Jelajahi Buku</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Books -->
        <div class="col-12">
            <div class="books-card p-4 rounded-4 bg-white shadow-sm">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                    <h3 class="fw-bold text-success border-bottom pb-2 mb-2 mb-md-0">
                        Buku Baru Ditambahkan
                    </h3>
                    <a href="{{ route('indexbuku') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-4">
                    @php $bukuTerbaru = \App\Models\Buku::latest()->limit(4)->get(); @endphp
                    @forelse($bukuTerbaru as $buku)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 book-card shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#detailBukuNew{{ $buku->id }}" style="cursor: pointer;">
                            <div class="book-image-container position-relative">
                                @if($buku->gambar)
                                    <img src="{{ asset('storage/'.$buku->gambar) }}"
                                         class="card-img-top book-image"
                                         alt="{{ $buku->judul }}"
                                         style="object-fit: cover; height: 220px;">
                                @else
                                    <div class="no-image-placeholder d-flex align-items-center justify-content-center" style="height: 220px; background-color: #f8f9fa;">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="badge position-absolute top-0 start-0 m-2 bg-primary bg-opacity-75">
                                    Baru
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" title="{{ $buku->judul }}">{{ $buku->judul }}</h5>
                                <p class="text-muted small mb-1">{{ Str::limit($buku->penerbit, 20) }}</p>
                                <div class="d-flex flex-column mt-auto">
                                    <span class="badge bg-success bg-opacity-10 text-success mb-1">
                                        <i class="fas fa-tags me-1"></i>{{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        <i class="fas fa-graduation-cap me-1"></i>{{ $buku->bidangkajian->nama ?? 'Umum' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-cubes me-1"></i> Stok: {{ $buku->stok }}
                                    </small>
                                    <div class="actions" onclick="event.stopPropagation();">
                                        @if(Auth::user()->role == 1)
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalPinjamNew{{ $buku->id }}" onclick="event.stopPropagation();">
                                            <i class="fas fa-book"></i>
                                        </button>
                                        @endif

                                        @if(Auth::user()->role == 0)
                                        <form action="{{ route('hapusbuku', $buku->id) }}" method="POST" style="display:inline-block;" onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus buku ini?');">
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
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada buku yang tersedia</p>
                        <a href="{{ route('indexbuku') }}" class="btn btn-outline-success rounded-pill px-4">Jelajahi Buku</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Activity - Only for Admin -->
        @if(Auth::user()->role == 0)
        <div class="col-12">
            <div class="activity-card p-4 rounded-4 bg-white shadow-sm">
                <h3 class="mb-4 fw-bold text-success border-bottom pb-2">
                    <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                </h3>
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <h5 class="text-muted mb-3">
                            <i class="fas fa-book-reader text-primary me-2"></i>Peminjaman Terbaru
                        </h5>
                        <div class="activity-list">
                            @php $peminjamanTerbaru = \App\Models\Peminjaman::with(['user', 'buku'])->latest()->limit(5)->get(); @endphp
                            @forelse($peminjamanTerbaru as $peminjaman)
                            <div class="activity-item d-flex align-items-start p-3 border rounded-3 mb-2">
                                <div class="activity-icon me-3 flex-shrink-0">
                                    <i class="fas fa-book text-success"></i>
                                </div>
                                <div class="activity-content flex-grow-1">
                                    <p class="mb-1 fw-semibold">{{ $peminjaman->buku->judul ?? 'Buku' }}</p>
                                    <small class="text-muted d-block">{{ $peminjaman->user->nama ?? 'User' }}</small>
                                    <small class="text-muted">{{ $peminjaman->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-3">
                                <i class="fas fa-inbox text-muted fa-2x mb-2"></i>
                                <p class="text-muted">Tidak ada aktivitas peminjaman baru</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <h5 class="text-muted mb-3">
                            <i class="fas fa-user-plus text-info me-2"></i>Anggota Terbaru
                        </h5>
                        <div class="activity-list">
                            @php $anggotaTerbaru = \App\Models\User::where('role', 1)->latest()->limit(5)->get(); @endphp
                            @forelse($anggotaTerbaru as $anggota)
                            <div class="activity-item d-flex align-items-start p-3 border rounded-3 mb-2">
                                <div class="activity-icon me-3 flex-shrink-0">
                                    <i class="fas fa-user text-info"></i>
                                </div>
                                <div class="activity-content flex-grow-1">
                                    <p class="mb-1 fw-semibold">{{ $anggota->nama ?? 'Anggota' }}</p>
                                    <small class="text-muted d-block">{{ $anggota->email ?? 'Email' }}</small>
                                    <small class="text-muted">{{ $anggota->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-3">
                                <i class="fas fa-inbox text-muted fa-2x mb-2"></i>
                                <p class="text-muted">Tidak ada anggota baru</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Detail Buku for Popular Books -->
@foreach($popularBuku as $buku)
<div class="modal fade" id="detailBuku{{ $buku->id }}" tabindex="-1" aria-labelledby="detailBukuLabel{{ $buku->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailBukuLabel{{ $buku->id }}">Detail Buku: {{ $buku->judul }}</h5>
                <div class="d-flex">
                    @if(Auth::user()->role == 0)
                    <a href="{{ route('editbuku', $buku->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($buku->gambar)
                            <img src="{{ asset('storage/'.$buku->gambar) }}" class="img-fluid rounded" alt="{{ $buku->judul }}">
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
                                <td>{{ $buku->judul }}</td>
                            </tr>
                            <tr>
                                <th>Penulis</th>
                                <td>{{ $buku->penulis }}</td>
                            </tr>
                            <tr>
                                <th>Penerbit</th>
                                <td>{{ $buku->penerbit }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Terbit</th>
                                <td>{{ $buku->tahun_terbit }}</td>
                            </tr>
                            <tr>
                                <th>Kode Rak</th>
                                <td>{{ $buku->kode_rak }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $buku->kategori->nama_kategori ?? 'Umum' }}</td>
                            </tr>
                            <tr>
                                <th>Bidang Kajian</th>
                                <td>{{ $buku->bidangkajian->nama ?? 'Umum' }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>{{ $buku->stok }}</td>
                            </tr>
                            <tr>
                                <th>ISBN</th>
                                <td>{{ $buku->isbn ?? '-' }}</td>
                            </tr>
                            @if($buku->deskripsi)
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $buku->deskripsi }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @if(Auth::user()->role == 1)
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPinjamPopular{{ $buku->id }}" data-bs-dismiss="modal">
                    <i class="fas fa-book me-1"></i>Pinjam Buku
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Detail Buku for New Books -->
@foreach($bukuTerbaru as $buku)
<div class="modal fade" id="detailBukuNew{{ $buku->id }}" tabindex="-1" aria-labelledby="detailBukuNewLabel{{ $buku->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailBukuNewLabel{{ $buku->id }}">Detail Buku: {{ $buku->judul }}</h5>
                <div class="d-flex">
                    @if(Auth::user()->role == 0)
                    <a href="{{ route('editbuku', $buku->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($buku->gambar)
                            <img src="{{ asset('storage/'.$buku->gambar) }}" class="img-fluid rounded" alt="{{ $buku->judul }}">
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
                                <td>{{ $buku->judul }}</td>
                            </tr>
                            <tr>
                                <th>Penulis</th>
                                <td>{{ $buku->penulis }}</td>
                            </tr>
                            <tr>
                                <th>Penerbit</th>
                                <td>{{ $buku->penerbit }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Terbit</th>
                                <td>{{ $buku->tahun_terbit }}</td>
                            </tr>
                            <tr>
                                <th>Kode Rak</th>
                                <td>{{ $buku->kode_rak }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $buku->kategori->nama_kategori ?? 'Umum' }}</td>
                            </tr>
                            <tr>
                                <th>Bidang Kajian</th>
                                <td>{{ $buku->bidangkajian->nama ?? 'Umum' }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>{{ $buku->stok }}</td>
                            </tr>
                            <tr>
                                <th>ISBN</th>
                                <td>{{ $buku->isbn ?? '-' }}</td>
                            </tr>
                            @if($buku->deskripsi)
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $buku->deskripsi }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @if(Auth::user()->role == 1)
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPinjamNew{{ $buku->id }}" data-bs-dismiss="modal">
                    <i class="fas fa-book me-1"></i>Pinjam Buku
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Pinjam for Popular Books -->
@foreach($popularBuku as $buku)
@if(Auth::user()->role == 1)
<div class="modal fade" id="modalPinjamPopular{{ $buku->id }}" tabindex="-1" aria-labelledby="modalPinjamLabelPopular{{ $buku->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('pinjam.buku') }}" >
            @csrf
            <input type="hidden" name="buku_id" value="{{ $buku->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPinjamLabelPopular{{ $buku->id }}">Pinjam Buku: {{ $buku->judul }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah yang ingin dipinjam</label>
                        <input type="number" class="form-control" name="jumlah" min="1" max="{{ $buku->stok }}" required>
                        <small class="text-muted">Stok tersedia: {{ $buku->stok }}</small>
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

<!-- Modal Pinjam for New Books -->
@foreach($bukuTerbaru as $buku)
@if(Auth::user()->role == 1)
<div class="modal fade" id="modalPinjamNew{{ $buku->id }}" tabindex="-1" aria-labelledby="modalPinjamLabelNew{{ $buku->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('pinjam.buku') }}" >
            @csrf
            <input type="hidden" name="buku_id" value="{{ $buku->id }}">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPinjamLabelNew{{ $buku->id }}">Pinjam Buku: {{ $buku->judul }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah yang ingin dipinjam</label>
                        <input type="number" class="form-control" name="jumlah" min="1" max="{{ $buku->stok }}" required>
                        <small class="text-muted">Stok tersedia: {{ $buku->stok }}</small>
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
    .welcome-card {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .welcome-icon {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .wave-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='0.1' d='M0,160L48,138.7C96,117,192,75,288,69.3C384,64,480,96,576,128C672,160,768,192,864,181.3C960,171,1056,117,1152,117.3C1248,117,1344,171,1392,197.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
        background-size: cover;
        background-position: center bottom;
        opacity: 0.3;
    }

    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .action-box {
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
        height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .action-box:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        border-color: #10b981 !important;
    }

    .hover-lift {
        transition: transform 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
    }

    .book-item {
        transition: all 0.3s ease;
        height: 100%;
    }

    .book-item:hover {
        border-color: #10b981 !important;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }

    .quote-section {
        max-width: 600px;
        margin: 0 auto;
    }

    .quick-actions-card, .books-card, .activity-card {
        border: 1px solid #e9ecef;
    }

    .bg-gradient {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .z-2 {
        z-index: 2;
    }

    .activity-item {
        transition: transform 0.2s ease;
    }

    .activity-item:hover {
        transform: translateX(5px);
    }

    .activity-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: rgba(16, 185, 129, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .book-badge {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .welcome-card {
            padding: 2rem 1.5rem !important;
        }

        .quote-section {
            padding: 1rem !important;
        }

        .display-5 {
            font-size: 1.8rem !important;
        }

        .d-flex.justify-content-center.gap-3 {
            flex-direction: column;
            gap: 1rem !important;
        }

        .stat-card {
            height: auto !important;
        }

        .book-item {
            height: auto !important;
        }
    }

    /* Card hover effects */
    .quick-actions-card, .books-card, .activity-card {
        transition: transform 0.3s ease;
    }

    .quick-actions-card:hover, .books-card:hover, .activity-card:hover {
        transform: translateY(-2px);
    }

    /* Text truncation - removed to show full titles */
    /* .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    } */

    /* Full book titles with proper wrapping */
    .book-item h5 {
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        line-height: 1.4;
        min-height: 2.8em; /* Accommodate 2 lines */
    }

    .book-item p {
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
        line-height: 1.3;
        min-height: 2.1em; /* Accommodate 2 lines */
    }

    .book-item {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .book-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    /* Button enhancements */
    .btn-outline-success {
        border-width: 2px;
    }

    .btn-outline-success:hover {
        background-color: var(--bs-success);
        color: white;
    }

    /* Modal styling for book details */
    .modal-body .table th {
        color: #495057;
        font-weight: 600;
        width: 30%;
    }

    .no-image-placeholder {
        border: 2px dashed #dee2e6;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Book card styling - from book index page */
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

    /* Clickable book card styling - already handled by inline styles and existing hover effects */
</style>
@endsection

