<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Support\Facades\Storage;

class SkpdTemplateController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->get();
        return view('skpd.template.index', compact('templates'));
    }

    public function download($id)
    {
        $template = Template::findOrFail($id);
        return Storage::download($template->path, $template->nama_file);
    }
}