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

    $subdomain = Subdomain::with('permohonan')
        ->where('skpd_id', $user->id)
        ->whereHas('permohonan', function ($q) {
            $q->where('status', '!=', 'draft');
        })
        ->latest()
        ->get();

    // Hitung statistik
    $total    = $subdomain->count();
    $aktif    = $subdomain->where('kondisi', 'aktif')->count();
    $nonaktif = $subdomain->where('kondisi', 'nonaktif')->count();
    $error    = $subdomain->where('kondisi', 'error')->count();

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
