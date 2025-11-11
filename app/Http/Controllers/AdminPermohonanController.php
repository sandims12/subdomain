<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Subdomain;
use RealRashid\SweetAlert\Facades\Alert;

class AdminPermohonanController extends Controller
{
    public function index()
    {
        $permohonan = Permohonan::with('skpd')->latest()->get();
        return view('admin.permohonan.index', compact('permohonan'));
    }

    public function show($id)
    {
        $permohonan = Permohonan::with('skpd')->findOrFail($id);
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

        // upload file persetujuan
        if ($request->hasFile('file_tindak_lanjut')) {
            $file = $request->file('file_tindak_lanjut');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/tindaklanjut'), $fileName);
            $permohonan->file_tindak_lanjut = $fileName;
        }

        $permohonan->save();

                // kalau disetujui, otomatis buat/aktifkan subdomain di tabel Subdomain
        if ($permohonan->status === 'disetujui') {
            Subdomain::updateOrCreate(
                ['permohonan_id' => $permohonan->id],
                [
                    'skpd_id'          => $permohonan->skpd_id,                
                    'nama_subdomain'   => $permohonan->nama_subdomain,
                    'status'           => 'aktif',
                    'tanggal_permohonan' => $permohonan->created_at,
                    'link'             => 'https://' . $permohonan->nama_subdomain,
                ]
            );
        }

        Alert::success('Berhasil', 'Status permohonan telah diperbarui.');
        return redirect()->route('admin.permohonan.index');
    }
}
