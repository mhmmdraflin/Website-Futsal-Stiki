<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Futsal App</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="alert alert-info">Selamat datang Muhammad Rafli Nurfathan, <strong>{{ Auth::user()->name }}</strong>! Mau main di mana hari ini?</div>
        
        <h3 class="mb-3">Pilihan Lapangan</h3>
        <div class="row">
            @foreach($lapangan as $l)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div style="height: 200px; overflow: hidden;">
                        @if($l->gambar)
                            <img src="{{ asset('storage/' . $l->gambar) }}" class="card-img-top" style="object-fit: cover; height: 100%; width: 100%;">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top">
                        @endif
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $l->nama_lapangan }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($l->deskripsi, 50) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-warning text-dark">Siang: Rp {{ number_format($l->harga_sewa_siang) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-dark">Malam: Rp {{ number_format($l->harga_sewa_malam) }}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        {{-- Tombol ini nanti akan mengarah ke fitur Booking --}}
                        <button class="btn btn-success w-100">Booking Sekarang</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>