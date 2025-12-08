<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Support\Facades\Storage;

class SkpdTemplateController extends Controller
{
    public function index()
    {
        // pisahkan berdasar jenis
        $subdomainTemplates    = Template::where('jenis', 'subdomain')->latest()->get();
        $nonSubdomainTemplates = Template::where('jenis', 'non_subdomain')->latest()->get();

        return view('skpd.template.index', compact('subdomainTemplates', 'nonSubdomainTemplates'));
    }

    public function download($id)
    {
        $template = Template::findOrFail($id);
        return Storage::download($template->path, $template->nama_file);
    }
}
