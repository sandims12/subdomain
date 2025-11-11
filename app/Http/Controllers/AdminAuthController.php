<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function nampilnoregister()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'password' => 'required|min:8|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            're_password' => 'required|same:password',
        ]);

        $adminRoleExists = User::where('role', 'admin')->exists();
        $role = $adminRoleExists ? 'skpd' : 'admin';

        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'role' => $role,
            'password' => Hash::make($request->password),
        ]);

        Alert::success('success', 'Registrasi berhasil! Silakan login.');
        return redirect('/login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            Alert::html(
                'Berhasil Login!',
                '<div style="display:flex;align-items:center;flex-direction:column;">
                    <img src="'.asset('images/Lambang_Kabupaten_Indramayu.png').'" alt="Logo" width="60" style="margin-bottom:10px;">
                    <p style="font-size:15px;margin:0;color:#003399;font-weight:600;">
                        Selamat datang, '.$user->name.'! <br>
                        <span style="font-size:13px;font-weight:400;">Kabupaten Indramayu</span>
                    </p>
                </div>',
                'success'
            )->autoClose(2500);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'skpd') {
                return redirect()->route('skpd.dashboard');
            } else {
                Auth::logout();
                return redirect('/login')->with('loginError', 'Role tidak dikenali!');
            }
        }

        return back()->with('loginError', 'Email atau password salah, silakan coba lagi.');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('login');
    }

    /**
     * 🧩 Ubah Nama Pengguna
     */
    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        Alert::success('Berhasil!', 'Nama pengguna berhasil diperbarui.');

        return back();
    }
}
