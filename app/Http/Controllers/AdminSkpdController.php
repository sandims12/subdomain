<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminSkpdController extends Controller
{
    /**
     * Menampilkan halaman Data SKPD
     */
    public function index()
    {
        $skpd = User::where('role', 'skpd')->latest()->get(); // Ambil data SKPD berdasarkan role
        return view('admin.skpd.index', compact('skpd'));
    }

    /**
     * Menampilkan form untuk tambah SKPD
     */
    public function create()
    {
        return view('admin.skpd.create'); // Tampilkan form untuk tambah SKPD
    }

    /**
     * Menyimpan data SKPD yang baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Pastikan email unik
            'password' => 'required|string|min:8|confirmed', // Password minimal 8 karakter
        ]);

        // Menyimpan data SKPD baru ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encrypt password
            'role' => 'skpd', // Pastikan role SKPD
        ]);

        // Menampilkan pesan sukses
        Alert::success('Berhasil', 'SKPD berhasil ditambahkan!');
        return redirect()->route('admin.skpd.index'); // Kembali ke halaman daftar SKPD
    }

    /**
     * Menampilkan form untuk edit SKPD
     */
    public function edit($id)
    {
        $skpd = User::findOrFail($id); // Ambil data SKPD berdasarkan ID
        return view('admin.skpd.edit', compact('skpd')); // Tampilkan form edit
    }

    /**
     * Mengupdate data SKPD
     */
    public function update(Request $request, $id)
    {
        $skpd = User::findOrFail($id); // Ambil data SKPD berdasarkan ID

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $skpd->id, // Periksa email, kecuali milik SKPD yang sama
            'password' => 'nullable|string|min:6|confirmed', // Password bisa kosong, jika tidak diubah
        ]);

        // Update data SKPD
        $skpd->name = $request->name;
        $skpd->email = $request->email;

        // Jika password diubah, simpan password yang baru
        if ($request->filled('password')) {
            $skpd->password = Hash::make($request->password);
        }

        $skpd->save(); // Simpan perubahan

        // Menampilkan pesan sukses
        Alert::success('Berhasil', 'Data SKPD berhasil diperbarui!');
        return redirect()->route('admin.skpd.index');
    }

    /**
     * Menghapus data SKPD
     */
    public function destroy($id)
    {
        $skpd = User::findOrFail($id); // Ambil data SKPD berdasarkan ID
        $skpd->delete(); // Hapus data SKPD

        // Menampilkan pesan sukses
        Alert::success('Berhasil', 'Akun SKPD berhasil dihapus!');
        return redirect()->route('admin.skpd.index'); // Kembali ke daftar SKPD
    }
}
