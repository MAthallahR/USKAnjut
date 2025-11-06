<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Menampilkan form komentar
     */
    public function index()
    {
        $produks = Produk::all();
        $ulasans = Ulasan::with('produk')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('comment', compact('produks', 'ulasans'));
    }

    /**
     * Menyimpan komentar baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberikan komentar.');
        }

        try {
            Ulasan::create([
                'product_id' => $request->product_id,
                'nama_reviewer' => Auth::user()->nama, // Ambil nama dari user yang login
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]);

            return redirect()->back()->with('success', 'Komentar berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim komentar: ' . $e->getMessage());
        }
    }

    
}