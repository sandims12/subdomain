<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AdminTemplateController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->get(); // tampilkan semua file
        return view('admin.template.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|mimes:pdf,doc,docx|max:2048'
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('public/templates');

                Template::create([
                    'nama_file' => $file->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }

        Alert::success('Berhasil!', 'Template surat berhasil diunggah tanpa menimpa file lama.');
        return back();
    }
}
