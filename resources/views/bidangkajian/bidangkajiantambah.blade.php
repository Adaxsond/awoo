@extends('layouts.app')

@section('title', 'Tambah Bidang Kajian')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Bidang Kajian</h2>

    <form action="{{ route('bidangkajian.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Bidang Kajian</label>
            <input type="text" class="form-control" id="nama" name="nama" required placeholder="Contoh: Ilmu Sosial, Sains, Teknologi">
        </div>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="{{ route('bidangkajian.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </form>
</div>
@endsection
