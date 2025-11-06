<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Menampilkan produk. Dapat menampilkan semua atau difilter.
     */
    public function index(Request $request): View
    {
        // Ambil parameter filter dari request
        $filterKategori = $request->get('kategori');
        $searchQuery = $request->get('search');
        
        // Query dasar
        $query = Produk::query();

        // Filter berdasarkan pencarian
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('nama_produk', 'like', '%' . $searchQuery . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchQuery . '%');
            });
        }

        $allProduks = $query->get();

        // Filter produk berdasarkan kategori jika ada filter
        if ($filterKategori && $filterKategori !== 'Semua') {
            $makanan = $filterKategori === 'Makanan' ? $allProduks->where('kategori', 'Makanan') : collect();
            $minuman = $filterKategori === 'Minuman' ? $allProduks->where('kategori', 'Minuman') : collect();
        } else {
            // Tampilkan semua jika tidak ada filter atau filter "Semua"
            $makanan = $allProduks->where('kategori', 'Makanan');
            $minuman = $allProduks->where('kategori', 'Minuman');
        }

        // Ambil daftar unik kategori untuk dropdown filter
        $kategoris = Produk::select('kategori')->distinct()->get();

        return view('produk', [
            'makanan' => $makanan,
            'minuman' => $minuman,
            'kategoris' => $kategoris,
            'filterKategori' => $filterKategori,
            'searchQuery' => $searchQuery
        ]);
    }

    /**
     * Menampilkan form edit produk
     */
    public function edit(Produk $produk)
    {
        // Cek apakah user adalah admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('produk')->with('error', 'Anda tidak memiliki akses untuk mengedit produk.');
        }

        return view('edit-produk', compact('produk'));
    }

    /**
     * Update produk
     */
  
    public function update(Request $request, Produk $produk)
    {
        // Cek apakah user adalah admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('produk')->with('error', 'Anda tidak memiliki akses untuk mengedit produk.');
        }
    
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|in:Makanan,Minuman',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            $data = [
                'nama_produk' => $request->nama_produk,
                'kategori' => $request->kategori,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
            ];
        
            // Handle upload gambar jika ada
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($produk->gambar) {
                    // Cek apakah gambar ada di storage
                    $oldImagePath = public_path($produk->gambar);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                // Simpan gambar baru
                $gambar = $request->file('gambar');
                $gambarName = time() . '_' . $gambar->getClientOriginalName();
                $gambarPath = 'images/' . $gambarName;
                
                // Pindahkan gambar ke folder public/images
                $gambar->move(public_path('images'), $gambarName);
                $data['gambar'] = $gambarPath;
            }
        
            $produk->update($data);
        
            return redirect()->route('produk')->with('success', 'Produk berhasil diperbarui!');
        
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus produk
     */
    public function destroy(Produk $produk)
    {
        // Cek apakah user adalah admin
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('produk')->with('error', 'Anda tidak memiliki akses untuk menghapus produk.');
        }

        try {
            // Hapus gambar jika ada
            if ($produk->gambar && Storage::exists($produk->gambar)) {
                Storage::delete($produk->gambar);
            }

            $produk->delete();

            return redirect()->route('produk')->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('produk')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}