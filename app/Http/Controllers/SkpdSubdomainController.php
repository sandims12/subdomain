<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subdomain;

class SkpdSubdomainController extends Controller
{
    /**
     * Tampilkan daftar subdomain milik SKPD yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil hanya subdomain yang dimiliki user SKPD ini
        $subdomain = Subdomain::where('skpd_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik
        $total    = $subdomain->count();
        $aktif    = $subdomain->where('kondisi', 'aktif')->count();
        $nonaktif = $subdomain->where('kondisi', 'nonaktif')->count();
        $error    = $subdomain->where('kondisi', 'error')->count();

        // Pakai wrapper SKPD seperti halaman lain
        return view('skpd.layouts.wrapper', [
            'content'   => 'skpd.subdomain.index',
            'subdomain' => $subdomain,
            'total'     => $total,
            'aktif'     => $aktif,
            'nonaktif'  => $nonaktif,
            'error'     => $error,
        ]);
    }
}
