<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriBuscen;
use App\Models\KategoriGedung;
use App\Models\KategoriHealth;
use App\Models\KategoriKuliner;
use App\Models\KategoriToko;
use App\Models\KategoriTourism;
use App\Models\KategoriOffice;
use App\Models\LevelSekolah;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        KategoriBuscen::create([
            'Kategori'=>'Business Center'
        ]);

        KategoriGedung::create([
            'Kategori'=>'JKS'
        ]);

        KategoriGedung::create([
            'Kategori'=>'DBS'
        ]);

        KategoriGedung::create([
            'Kategori'=>'DES'
        ]);

        KategoriHealth::create([
            'Kategori'=>'Puskesmas'
        ]);

        KategoriHealth::create([
            'Kategori'=>'Klinik'
        ]);

        KategoriHealth::create([
            'Kategori'=>'Rumah Sakit'
        ]);

        KategoriHealth::create([
            'Kategori'=>'Apotek'
        ]);

        KategoriKuliner::create([
            'Kategori'=>'Pujasera'
        ]);

        KategoriKuliner::create([
            'Kategori'=>'Warung'
        ]);

        KategoriKuliner::create([
            'Kategori'=>'Kafe'
        ]);

        KategoriKuliner::create([
            'Kategori'=>'Resto'
        ]);

        KategoriOffice::create([
            'Kategori'=>'Professional'
        ]);

        KategoriOffice::create([
            'Kategori'=>'Property'
        ]);

        KategoriOffice::create([
            'Kategori'=>'Banking'
        ]);

        KategoriOffice::create([
            'Kategori'=>'Finance'
        ]);

        KategoriOffice::create([
            'Kategori'=>'Logistic'
        ]);

        KategoriOffice::create([
            'Kategori'=>'Mining'
        ]);

        KategoriOffice::create([
            'Kategori'=>'Energy'
        ]);

        KategoriOffice::create([
            'Kategori'=>'Transport'
        ]);

        KategoriToko::create([
            'Kategori'=>'Sport & Music'
        ]);

        KategoriToko::create([
            'Kategori'=>'Supermarket'
        ]);

        KategoriToko::create([
            'Kategori'=>'Minimarket'
        ]);

        KategoriToko::create([
            'Kategori'=>'Aksesoris'
        ]);

        KategoriToko::create([
            'Kategori'=>'Fashion'
        ]);

        KategoriToko::create([
            'Kategori'=>'Electronic & Gadget'
        ]);

        KategoriToko::create([
            'Kategori'=>'Mall'
        ]);

        KategoriTourism::create([
            'Kategori'=>'Hotel'
        ]);

        KategoriTourism::create([
            'Kategori'=>'Travel'
        ]);

        KategoriTourism::create([
            'Kategori'=>'Stay House'
        ]);

        KategoriTourism::create([
            'Kategori'=>'Kos-kosan'
        ]);

        LevelSekolah::create([
            'LEVEL'=>'TK'
        ]);

        LevelSekolah::create([
            'LEVEL'=>'SD/MI'
        ]);

        LevelSekolah::create([
            'LEVEL'=>'SMP/MTs'
        ]);

        LevelSekolah::create([
            'LEVEL'=>'SMA/MA/SMK/MAK'
        ]);
    }
}
