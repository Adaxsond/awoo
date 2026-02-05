@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container">
    <h2>Tambah Kategori</h2>

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection