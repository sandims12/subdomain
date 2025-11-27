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
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|string|exists:subcategories,name',
            'vendor'         => 'required|in:iya,tidak',
            'nama_vendor'    => 'nullable|required_if:vendor,iya|max:255',
            'file_pengajuan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',

            'nama_subdomain' => 'nullable|string|max:100',
            'nama_aplikasi'  => 'nullable|string|max:255',
            'sifat'          => 'nullable|in:Online,Offline',
            'tahun_penganggaran' => 'nullable|digits:4',
            'layanan'         => 'nullable|string',
            'platform_os'     => 'nullable|string',
            'jenis_aplikasi'  => 'nullable|string',
            'database_engine' => 'nullable|string',
            'bahasa_pemrograman' => 'nullable|string',
            'pengelola'       => 'nullable|string',
            'ket_pembangunan' => 'nullable|string',
            'kendala'         => 'nullable|string',
            'tindak_lanjut'   => 'nullable|string',

            'subjek'          => 'nullable|string',
            'deskiprsi'       => 'nullable|string',
            'lokasi'          => 'nullable|in:Indoor,Outdoor',
        ]);

        $user = Auth::user();
        $subcategory = Subcategory::where('name', $request->subcategory_id)->first();

        $permohonan = new Permohonan();
        $permohonan->skpd_id = $user->id;
        $permohonan->category_id = $request->category_id;
        $permohonan->subcategory_id = $subcategory->id;
        $permohonan->vendor = $request->vendor;
        $permohonan->nama_vendor = $request->nama_vendor;
        $permohonan->status = 'menunggu';

        $isSubdomain = strtolower(str_replace(' ', '', $subcategory->name)) === 'subdomain';
        if ($isSubdomain) {
            $permohonan->nama_subdomain = $request->nama_subdomain;
        } else {
            $permohonan->subjek = $request->subjek;
            $permohonan->deskiprsi = $request->deskiprsi;
            $permohonan->lokasi = $request->lokasi;
        }

        if ($request->hasFile('file_pengajuan')) {
            $file = $request->file('file_pengajuan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/permohonan'), $fileName);
            $permohonan->file_pengajuan = $fileName;
        }

        $permohonan->save();

        if ($isSubdomain) {
            $subdomain = new Subdomain();
            $subdomain->skpd_id = $user->id;
            $subdomain->permohonan_id = $permohonan->id;
            $subdomain->nama_subdomain = $request->nama_subdomain;
            $subdomain->nama_aplikasi = $request->nama_aplikasi;
            $subdomain->sifat = $request->sifat;
            $subdomain->tahun_penganggaran = $request->tahun_penganggaran;
            $subdomain->layanan = $request->layanan;
            $subdomain->platform_os = $request->platform_os;
            $subdomain->jenis_aplikasi = $request->jenis_aplikasi;
            $subdomain->database_engine = $request->database_engine;
            $subdomain->bahasa_pemrograman = $request->bahasa_pemrograman;
            $subdomain->pengelola = $request->pengelola;
            $subdomain->ket_pembangunan = $request->ket_pembangunan;
            $subdomain->kendala_pembangunan = $request->kendala;
            $subdomain->rencana_tindak_lanjut = $request->tindak_lanjut;
            $subdomain->status = 'pending';
            $subdomain->kondisi = 'nonaktif';
            $subdomain->save();
        }

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

    /** ========================= UPDATE (untuk SKPD) ====================== */
    public function update(Request $request, $id)
    {
        $permohonan = Permohonan::findOrFail($id);

        if ($permohonan->skpd_id !== Auth::id()) abort(403);
        if ($permohonan->status !== 'menunggu') {
            Alert::error('Gagal', 'Permohonan yang sudah diproses tidak dapat diperbarui.');
            return back();
        }

        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|string|exists:subcategories,name',
            'vendor'         => 'required|in:iya,tidak',
            'nama_vendor'    => 'nullable|required_if:vendor,iya|max:255',
            'file_pengajuan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'nama_subdomain' => 'nullable|string|max:100',
            'nama_aplikasi'  => 'nullable|string|max:255',
            'sifat'          => 'nullable|in:Online,Offline',
            'tahun_penganggaran' => 'nullable|digits:4',
            'layanan'         => 'nullable|string',
            'platform_os'     => 'nullable|string',
            'jenis_aplikasi'  => 'nullable|string',
            'database_engine' => 'nullable|string',
            'bahasa_pemrograman' => 'nullable|string',
            'pengelola'       => 'nullable|string',
            'ket_pembangunan' => 'nullable|string',
            'kendala'         => 'nullable|string',
            'tindak_lanjut'   => 'nullable|string',
            'subjek'          => 'nullable|string',
            'deskiprsi'       => 'nullable|string',
            'lokasi'          => 'nullable|in:Indoor,Outdoor',
        ]);

        $subcategory = Subcategory::where('name', $request->subcategory_id)->first();

        $permohonan->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $subcategory->id,
            'vendor' => $request->vendor,
            'nama_vendor' => $request->nama_vendor,
        ]);

        $isSubdomain = strtolower(str_replace(' ', '', $subcategory->name)) === 'subdomain';
        if ($isSubdomain) {
            $permohonan->nama_subdomain = $request->nama_subdomain;
        } else {
            $permohonan->subjek = $request->subjek;
            $permohonan->deskiprsi = $request->deskiprsi;
            $permohonan->lokasi = $request->lokasi;
        }

        if ($request->hasFile('file_pengajuan')) {
            $file = $request->file('file_pengajuan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/permohonan'), $fileName);
            $permohonan->file_pengajuan = $fileName;
        }

        $permohonan->save();

        Alert::success('Berhasil', 'Permohonan berhasil diperbarui.');
        return redirect()->route('skpd.permohonan.index');
    }
    public function show($id)
    {
        $permohonan = Permohonan::with(['skpd', 'category', 'subcategory', 'subdomain'])->findOrFail($id);
        return view('skpd.permohonansaya.show', compact('permohonan'));
    }
    


    /** ========================= UPDATE STATUS (ADMIN) ====================== */
    public function updateStatus(Request $request, $id)
    {
        
        $request->validate([
            'status'            => 'required|in:menunggu,disetujui,ditolak',
            'keterangan_admin'  => 'nullable|string|max:500',
            'file_tindak_lanjut'=> 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $permohonan = Permohonan::findOrFail($id);
        $permohonan->status = $request->status;
        $permohonan->keterangan_admin = $request->keterangan_admin;

        if ($request->hasFile('file_tindak_lanjut')) {
            $file = $request->file('file_tindak_lanjut');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/tindaklanjut'), $fileName);
            $permohonan->file_tindak_lanjut = $fileName;
        }

        $permohonan->save();

        if ($permohonan->status === 'disetujui' && $permohonan->nama_subdomain) {
            Subdomain::updateOrCreate(
                ['permohonan_id' => $permohonan->id],
                [
                    'skpd_id'            => $permohonan->skpd_id,
                    'nama_subdomain'     => $permohonan->nama_subdomain,
                    'status'             => 'Aktif',
                    'kondisi'            => 'aktif',
                    'tanggal_permohonan' => $permohonan->created_at,
                    'link'               => 'https://' . $permohonan->nama_subdomain,
                ]
            );
        }

        Alert::success('Berhasil', 'Status permohonan telah diperbarui.');
        return redirect()->route('admin.permohonan.index');
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