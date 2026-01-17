<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    // 1. Tampilkan semua data
    public function index()
    {
        $lapangan = Lapangan::all();
        return view('admin.lapangan.index', compact('lapangan'));
    }

    // 2. Tampilkan form tambah
    public function create()
    {
        return view('admin.lapangan.create');
    }

    // 3. Proses simpan data ke database
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'harga_siang'   => 'required|numeric',
            'harga_malam'   => 'required|numeric',
            'gambar'        => 'image|file|max:2048'
        ]);

        // 2. Upload Gambar (Jika ada)
        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $request->file('gambar')->store('lapangan-img', 'public');
        }

        // 3. Simpan ke Database (Kiri: Nama Kolom DB, Kanan: Nama Input Form)
        Lapangan::create([
            'nama_lapangan'    => $request->nama_lapangan, 
            'harga_sewa_siang' => $request->harga_siang,   
            'harga_sewa_malam' => $request->harga_malam,   
            'deskripsi'        => $request->deskripsi,
            'gambar'           => $pathGambar,
            'status'           => 'tersedia' // Default status
        ]);

        return redirect('/admin/lapangan')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit
    public function edit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    // 5. Proses update data
    // Ganti function update di LapanganController.php dengan ini:
    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $request->validate([
            'nama_lapangan' => 'required', // Sesuaikan nama input di form edit nanti
            'harga_siang'   => 'required|numeric',
            'harga_malam'   => 'required|numeric',
        ]);

        // Cek jika ada upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($lapangan->gambar) {
                Storage::delete('public/' . $lapangan->gambar);
            }
            // Upload gambar baru
            $pathGambar = $request->file('gambar')->store('lapangan-img', 'public');
            $lapangan->gambar = $pathGambar;
        }

        // Update data sesuai nama kolom database
        $lapangan->nama_lapangan    = $request->nama_lapangan;
        $lapangan->harga_sewa_siang = $request->harga_siang;
        $lapangan->harga_sewa_malam = $request->harga_malam;
        $lapangan->deskripsi        = $request->deskripsi;
        $lapangan->save();

        return redirect('/admin/lapangan')->with('success', 'Data berhasil diperbarui!');
    }

    // 6. Hapus data
    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        // Hapus file gambar dari folder
        if ($lapangan->gambar) {
            Storage::delete('public/' . $lapangan->gambar);
        }

        $lapangan->delete();

        return redirect('/admin/lapangan')->with('success', 'Lapangan dihapus!');
    }
}