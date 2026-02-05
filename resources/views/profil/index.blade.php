@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user me-2"></i>Profil Saya</h4>
                    <a href="{{ route('profil.edit') }}" class="btn btn-light">
                        <i class="fas fa-edit me-1"></i>Edit Profil
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="profile-image mb-4">
                                <div class="avatar avatar-lg mx-auto">
                                    <span class="avatar-text bg-success rounded-circle">
                                        {{ strtoupper(substr($user->name ?? 'User', 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <h5>{{ $user->name ?? 'Nama Pengguna' }}</h5>
                            <p class="text-muted">{{ $user->email ?? 'Email tidak tersedia' }}</p>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="30%"><strong>Nama Lengkap</strong></td>
                                        <td width="5%">:</td>
                                        <td>{{ $user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>:</td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Induk</strong></td>
                                        <td>:</td>
                                        <td>{{ $user->no_induk ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kelas</strong></td>
                                        <td>:</td>
                                        <td>{{ $user->kelas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jurusan</strong></td>
                                        <td>:</td>
                                        <td>{{ $user->jurusan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Peran</strong></td>
                                        <td>:</td>
                                        <td>
                                            @if($user->role == 0)
                                                <span class="badge bg-primary">Admin</span>
                                            @else
                                                <span class="badge bg-info">Anggota</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Bergabung</strong></td>
                                        <td>:</td>
                                        <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-image {
        margin: 20px auto;
    }
    
    .avatar {
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-text {
        font-size: 3rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    
    table td {
        padding: 8px 0;
        vertical-align: top;
    }
    
    .table-borderless > tbody > tr > td {
        border: none;
    }
    
    .badge {
        font-size: 0.85em;
    }
</style>
@endsection