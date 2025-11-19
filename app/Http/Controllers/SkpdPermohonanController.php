<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use App\Models\Category;
use App\Models\Subdomain;
use App\Models\Subcategory;
use RealRashid\SweetAlert\Facades\Alert;

class SkpdPermohonanController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('skpd.layouts.wrapper', [
            'content' => 'skpd.permohonan.create',
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

public function store(Request $request)
{
$request->validate([
    'category_id' => 'required|exists:categories,id',
    'subcategory_id' => 'required|exists:subcategories,id',
    'vendor' => 'required|in:iya,tidak',
    'nama_vendor' => 'nullable|required_if:vendor,iya|max:255',
    'file_pengajuan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
]);


    $user = Auth::user();
    $permohonan = new Permohonan();
    $permohonan->skpd_id = $user->id;
    $permohonan->category_id = $request->category_id;
    $permohonan->subcategory_id = $request->subcategory_id;

    // KHUSUS SUBDOMAIN (Kategori = 3 dan Subkategori = 6)
    if ($request->category_id == 3 && $request->subcategory_id == 6) {
        $request->validate([
            'nama_subdomain' => 'required|string|max:100'
        ]);

        $namaSubdomain = $request->nama_subdomain;

        $permohonan->status = 'disetujui'; // langsung disetujui

    } else {
        // FORM UMUM – Harus isi subjek, deskripsi, lokasi
        $request->validate([
            'subjek' => 'required|string|max:100',
            'deskiprsi' => 'required|string',
            'lokasi' => 'required|in:Indoor,Outdoor',
        ]);

        $permohonan->status = 'menunggu';
        $permohonan->subjek = $request->subjek;
        $permohonan->deskiprsi = $request->deskiprsi;
        $permohonan->lokasi = $request->lokasi;
    }

    // Upload file pengajuan
    if ($request->hasFile('file_pengajuan')) {
        $file = $request->file('file_pengajuan');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/permohonan'), $namaFile);
        $permohonan->file_pengajuan = $namaFile;
    }

    $permohonan->vendor = $request->vendor;
$permohonan->nama_vendor = $request->vendor === 'iya' ? $request->nama_vendor : null;


    $permohonan->save();

    // Hanya jika subdomain
    if ($request->category_id == 3 && $request->subcategory_id == 6) {
        Subdomain::updateOrCreate(
            ['permohonan_id' => $permohonan->id],
            [
                'skpd_id' => $user->id,
                'nama_subdomain' => $namaSubdomain,
                'status' => 'aktif',
                'kondisi' => 'aktif',
                'tanggal_permohonan' => now(),
                'link' => 'https://' . $namaSubdomain,
            ]
        );
    }

    Alert::success('Berhasil', 'Permohonan berhasil dikirim.');
    return redirect()->route('skpd.dashboard');
}




    public function index()
    {
        $user = Auth::user();

        $riwayat = Permohonan::where('skpd_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('skpd.layouts.wrapper', [
            'content' => 'skpd.permohonansaya.index',
            'riwayat' => $riwayat,
        ]);
    }
}
