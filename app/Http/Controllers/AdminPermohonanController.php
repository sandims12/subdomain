<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Subdomain;
use RealRashid\SweetAlert\Facades\Alert;

// tambahan untuk export
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermohonanExport;

class AdminPermohonanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query builder
        $query = Permohonan::with('skpd', 'category', 'subcategory', 'subdomain')
            ->where('status', '!=', 'draft')   // ⬅️ admin cuma lihat yang bukan draft
            ->latest();


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
        $allKategori     = Category::all();
        $allSubkategori  = Subcategory::all();

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
        'status'            => 'required|in:disetujui,ditolak',
        'keterangan_admin'  => 'nullable|string|max:500',
        'file_tindak_lanjut'=> 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    $permohonan = Permohonan::findOrFail($id);
    $permohonan->status           = $request->status;
    $permohonan->keterangan_admin = $request->keterangan_admin;

    // upload file tindak lanjut
    if ($request->hasFile('file_tindak_lanjut')) {
        $file     = $request->file('file_tindak_lanjut');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/tindaklanjut'), $fileName);
        $permohonan->file_tindak_lanjut = $fileName;
    }

    $permohonan->save();

    /**
     * ============================================
     *  UPDATE STATUS SUBDOMAIN BERDASARKAN PERMOHONAN
     * ============================================
     */
    $subdomain = Subdomain::where('permohonan_id', $permohonan->id)->first();

    if ($subdomain) {
        if ($permohonan->status === 'disetujui') {
            // PERMOHONAN DISETUJUI → status subdomain "disetujui"
            $subdomain->status             = 'disetujui';
            //$subdomain->kondisi            = 'aktif';
            $subdomain->tanggal_permohonan = $permohonan->created_at;
            $subdomain->link               = 'https://' . $permohonan->nama_subdomain;

        } elseif ($permohonan->status === 'ditolak') {
            // PERMOHONAN DITOLAK → status subdomain "tidak disetujui"
            $subdomain->status  = 'tidak disetujui';
            //$subdomain->kondisi = 'nonaktif';
            // kalau mau kosongkan link:
            // $subdomain->link = null;

        } else {
            // MENUNGGU → status subdomain "menunggu"
            $subdomain->status = 'menunggu';
        }

        if (!empty($subdomain->ip_pointing)) {
            $subdomain->kondisi = 'aktif';
        } else {
            $subdomain->kondisi = 'nonaktif';
        }

        $subdomain->save();
    }

    Alert::success('Berhasil', 'Status permohonan telah diperbarui.');
    return redirect()->route('admin.permohonan.index');
}




    /** =========================
     *  Export Excel & PDF
     *  (mengikuti filter yang aktif)
     *  ========================= */
    public function exportExcel(Request $request)
    {
        // ikutkan filter kalau ada
        return Excel::download(
            new PermohonanExport($request->kategori, $request->subkategori),
            'permohonan_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $q = Permohonan::with('skpd','category','subcategory','subdomain')->latest();

        if ($request->filled('kategori')) {
            $q->where('category_id', $request->kategori);
        }
        if ($request->filled('subkategori')) {
            $q->where('subcategory_id', $request->subkategori);
        }

        $permohonan = $q->get();

        $pdf = Pdf::loadView('admin.permohonan.pdf', compact('permohonan'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('permohonan_' . now()->format('Ymd_His') . '.pdf');
    }
}