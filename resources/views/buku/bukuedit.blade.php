@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-1">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Edit Buku</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('updatebuku', $buku->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" required>
                </div>

                <div class="mb-3">
                    <label for="penerbit" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_terbit" class="form-label">Tahun Terbit</label>
                    <input type="text" class="form-control" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit', $buku->tanggal_terbit) }}" required>
                </div>

                <div class="mb-3">
                    <label for="kode_rak" class="form-label">Kode Rak</label>
                    <select class="form-select" id="kode_rak" name="kode_rak" required>
                        <option value="">Pilih Kode Rak</option>
                        @foreach (['RAK 1', 'RAK 2', 'RAK 3', 'RAK 4', 'RAK 5'] as $rak)
                            <option value="{{ $rak }}" {{ $buku->kode_rak == $rak ? 'selected' : '' }}>{{ $rak }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ $buku->kategori_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="bidang_kajian_id" class="form-label">Bidang Kajian</label>
                    <select class="form-select" id="bidang_kajian_id" name="bidang_kajian_id" required>
                        <option value="">Pilih Bidang Kajian</option>
                        @foreach ($bidangkajian as $b)
                            <option value="{{ $b->id }}" {{ $buku->bidang_kajian_id == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Buku</label>
                    <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*" onchange="previewImage(event)">
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                </div>

                <div class="mb-3">
                    <div id="current-image" class="text-center mb-3">
                        @if($buku->gambar)
                            <p>Gambar saat ini:</p>
                            <img src="{{ asset('storage/'.$buku->gambar) }}"
                                 alt="{{ $buku->judul }}"
                                 style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ddd; padding: 5px;">
                        @else
                            <p>Tidak ada gambar saat ini</p>
                        @endif
                    </div>
                    <div id="image-preview" class="text-center">
                        <!-- Preview akan muncul di sini jika ada upload baru -->
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.innerHTML = `
                <p>Pratinjau gambar baru:</p>
                <img src="${e.target.result}"
                     alt="Preview Gambar"
                     style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 1px solid #ddd; padding: 5px;">
                <p class="mt-2">Preview: ${file.name}</p>
            `;
        }

        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
    }
}
</script>
@endsection
