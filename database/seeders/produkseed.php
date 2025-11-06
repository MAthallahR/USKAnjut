<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class produkseed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define an array for Produk data, currently blank as requested.
        $produks = [
             [
                 'nama_produk' => 'Nasi Putih',
                 'kategori' => 'Makanan',
                 'harga' => 3000,
                 'deskripsi' => 'Karbohidrat utama yang berfungsi sebagai sumber energi utama bagi tubuh',
                 'gambar' => 'images/nasi_putih.jpg',
                 'updated_at' => now(),
                 'created_at' => now(),
            ],
            [
                'nama_produk' => 'Nasi Goreng',
                'kategori' => 'Makanan',
                'harga' => 15000,
                'deskripsi' => 'Nasi yang digoreng dan dicampur dalam minyak goreng, margarin, atau mentega. Biasanya ditambah dengan kecap manis, bawang merah, bawang putih, lada, dan bahan yang lainnya; seperti telur, daging ayam, dan kerupuk.',
                'gambar' => 'images/nasi_goreng.jpg',
            ],
            [
                'nama_produk' => 'Aqua',
                'kategori' => 'Minuman',
                'harga' => 2000,
                'deskripsi' => 'merek air minum dalam kemasan atau air mineral',
                'gambar' => 'images/aqua.jpg',
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }
    }
}