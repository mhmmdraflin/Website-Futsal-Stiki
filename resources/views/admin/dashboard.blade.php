<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Futsal Stiki - ADMIN</a>
            
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf <button class="btn btn-danger btn-sm" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h3>Selamat Datang, Admin!</h3>
                <p>Anda login sebagai: <strong>{{ Auth::user()->NAMA_USER }}</strong></p>
                <hr>
                <p>Di sini nanti kita akan membuat tabel CRUD data lapangan.</p>
                <a href="{{ url('/admin/lapangan') }}" class="btn btn-success mt-3">Kelola Data Lapangan</a>
            </div>
        </div>
    </div>
</body>
</html>