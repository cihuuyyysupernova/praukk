<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     * Fungsi: Menampilkan form login untuk user yang belum terautentikasi
     * Return: View login.blade.php
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses login user
     * Fungsi: Validasi kredensial dan melakukan autentikasi user
     * @param Request $request - Data form login (email, password, role)
     * Return: Redirect ke dashboard sesuai role atau kembali dengan error
     */
    public function login(Request $request)
    {
        // Validasi input form login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,siswa'
        ]);

        // Coba autentikasi dengan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            // Regenerate session untuk security
            $request->session()->regenerate();

            // Ambil data user yang login
            $user = Auth::user();
            // Redirect ke dashboard sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }

        // Jika gagal login, kembali dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout user
     * Fungsi: Menghapus sesi login dan mengarahkan ke halaman login
     * @param Request $request - Request object untuk session management
     * Return: Redirect ke halaman login
     */
    public function logout(Request $request)
    {
        // Logout user dari sistem
        Auth::logout();
        // Invalidate session untuk security
        $request->session()->invalidate();
        // Regenerate CSRF token
        $request->session()->regenerateToken();
        // Redirect ke halaman login
        return redirect()->route('login');
    }

    /**
     * Menampilkan halaman register
     * Fungsi: Menampilkan form registrasi untuk user baru
     * Return: View register.blade.php
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi user baru
     * Fungsi: Validasi data registrasi dan membuat user baru
     * @param Request $request - Data form registrasi (name, email, password, role)
     * Return: Redirect ke dashboard sesuai role setelah registrasi berhasil
     */
    public function register(Request $request)
    {
        // Validasi input form registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,siswa'
        ]);

        // Buat user baru dengan data yang sudah divalidasi
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hash password untuk security
            'role' => $validated['role'],
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect ke dashboard sesuai role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('siswa.dashboard');
        }
    }

    /**
     * Menampilkan halaman edit profil
     * Fungsi: Menampilkan form edit profil dengan data user yang sedang login
     * Return: View edit-profile.blade.php dengan data user
     */
    public function editProfile()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();
        // Tampilkan form edit profil dengan data user
        return view('auth.edit-profile', compact('user'));
    }

    /**
     * Memproses update profil user
     * Fungsi: Validasi dan memperbarui data profil user (nama, email, password)
     * @param Request $request - Data form edit profil
     * Return: Redirect kembali dengan pesan sukses
     */
    public function updateProfile(Request $request)
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Validasi input form edit profil
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Unik kecuali user ini sendiri
            'password' => 'nullable|string|min:6|confirmed', // Password opsional
        ]);

        // Update nama dan email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password hanya jika diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Simpan perubahan ke database
        $user->save();

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
