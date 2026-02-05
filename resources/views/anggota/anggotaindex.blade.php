@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daftar Anggota</h2>
    </div>

    <!-- Search and Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau NISN..." value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="kelas" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach ($daftarKelas as $kelas)
                            <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                                Kelas {{ $kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="jurusan" class="form-select">
                        <option value="">Semua Jurusan</option>
                        @foreach ($daftarJurusan as $jurusan)
                            <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>
                                {{ $jurusan }}
                            </option>
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

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center bg-primary bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $anggota->total() }}</h5>
                    <p class="card-text text-muted">Total Anggota</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center bg-info bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-info">{{ collect($anggota->items())->where('kelas', '10')->count() }}</h5>
                    <p class="card-text text-muted">Kelas 10</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center bg-success bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ collect($anggota->items())->where('kelas', '11')->count() }}</h5>
                    <p class="card-text text-muted">Kelas 11</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center bg-warning bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-warning">{{ collect($anggota->items())->where('kelas', '12')->count() }}</h5>
                    <p class="card-text text-muted">Kelas 12</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Anggota Cards Grid -->
    <div class="row g-4">
        @forelse ($anggota as $a)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 anggota-card shadow-sm border-0">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title text-truncate" title="{{ $a->nama }}" style="min-height: 44px;">{{ Str::limit($a->nama, 20) }}</h5>
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            {{ $a->nisn }}
                        </span>
                    </div>

                    <p class="text-muted small mb-1">
                        <i class="fas fa-envelope me-1"></i> {{ $a->email }}
                    </p>

                    <p class="text-muted small mb-2">
                        <i class="fas fa-phone me-1"></i> {{ $a->nohp }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="badge bg-success bg-opacity-10 text-success">
                            <i class="fas fa-graduation-cap me-1"></i>Kelas {{ $a->kelas }}
                        </span>
                        <span class="badge bg-info bg-opacity-10 text-info">
                            <i class="fas fa-code me-1"></i>{{ $a->jurusan }}
                        </span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('anggotaprofil', $a->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-user me-1"></i>Lihat
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada anggota ditemukan</h5>
                <p class="text-muted">Silakan coba dengan filter yang berbeda</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $anggota->appends(request()->query())->links() }}
    </div>
</div>

<style>
    .anggota-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
    }

    .anggota-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .card-title {
        color: #2c3e50;
        font-weight: 600;
        min-height: 44px;
    }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .badge {
        font-size: 0.8em;
    }

    .actions .btn {
        padding: 0.375rem 0.5rem;
        margin-right: 0.25rem;
    }
</style>
@endsection
