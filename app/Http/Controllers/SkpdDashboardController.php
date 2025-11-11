<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;

class SkpdDashboardController extends Controller
{
    public function index()
    {
        // Ambil user SKPD yang sedang login
        $user = Auth::user();

        // Ambil semua permohonan milik user SKPD ini
        $permohonan = Permohonan::where('skpd_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total permohonan/subdomain
        $totalSubdomain = $permohonan->count();

        // Hitung subdomain yang disetujui
        $subdomainAktif = $permohonan->where('status', 'disetujui')->count();

        // Hitung permohonan yang masih menunggu
        $permohonanMenunggu = $permohonan->where('status', 'menunggu')->count();

        // Kirim semua data ke tampilan dashboard
        return view('skpd.layouts.wrapper', [
            'content' => 'skpd.dashboard.index',
            'totalSubdomain' => $totalSubdomain,
            'subdomainAktif' => $subdomainAktif,
            'permohonanMenunggu' => $permohonanMenunggu,
            'riwayat' => $permohonan,
            'user' => $user,
        ]);
    }
}
