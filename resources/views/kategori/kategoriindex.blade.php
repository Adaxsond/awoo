@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Kelola Kategori</h2>
    </div>

    <!-- Form tambah -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-10">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Kategori" required>
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
                    <h5 class="card-title text-primary">{{ $kategori->count() }}</h5>
                    <p class="card-text text-muted">Total Kategori</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori List -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama Kategori</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $index => $k)
                        <tr>
                            <td class="align-middle">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tags text-muted me-2"></i>
                                    <div>
                                        <h6 class="mb-0">{{ $k->nama }}</h6>
                                        <small class="text-muted">ID: {{ $k->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">
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
                                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada kategori ditemukan</h5>
                                    <p class="text-muted">Silakan tambahkan kategori baru</p>
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
