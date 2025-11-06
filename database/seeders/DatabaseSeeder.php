<?php

use Database\Seeders\kategori;
use Database\Seeders\pesan;
use Database\Seeders\produk;
use Database\Seeders\produkseed;
use Database\Seeders\ulasan;
use Database\Seeders\users;
use Illuminate\Database\Seeder; // Note: Use Illuminate\Database\Seeder in older Laravel versions, but HasFactory is more modern
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            kategori::class,
            users::class,
            produkseed::class,
            ulasan::class,
            pesan::class,
        ]);
    }
}