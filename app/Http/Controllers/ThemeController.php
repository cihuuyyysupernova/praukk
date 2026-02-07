<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ThemeController extends Controller
{
    /**
     * Mengubah tema aplikasi (light/dark)
     * Fungsi: Toggle antara tema terang dan gelap
     * @param Request $request - Request dengan tema yang dipilih
     * Return: Respon JSON untuk AJAX
     */
    public function switch(Request $request)
    {
        $theme = $request->input('theme', 'light');

        // Validasi tema yang diizinkan
        if (!in_array($theme, ['light', 'dark'])) {
            $theme = 'light';
        }

        // Simpan tema di session
        Session::put('theme', $theme);

        // Return JSON response untuk AJAX
        return response()->json([
            'success' => true,
            'theme' => $theme,
            'message' => 'Tema berhasil diubah'
        ]);
    }

    /**
     * Mendapatkan tema saat ini
     * Fungsi: Mengembalikan tema yang sedang aktif
     * Return: Tema saat ini (light/dark)
     */
    public static function getCurrentTheme()
    {
        return Session::get('theme', 'light');
    }
}
