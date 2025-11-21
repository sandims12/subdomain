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
    /** ===================== FORM CREATE ===================== */
    public function create()
    {
        $categories    = Category::all();
        $subcategories = Subcategory::all();

        return view('skpd.layouts.wrapper', [
            'content'       => 'skpd.permohonan.create',
            'categories'    => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    /** ======================== STORE ======================== */
    public function store(Request $request)
    {
        // Validasi pakai NAME
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|string|exists:subcategories,name',
            'vendor'         => 'required|in:iya,tidak',
            'nama_vendor'    => 'nullable|required_if:vendor,iya|max:255',
            'file_pengajuan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Ambil ID subkategori berdasarkan NAME
        $subcategory = Subcategory::where('name', $request->subcategory_id)->first();

        $user         = Auth::user();
        $permohonan   = new Permohonan();
        $permohonan->skpd_id        = $user->id;
        $permohonan->category_id    = $request->category_id;
        $permohonan->subcategory_id = $subcategory->id;

        // Deteksi subdomain berdasarkan NAMA, bukan ID
        $isSubdomain = strtolower(str_replace(' ', '', $request->subcategory_id)) === 'subdomain';

        if ($isSubdomain) {
            $request->validate([
                'nama_subdomain' => 'required|string|max:100'
            ]);

            $permohonan->nama_subdomain = $request->nama_subdomain; // simpan
            $permohonan->status         = 'menunggu';
        } else {
            // Form umum
            $request->validate([
                'subjek'    => 'required|string|max:100',
                'deskiprsi' => 'required|string',      // <- gunakan kolom sesuai DB
                'lokasi'    => 'required|in:Indoor,Outdoor',
            ]);

            $permohonan->status    = 'menunggu';
            $permohonan->subjek    = $request->subjek;
            $permohonan->deskiprsi = $request->deskiprsi; // <- jangan diubah namanya
            $permohonan->lokasi    = $request->lokasi;
        }

        // Upload file
        if ($request->hasFile('file_pengajuan')) {
            @mkdir(public_path('uploads/permohonan'), 0775, true);
            $file     = $request->file('file_pengajuan');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/permohonan'), $namaFile);
            $permohonan->file_pengajuan = $namaFile;
        }

        $permohonan->vendor      = $request->vendor;
        $permohonan->nama_vendor = $request->vendor === 'iya' ? $request->nama_vendor : null;

        $permohonan->save();

        Alert::success('Berhasil', 'Permohonan berhasil dikirim.');
        return redirect()->route('skpd.dashboard');
    }

    /** ========================= INDEX ======================= */
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

    /** ========================== EDIT ======================= */
    public function edit(Permohonan $permohonan)
    {
        // hanya pemilik & status menunggu yang bisa edit
        if ($permohonan->skpd_id !== Auth::id()) abort(403);
        if ($permohonan->status !== 'menunggu') {
            Alert::error('Gagal', 'Permohonan yang sudah diproses tidak dapat diedit.');
            return back();
        }

        $categories    = Category::all();
        $subcategories = Subcategory::all();

        return view('skpd.layouts.wrapper', [
            'content'       => 'skpd.permohonan.edit',
            'permohonan'    => $permohonan,
            'categories'    => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    /** ========================= UPDATE ====================== */
    public function update(Request $request, Permohonan $permohonan)
    {
        if ($permohonan->skpd_id !== Auth::id()) abort(403);
        if ($permohonan->status !== 'menunggu') {
            Alert::error('Gagal', 'Permohonan yang sudah diproses tidak dapat diedit.');
            return back();
        }

        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|string|exists:subcategories,name',
            'vendor'         => 'required|in:iya,tidak',
            'nama_vendor'    => 'nullable|required_if:vendor,iya|max:255',
            'file_pengajuan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $subcategory = Subcategory::where('name', $request->subcategory_id)->first();

        $permohonan->category_id    = $request->category_id;
        $permohonan->subcategory_id = $subcategory->id;

        $isSubdomain = strtolower(str_replace(' ', '', $request->subcategory_id)) === 'subdomain';

        if ($isSubdomain) {
            $request->validate([
                'nama_subdomain' => 'required|string|max:100'
            ]);

            $permohonan->nama_subdomain = $request->nama_subdomain;
            // kosongkan field umum
            $permohonan->subjek    = null;
            $permohonan->deskiprsi = null;  // tetap kolom 'deskiprsi'
            $permohonan->lokasi    = null;
        } else {
            $request->validate([
                'subjek'    => 'required|string|max:100',
                'deskiprsi' => 'required|string',
                'lokasi'    => 'required|in:Indoor,Outdoor',
            ]);

            $permohonan->nama_subdomain = null;
            $permohonan->subjek    = $request->subjek;
            $permohonan->deskiprsi = $request->deskiprsi; // tetap pakai 'deskiprsi'
            $permohonan->lokasi    = $request->lokasi;
        }

        // File baru?
        if ($request->hasFile('file_pengajuan')) {
            @mkdir(public_path('uploads/permohonan'), 0775, true);
            // hapus file lama jika ada
            if ($permohonan->file_pengajuan && file_exists(public_path('uploads/permohonan/'.$permohonan->file_pengajuan))) {
                @unlink(public_path('uploads/permohonan/'.$permohonan->file_pengajuan));
            }
            $file     = $request->file('file_pengajuan');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/permohonan'), $namaFile);
            $permohonan->file_pengajuan = $namaFile;
        }

        $permohonan->vendor      = $request->vendor;
        $permohonan->nama_vendor = $request->vendor === 'iya' ? $request->nama_vendor : null;

        // tetap menunggu
        $permohonan->status = 'menunggu';
        $permohonan->save();

        Alert::success('Berhasil', 'Permohonan berhasil diperbarui.');
        return redirect()->route('skpd.permohonan.index');
    }

    /** ========================= DESTROY ===================== */
    public function destroy(Permohonan $permohonan)
    {
        if ($permohonan->skpd_id !== Auth::id()) abort(403);
        if ($permohonan->status !== 'menunggu') {
            Alert::error('Gagal', 'Permohonan yang sudah diproses tidak dapat dihapus.');
            return back();
        }

        if ($permohonan->file_pengajuan && file_exists(public_path('uploads/permohonan/'.$permohonan->file_pengajuan))) {
            @unlink(public_path('uploads/permohonan/'.$permohonan->file_pengajuan));
        }

        $permohonan->delete();

        Alert::success('Berhasil', 'Permohonan berhasil dihapus.');
        return redirect()->route('skpd.permohonan.index');
    }
}
