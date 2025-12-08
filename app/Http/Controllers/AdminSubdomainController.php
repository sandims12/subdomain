<?php

namespace App\Http\Controllers;

use App\Models\Subdomain;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubdomainExport;

class AdminSubdomainController extends Controller
{
    // LIST (monitoring saja)
    public function index()
    {
        $subdomain = Subdomain::with(['skpd', 'permohonan'])
            ->whereHas('permohonan', function ($q) {
                // hanya tampil kalau status permohonannya BUKAN draft
                $q->where('status', '!=', 'draft');
            })
            ->latest()
            ->get();

        return view('admin.subdomain.index', compact('subdomain'));
    }

    // EXPORT EXCEL
    public function exportExcel()
    {
        return Excel::download(new SubdomainExport, 'data-subdomain.xlsx');
    }

    // ==== TIDAK DIPERBOLEHKAN ====
    public function create()
    {
        abort(403, 'Admin tidak diizinkan membuat subdomain secara manual.');
    }

    public function store(Request $request)
    {
        abort(403, 'Admin tidak diizinkan membuat subdomain secara manual.');
    }

    public function edit($id)
    {
        abort(403, 'Admin tidak diizinkan mengedit subdomain.');
    }

    public function update(Request $request, $id)
    {
        abort(403, 'Admin tidak diizinkan mengedit subdomain.');
    }

    public function destroy($id)
    {
        abort(403, 'Admin tidak diizinkan menghapus subdomain.');
    }
}

