@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container">
    <h2>Edit Kategori</h2>

    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" value="{{ $kategori->nama }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
