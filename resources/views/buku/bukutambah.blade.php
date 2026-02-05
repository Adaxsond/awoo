@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <div class="card shadow-sm border-1">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Buku</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('simpanbuku') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" name="stok" id="stok" required>
                </div>

                <div class="mb-3">
                    <label for="penerbit" class="form-label">Penerbit/Penulis</label>
                    <input type="text" class="form-control" name="penerbit" id="penerbit" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_terbit" class="form-label">Tahun Terbit</label>
                    <input type="year" class="form-control" name="tanggal_terbit" id="tahun_terbit" required>
                </div>

                <div class="mb-3">
                    <label for="kode_rak" class="form-label">Kode Rak</label>
                    <select name="kode_rak" id="kode_rak" class="form-select" required>
                        <option value="">Pilih Kode Rak</option>
                        <option value="RAK 1">RAK 1</option>
                        <option value="RAK 2">RAK 2</option>
                        <option value="RAK 3">RAK 3</option>
                        <option value="RAK 4">RAK 4</option>
                        <option value="RAK 5">RAK 5</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="bidang_kajian_id" class="form-label">Bidang Kajian</label>
                    <select name="bidang_kajian_id" id="bidang_kajian_id" class="form-select" required>
                        <option value="">Pilih Bidang Kajian</option>
                        @foreach ($bidangkajian as $b)
                            <option value="{{ $b->id }}">{{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Buku</label>
                    <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*" onchange="previewImage(event)">
                </div>

                <div class="mb-3">
                    <div id="image-preview" class="text-center">
                        <!-- Preview akan muncul di sini -->
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" placeholder="Deskripsi"></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">Simpan</button>
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
