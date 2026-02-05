@extends('layouts.app')

@section('title', 'Edit Bidang Kajian')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Bidang Kajian</h2>

    <form action="{{ route('bidangkajian.update', $bidangkajian->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Bidang Kajian</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $bidangkajian->nama }}" required>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update
        </button>
        <a href="{{ route('bidangkajian.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Batal
        </a>
    </form>
</div>
@endsection
