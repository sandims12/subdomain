<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Subdomain;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\PermohonanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPermohonanController extends Controller
{

    public function exportPdf()
    {
        $permohonan = Permohonan::with('skpd')->latest()->get();

        $pdf = Pdf::loadView('admin.permohonan.pdf', compact('permohonan'))
                ->setPaper('A4', 'portrait');

        return $pdf->download('laporan_permohonan.pdf');
    }


    public function exportExcel()
    {
        return Excel::download(new PermohonanExport, 'laporan_permohonan.xlsx');
    }   
    public function index()
    {
        $permohonan = Permohonan::with('skpd', 'category', 'subcategory')->latest()->get();
        return view('admin.permohonan.index', compact('permohonan'));
    }

    public function show($id)
    {
        $permohonan = Permohonan::with('skpd', 'category', 'subcategory')->findOrFail($id);
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

        // Upload file
        if ($request->hasFile('file_tindak_lanjut')) {
            $file = $request->file('file_tindak_lanjut');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/tindaklanjut'), $fileName);
            $permohonan->file_tindak_lanjut = $fileName;
        }

        $permohonan->save();

        // Jika disetujui → buat/aktifkan subdomain
        if ($permohonan->status === 'disetujui') {
            Subdomain::updateOrCreate(
                ['permohonan_id' => $permohonan->id],
                [
                    'skpd_id' => $permohonan->skpd_id,
                    'nama_subdomain' => $permohonan->nama_subdomain,
                    'status' => 'aktif',
                    'tanggal_permohonan' => $permohonan->created_at,
                    'link' => 'https://' . $permohonan->nama_subdomain,
                ]
            );
        }

        Alert::success('Berhasil', 'Status permohonan telah diperbarui.');
        return redirect()->route('admin.permohonan.index');
    }

    // ======================
    // DELETE PERMOHONAN
    // ======================
    public function destroy($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        if ($permohonan->status !== 'ditolak') {
            Alert::error('Gagal', 'Hanya permohonan dengan status DITOLAK yang dapat dihapus.');
            return redirect()->back();
        }

        $permohonan->delete();

        Alert::success('Berhasil', 'Permohonan berhasil dihapus.');
        return redirect()->route('admin.permohonan.index');
    }
}
