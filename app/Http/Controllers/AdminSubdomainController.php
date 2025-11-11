<?php

namespace App\Http\Controllers;

use App\Models\Subdomain;
use Illuminate\Http\Request;

class AdminSubdomainController extends Controller
{
    // Menampilkan daftar subdomain
    public function index()
    {
        // load relasi skpd supaya bisa dipakai di view
        $subdomain = Subdomain::with('skpd')->latest()->get();

        return view('admin.subdomain.index', compact('subdomain'));
    }

    // Menampilkan form untuk membuat subdomain baru
    public function create()
    {
        return view('admin.subdomain.create');
    }

    // Menyimpan data subdomain baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_subdomain' => 'required|string|max:255',
            'skpd_id' => 'required|exists:users,id',
            'kondisi' => 'required|in:aktif,nonaktif,error',
        ]);

        Subdomain::create([
            'skpd_id' => $request->skpd_id,
            'nama_subdomain' => $request->nama_subdomain,
            'kondisi' => $request->kondisi,
        ]);

        return redirect()->route('admin.subdomain.index')->with('success', 'Subdomain berhasil dibuat!');
    }

    // Menampilkan form untuk mengedit data subdomain
    public function edit($id)
    {
        $subdomain = Subdomain::findOrFail($id);
        return view('admin.subdomain.edit', compact('subdomain'));
    }

    // Update data subdomain
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_subdomain' => 'required|string|max:255',
            'kondisi' => 'required|in:aktif,nonaktif,error',
        ]);

        $subdomain = Subdomain::findOrFail($id);
        $subdomain->update([
            'nama_subdomain' => $request->nama_subdomain,
            'kondisi' => $request->kondisi,
        ]);

        return redirect()->route('admin.subdomain.index')->with('success', 'Subdomain berhasil diperbarui!');
    }

    // Menghapus subdomain
    public function destroy($id)
    {
        $subdomain = Subdomain::findOrFail($id);
        $subdomain->delete();

        return redirect()->route('admin.subdomain.index')->with('success', 'Subdomain berhasil dihapus!');
    }
}
