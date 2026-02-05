@extends('layouts.app')

@section('title', 'Kelola Bidang Kajian')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Kelola Bidang Kajian</h2>
    </div>

    <!-- Form tambah -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('bidangkajian.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-10">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Bidang Kajian" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-plus me-1"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center bg-primary bg-opacity-10 border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $bidangkajian->count() }}</h5>
                    <p class="card-text text-muted">Total Bidang Kajian</p>
                </div>
            </div>
        </div>
    </div>

    <!-- BidangKajian List -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama Bidang Kajian</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bidangkajian as $index => $bk)
                        <tr>
                            <td class="align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-bookmark text-muted me-2"></i>
                                    <div>
                                        <h6 class="mb-0">{{ $bk->nama }}</h6>
                                        <small class="text-muted">ID: {{ $bk->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('bidangkajian.edit', $bk->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('bidangkajian.destroy', $bk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus bidang kajian ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <i class="fas fa-bookmark fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada bidang kajian ditemukan</h5>
                                    <p class="text-muted">Silakan tambahkan bidang kajian baru</p>
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
@endsection
