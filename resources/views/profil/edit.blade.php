@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Profil</h4>
                    <a href="{{ route('profil.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="profile-image mb-4">
                                    <div class="avatar avatar-lg mx-auto">
                                        <span class="avatar-text bg-success rounded-circle">
                                            {{ strtoupper(substr($user->name ?? 'User', 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-muted">Foto Profil</p>
                                <button type="button" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-camera me-1"></i>Ganti Foto
                                </button>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="no_induk" class="form-label">No. Induk</label>
                                    <input type="text" class="form-control @error('no_induk') is-invalid @enderror" 
                                           id="no_induk" name="no_induk" value="{{ old('no_induk', $user->no_induk) }}">
                                    @error('no_induk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" 
                                           id="kelas" name="kelas" value="{{ old('kelas', $user->kelas) }}">
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control @error('jurusan') is-invalid @enderror" 
                                           id="jurusan" name="jurusan" value="{{ old('jurusan', $user->jurusan) }}">
                                    @error('jurusan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="button" class="btn btn-secondary me-md-2" onclick="window.history.back()">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
    
    .form-label {
        font-weight: 600;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
</style>
@endsection