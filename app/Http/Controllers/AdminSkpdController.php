<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminSkpdController extends Controller
{
    /**
     * Menampilkan halaman Data SKPD
     */
        private array $kedinasanOptions = [
        'Dinas Pendidikan',
        'Dinas Kesehatan',
        'Dinas PUPR',
        'Dinas Perhubungan',
        'Sekretariat Daerah',
    ];

    public function index()
    {
        $skpd = User::where('role', 'skpd')->latest()->get(); // Ambil data SKPD berdasarkan role
        return view('admin.skpd.index', compact('skpd'));
    }

    /**
     * Menampilkan form untuk tambah SKPD
     */
    public function create()
    {
        $kedinasan = $this->kedinasanOptions;
        return view('admin.skpd.create', compact('kedinasan'));
    }

    /**
     * Menyimpan data SKPD yang baru
     */
public function store(Request $request)
{
    $request->validate([
        'kedinasan' => [
            'required',
            function ($attribute, $value, $fail) {
                // hitung berapa akun skpd untuk kedinasan ini
                $count = User::where('role', 'skpd')
                    ->where('kedinasan', $value)
                    ->count();

                if ($count >= 2) {
                    $fail('Kedinasan ini sudah memiliki 2 akun SKPD.');
                }
            },
        ],
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'kedinasan' => $request->kedinasan,
        'name'      => $request->name,
        'email'     => $request->email,
        'password'  => Hash::make($request->password),
        'role'      => 'skpd',
    ]);

    Alert::success('Berhasil', 'SKPD berhasil ditambahkan!');
    return redirect()->route('admin.skpd.index');
}


    /**
     * Menampilkan form untuk edit SKPD
     */
public function edit($id)
{
    $skpd = User::findOrFail($id);
    $kedinasan = $this->kedinasanOptions;

    return view('admin.skpd.edit', compact('skpd', 'kedinasan'));
}


    /**
     * Mengupdate data SKPD
     */
public function update(Request $request, $id)
{
    $skpd = User::findOrFail($id);

    $request->validate([
        'kedinasan' => [
            'required',
            function ($attribute, $value, $fail) use ($skpd) {
                $query = User::where('role', 'skpd')
                    ->where('kedinasan', $value)
                    ->where('id', '!=', $skpd->id); // jangan hitung diri sendiri

                if ($query->count() >= 2) {
                    $fail('Kedinasan ini sudah memiliki 2 akun SKPD.');
                }
            },
        ],
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $skpd->id,
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    $skpd->kedinasan = $request->kedinasan;
    $skpd->name = $request->name;
    $skpd->email = $request->email;

    if ($request->filled('password')) {
        $skpd->password = Hash::make($request->password);
    }

    $skpd->save();

    Alert::success('Berhasil', 'Data SKPD berhasil diperbarui!');
    return redirect()->route('admin.skpd.index');
}


    /**
     * Menghapus data SKPD
     */
    public function destroy($id)
    {
        $skpd = User::findOrFail($id); // Ambil data SKPD berdasarkan ID
        $skpd->delete(); // Hapus data SKPD

        // Menampilkan pesan sukses
        Alert::success('Berhasil', 'Akun SKPD berhasil dihapus!');
        return redirect()->route('admin.skpd.index'); // Kembali ke daftar SKPD
    }
}
