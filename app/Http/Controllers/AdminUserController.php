<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = [
            'title' => 'List user',
            'user' => User::get(),
            'content' => 'admin.user.index'
        ];
         return view('admin.layouts.wrapper', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Create user',
            'content' => 'admin.user.create'
        ];
         return view('admin.layouts.wrapper', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'role'  => 'required',
            'password' => 'required|min:8|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            're_password' => 'required|same:password',
        ]);

        $data['password'] = Hash::make ($data['password']);
        
        User::create($data);
        Alert::success('success', 'data berhasil ditambah');
        return redirect('/admin/user')->with('success','data berhasil ditambah' );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'edit data',
            'user'    => User::find($id),
            'content' => 'admin.user.create'
        ];
         return view('admin.layouts.wrapper', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Mendapatkan informasi pengguna yang sedang login
        $currentUser = Auth::user();
    
        // Memeriksa apakah pengguna yang sedang login sama dengan pengguna yang ingin diubah
        if ($currentUser->id == $id) {
            // Jika iya, kembalikan respons atau ambil tindakan lain sesuai kebutuhan
            Alert::warning('peringatan', 'User yang sedang Login Tidak dapat di edit!');
            return redirect()->back()->with('error', 'Tidak dapat mengedit pengguna yang sedang login.');
        } 
     
        $user = User::find($id);
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            're_password' => 'same:password',
        ]);
    
        if ($request->password != '') {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $user->password;
        }
    
        $user->update($data);
                Alert::success('Sukses', 'User berhasil diubah');

        return redirect('/admin/user')->with('success', 'Data berhasil diedit.');
    }
    

   
    public function destroy(string $id)
{
    // Mendapatkan informasi pengguna yang sedang login
    $currentUser = Auth::user();

    // Memeriksa apakah pengguna yang sedang login sama dengan pengguna yang ingin dihapus
    if ($currentUser->id == $id) {
        // Jika iya, kembalikan respons atau ambil tindakan lain sesuai kebutuhan
        Alert::warning('peringatan', 'User yang sedang Login Tidak dapat di hapus!');
        return redirect()->back()->with('error', 'Tidak dapat menghapus pengguna yang sedang login.');
    }

    // Lanjutkan dengan logika penghapusan pengguna jika pengguna yang sedang login bukan yang dihapus
    $user = User::find($id);
    Alert::info('success', 'Data berhasil dihapus');
    $user->delete();

    return redirect('/admin/user')->with('success', 'Data berhasil dihapus.');
}

}
