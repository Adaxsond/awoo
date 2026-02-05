@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-user-circle me-2 text-success"></i>Profil Saya</h2>
    </div>

    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-xl-4">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-body text-center py-5">
                    <div class="avatar-container d-flex flex-column align-items-center">
                        <div class="profile-circle position-relative mb-4">
                            <div class="avatar bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg"
                                 style="width: 150px; height: 150px; background: linear-gradient(135deg, #10b981, #059669);">
                                <span class="fs-1 fw-bold">
                                    {{ strtoupper(substr($anggota->nama ?? 'U', 0, 1)) }}
                                </span>
                            </div>
                            <div class="online-status position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-3 border-white">
                                <i class="fas fa-circle text-white" style="font-size: 8px;"></i>
                            </div>
                        </div>

                        <h4 class="mb-1 fw-bold">{{ $anggota->nama }}</h4>
                        <p class="text-muted mb-2">{{ $anggota->email }}</p>

                        <div class="profile-stats d-flex justify-content-center gap-4 mb-4">
                            <div class="text-center">
                                <h6 class="mb-0 fw-bold text-success">{{ $anggota->peminjaman->count() }}</h6>
                                <small class="text-muted">Pinjaman</small>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0 fw-bold text-success">{{ $anggota->peminjaman->where('status', 'dikembalikan')->count() }}</h6>
                                <small class="text-muted">Selesai</small>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0 fw-bold text-warning">{{ $anggota->peminjaman->where('status', 'dipinjam')->count() }}</h6>
                                <small class="text-muted">Aktif</small>
                            </div>
                        </div>

                        <span class="badge bg-gradient text-white px-4 py-2 mb-3"
                              style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                            <i class="fas fa-graduation-cap me-1"></i>{{ $anggota->kelas }} {{ $anggota->jurusan }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg border-0">
                <div class="card-body py-4">
                    <h5 class="card-title mb-4 text-center"><i class="fas fa-cogs me-2 text-success"></i>Aksi Profil</h5>
                    <div class="d-grid gap-3">
                        <a href="{{ route('editanggota', $anggota->id) }}" class="btn btn-gradient text-white"
                           style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
                            <i class="fas fa-edit me-2"></i> Edit Profil
                        </a>
                        <a href="{{ route('user.peminjaman') }}" class="btn btn-gradient text-white"
                           style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); border: none;">
                            <i class="fas fa-book me-2"></i> Lihat Peminjaman
                        </a>
                        <a href="{{ route('peminjaman-saya') }}" class="btn btn-outline-success">
                            <i class="fas fa-history me-2"></i>Riwayat Pinjaman
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="col-xl-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white py-4"
                     style="background: linear-gradient(135deg, #10b981, #059669); border: none;">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detail Informasi</h5>
                </div>
                <div class="card-body py-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-card p-3 rounded-3 border">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-user text-success fa-lg"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted small mb-1">Nama Lengkap</label>
                                        <p class="mb-0 fw-semibold fs-6">{{ $anggota->nama }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card p-3 rounded-3 border">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-id-card text-primary fa-lg"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted small mb-1">NISN</label>
                                        <p class="mb-0 fw-semibold fs-6">{{ $anggota->nisn }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card p-3 rounded-3 border">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-graduation-cap text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted small mb-1">Kelas</label>
                                        <p class="mb-0 fw-semibold fs-6">{{ $anggota->kelas }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card p-3 rounded-3 border">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-school text-warning fa-lg"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted small mb-1">Jurusan</label>
                                        <p class="mb-0 fw-semibold fs-6">{{ $anggota->jurusan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card p-3 rounded-3 border">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-secondary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-envelope text-secondary fa-lg"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted small mb-1">Email</label>
                                        <p class="mb-0 fw-semibold fs-6">{{ $anggota->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card p-3 rounded-3 border">
                                <div class="d-flex align-items-center">
                                    <div class="icon-container bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-phone text-success fa-lg"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted small mb-1">No HP</label>
                                        <p class="mb-0 fw-semibold fs-6">{{ $anggota->nohp }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mt-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-gradient text-white shadow-lg border-0"
                         style="background: linear-gradient(135deg, #10b981, #059669);">
                        <div class="card-body text-center py-4">
                            <div class="icon-circle bg-white bg-opacity-20 rounded-circle p-3 mx-auto mb-3">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                            <h3 class="mb-1">{{ $anggota->peminjaman->count() }}</h3>
                            <p class="mb-0 text-white-75">Total Pinjaman</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-gradient text-white shadow-lg border-0"
                         style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                        <div class="card-body text-center py-4">
                            <div class="icon-circle bg-white bg-opacity-20 rounded-circle p-3 mx-auto mb-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h3 class="mb-1">{{ $anggota->peminjaman->where('status', 'dikembalikan')->count() }}</h3>
                            <p class="mb-0 text-white-75">Sudah Kembali</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card bg-gradient text-white shadow-lg border-0"
                         style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <div class="card-body text-center py-4">
                            <div class="icon-circle bg-white bg-opacity-20 rounded-circle p-3 mx-auto mb-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <h3 class="mb-1">{{ $anggota->peminjaman->where('status', 'dipinjam')->count() }}</h3>
                            <p class="mb-0 text-white-75">Dipinjam</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .btn-gradient {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(16, 185, 129, 0.3);
    }

    .profile-circle {
        position: relative;
        margin: 0 auto;
    }

    .online-status {
        bottom: 15px !important;
        right: 10px !important;
    }

    .avatar {
        transition: all 0.3s ease;
    }

    .avatar:hover {
        transform: scale(1.05);
    }

    .info-card {
        transition: all 0.3s ease;
        border-left: 4px solid #10b981;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
        border-left-color: #059669;
    }

    .icon-container {
        transition: all 0.3s ease;
    }

    .info-card:hover .icon-container {
        transform: scale(1.1);
    }

    .profile-stats {
        background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        border-radius: 50px;
        padding: 10px 20px;
        margin: 0 auto 20px auto;
        width: fit-content;
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .shadow-lg {
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }

    .rounded-3 {
        border-radius: 12px !important;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-outline-success {
        border-color: #10b981;
        color: #10b981;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background-color: #10b981;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(16, 185, 129, 0.3);
    }
</style>
@endsection
