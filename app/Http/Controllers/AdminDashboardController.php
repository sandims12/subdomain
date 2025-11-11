<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permohonan;
use App\Models\Subdomain;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung total SKPD (role: skpd)
        $totalSkpd = User::where('role', 'skpd')->count();

        // Hitung total permohonan
        $totalPermohonan = Permohonan::count();

        // Hitung jumlah permohonan berdasarkan status
        $permohonanDisetujui = Permohonan::where('status', 'disetujui')->count();
        $permohonanDitolak = Permohonan::where('status', 'ditolak')->count();
        $permohonanMenunggu = Permohonan::where('status', 'menunggu')->count();

        // Hitung total subdomain (bisa dari tabel Subdomain kalau udah dibuat)
        $totalSubdomain = $permohonanDisetujui;

        // Hitung subdomain aktif (dari tabel subdomain)
        $subdomainAktif = Subdomain::where('kondisi', 'aktif')->count();

        return view('admin.dashboard.index', [
            'totalSkpd' => $totalSkpd,
            'totalPermohonan' => $totalPermohonan,
            'totalSubdomain' => $totalSubdomain,
            'subdomainAktif' => $subdomainAktif,
            'permohonanDisetujui' => $permohonanDisetujui,
            'permohonanDitolak' => $permohonanDitolak,
            'permohonanMenunggu' => $permohonanMenunggu,
        ]);
    }
}
