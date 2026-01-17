<!DOCTYPE html>
<html>
<head>
    <title>Tambah Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 shadow rounded" style="max-width: 600px;">
        <h3 class="mb-4">Tambah Lapangan Baru</h3>
        
        {{-- Tampilkan Error Validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lapangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label>Nama Lapangan</label>
                {{-- PERHATIKAN name="nama_lapangan" --}}
                <input type="text" name="nama_lapangan" class="form-control" required placeholder="Contoh: Lapangan A (Sintetis)">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Harga Sewa Siang</label>
                    <input type="number" name="harga_siang" class="form-control" required placeholder="Contoh: 100000">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Harga Sewa Malam</label>
                    <input type="number" name="harga_malam" class="form-control" required placeholder="Contoh: 150000">
                </div>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label>Foto Lapangan</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <button type="submit" class="btn btn-success w-100">Simpan Data</button>
            <a href="{{ route('lapangan.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
        </form>
    </div>
</body>
</html>