<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan;
use App\Models\Category;
use App\Models\Subcategory;
use RealRashid\SweetAlert\Facades\Alert;

class SkpdPermohonanController extends Controller
{
    /**
     * Form pengajuan permohonan baru
     */
public function create()
{
    // Ambil semua kategori dan subkategori
    $categories = Category::all();
    $subcategories = Subcategory::all(); // Ambil semua subkategori

    // Kirim data kategori dan subkategori ke view
    return view('skpd.layouts.wrapper', [
        'content' => 'skpd.permohonan.create', // Tampilan untuk form permohonan
        'categories' => $categories,  // Kirim data kategori
        'subcategories' => $subcategories, // Kirim data subkategori
    ]);
}


    /**
     * Simpan permohonan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'nama_subdomain' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $permohonan = new Permohonan();
        // foreign key ke tabel users
        $permohonan->skpd_id        = $user->id;
        $permohonan->category_id    = $request->category_id; // Menambahkan kategori
        $permohonan->subcategory_id = $request->subcategory_id;
        $permohonan->nama_subdomain = $request->nama_subdomain;
        $permohonan->status         = 'menunggu';

        // Upload file pengajuan (jika ada)
        if ($request->hasFile('file_pengajuan')) {
            $file     = $request->file('file_pengajuan');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/permohonan'), $namaFile);

            $permohonan->file_pengajuan = $namaFile;
        }

        $permohonan->save();

        Alert::success(
            'Berhasil',
            'Permohonan berhasil diajukan dan menunggu persetujuan admin.'
        );

        return redirect()->route('skpd.dashboard');
    }

    /**
     * Halaman "Permohonan Saya" (riwayat semua permohonan SKPD yg login)
     */
    public function index()
    {
        $user = Auth::user();

        $riwayat = Permohonan::where('skpd_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('skpd.layouts.wrapper', [
            'content' => 'skpd.permohonansaya.index', // <-- view yang akan kita buat
            'riwayat' => $riwayat,
        ]);
    }
}
