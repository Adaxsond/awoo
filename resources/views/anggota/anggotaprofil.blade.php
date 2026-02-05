@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<div class="container">
    <h2>Profil Anggota</h2>

    <div class="card p-3 shadow">
        <p><strong>Nama:</strong> {{ $anggota->nama }}</p>
        <p><strong>NISN:</strong> {{ $anggota->nisn }}</p>
        <p><strong>Kelas:</strong> {{ $anggota->kelas }}</p>
        <p><strong>Jurusan:</strong> {{ $anggota->jurusan }}</p>
        <p><strong>Email:</strong> {{ $anggota->email }}</p>
        <p><strong>Nomor Handphone:</strong> {{ $anggota->nohp }}</p>

        <a href="{{ route('anggotaindex') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>
@endsection
