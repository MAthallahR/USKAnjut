<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KontakController extends Controller
{
    /**
     * Menampilkan halaman kontak
     */
    public function index()
    {
        return view('kontak');
    }

    /**
     * Menyimpan pesan dari form kontak
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'pesan' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Simpan pesan ke database
            Pesan::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'pesan' => $request->pesan,
            ]);

            return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan membalasnya secepatnya.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan daftar pesan (untuk admin)
     */
    public function list()
    {
        $pesans = Pesan::orderBy('created_at', 'desc')->get();
        
        return view('admin.pesans', compact('pesans'));
    }
}