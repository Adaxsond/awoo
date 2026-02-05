@extends('layouts.app')

@section('title', 'Edit Profil Anggota')

@section('content')
<div class="container">
    <h2>Edit Profil Anggota</h2>
    <form method="POST" action="{{ route('updateanggota', $anggota->id) }}">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $anggota->nama) }}" required>
        </div>

        <div class="mb-3">
            <label>NISN</label>
            <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $anggota->nisn) }}" required>
        </div>

        <div class="mb-3">
            <label>Kelas</label>
            <select name="kelas" class="form-select" required>
                @foreach (['10', '11', '12'] as $kelas)
                    <option value="{{ $kelas }}" {{ $anggota->kelas == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jurusan</label>
            <select name="jurusan" class="form-select" required>
                @foreach (['AK', 'MK', 'TKJ', 'TM', 'TO', 'TKG'] as $jurusan)
                    <option value="{{ $jurusan }}" {{ $anggota->jurusan == $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $anggota->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Nomor Handphone</label>
            <input type="text" name="nohp" class="form-control" value="{{ old('nohp', $anggota->nohp) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection
