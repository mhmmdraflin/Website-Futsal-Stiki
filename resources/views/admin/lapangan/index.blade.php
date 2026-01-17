<!DOCTYPE html>
<html>
<head>
    <title>Kelola Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 shadow rounded">
        <div class="d-flex justify-content-between mb-3">
            <h3>Daftar Lapangan Futsal</h3>
            <div>
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                <a href="{{ route('lapangan.create') }}" class="btn btn-primary">+ Tambah Lapangan</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Lapangan</th>
                    <th>Harga Siang / Malam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lapangan as $key => $l)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if($l->gambar)
                            <img src="{{ asset('storage/' . $l->gambar) }}" width="100">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    {{-- PERBAIKAN: Menggunakan nama_lapangan sesuai database --}}
                    <td>{{ $l->nama_lapangan }}</td> 
                    
                    {{-- PERBAIKAN: Menampilkan harga siang & malam --}}
                    <td>
                        Siang: Rp {{ number_format($l->harga_sewa_siang) }}<br>
                        Malam: Rp {{ number_format($l->harga_sewa_malam) }}
                    </td>

                    <td>
                        <span class="badge {{ $l->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($l->status) }}
                        </span>
                    </td>

                    <td>
                        {{-- PERBAIKAN: Menggunakan id_lapangan sebagai parameter --}}
                        <a href="{{ route('lapangan.edit', $l->id_lapangan) }}" class="btn btn-warning btn-sm">Edit</a>
                        
                        <form action="{{ route('lapangan.destroy', $l->id_lapangan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>