<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Subdomain;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPermohonanController extends Controller
{
public function index(Request $request)
{
    // Ambil query builder
    $query = Permohonan::with('skpd', 'category', 'subcategory', 'subdomain')->latest();

    // Filter berdasarkan kategori jika ada
    if ($request->filled('kategori')) {
        $query->where('category_id', $request->kategori);
    }

    // Filter berdasarkan subkategori jika ada
    if ($request->filled('subkategori')) {
        $query->where('subcategory_id', $request->subkategori);
    }

    // Eksekusi query
    $permohonan = $query->get();

    // Ambil semua kategori & subkategori untuk dropdown filter
    $allKategori = Category::all();
    $allSubkategori = Subcategory::all();

    return view('admin.permohonan.index', compact('permohonan', 'allKategori', 'allSubkategori'));
}

    public function show($id)
    {
        $permohonan = Permohonan::with('skpd','category','subcategory')->findOrFail($id);
        return view('admin.permohonan.show', compact('permohonan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak',
            'keterangan_admin' => 'nullable|string|max:500',
            'file_tindak_lanjut' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $permohonan = Permohonan::findOrFail($id);
        $permohonan->status = $request->status;
        $permohonan->keterangan_admin = $request->keterangan_admin;

        // Upload file tindak lanjut (jika ada)
        if ($request->hasFile('file_tindak_lanjut')) {
            $file = $request->file('file_tindak_lanjut');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/tindaklanjut'), $fileName);
            $permohonan->file_tindak_lanjut = $fileName;
        }

        $permohonan->save();

        /**
         * ====================================================
         *  KHUSUS SUBDOMAIN (category=3 && subcategory=6)
         * ====================================================
         */
        if ($permohonan->status === 'disetujui') {

            // Ambil nama subdomain yang disimpan oleh user
            $sessionKey = "subdomain_{$permohonan->skpd_id}";
            $namaSubdomain = session($sessionKey);

            // Jika bukan permohonan subdomain, skip
            if ($namaSubdomain) {

                Subdomain::updateOrCreate(
                    ['permohonan_id' => $permohonan->id],
                    [
                        'skpd_id' => $permohonan->skpd_id,
                        'nama_subdomain' => $namaSubdomain,
                        'status' => 'aktif',
                        'tanggal_permohonan' => $permohonan->created_at,
                        'link' => 'https://' . $namaSubdomain,
                    ]
                );

                // hapus session biar tidak nyangkut
                session()->forget($sessionKey);
            }
        }

        Alert::success('Berhasil', 'Status permohonan telah diperbarui.');
        return redirect()->route('admin.permohonan.index');
    }
}
