<!DOCTYPE html>
<html>
<head>
    <title>Edit Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 shadow rounded col-md-6">
        <h3>Edit Lapangan</h3>
        <hr>
        
        {{-- PERBAIKAN 1: Gunakan id_lapangan pada route --}}
        <form action="{{ route('lapangan.update', $lapangan->id_lapangan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
            
            <div class="mb-3">
                <label>Nama Lapangan</label>
                {{-- PERBAIKAN 2: name dan value disesuaikan dengan database (nama_lapangan) --}}
                <input type="text" name="nama_lapangan" class="form-control" value="{{ $lapangan->nama_lapangan }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Harga Sewa Siang</label>
                    {{-- PERBAIKAN 3: Input harga dipecah jadi siang & malam --}}
                    <input type="number" name="harga_siang" class="form-control" value="{{ $lapangan->harga_sewa_siang }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Harga Sewa Malam</label>
                    <input type="number" name="harga_malam" class="form-control" value="{{ $lapangan->harga_sewa_malam }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ $lapangan->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label>Foto Saat Ini</label><br>
                @if($lapangan->gambar)
                    <img src="{{ asset('storage/' . $lapangan->gambar) }}" width="120" class="mb-2 rounded">
                @else
                    <span class="text-muted">Belum ada foto</span>
                @endif
            </div>

            <div class="mb-3">
                <label>Ganti Foto (Biarkan kosong jika tidak ingin mengganti)</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('lapangan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>