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
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        KategoriBuscen::insert([
            ['Kategori'=>'Business Center']
        ]);

        KategoriGedung::insert([
            ['Kategori'=>'JKS'],
            ['Kategori'=>'DBS'],
            ['Kategori'=>'DES']
        ]);

        KategoriHealth::insert([
            ['Kategori'=>'Apotek'],
            ['Kategori'=>'Klinik'],
            ['Kategori'=>'Puskesmas'],
            ['Kategori'=>'Rumah Sakit'],
        ]);

        KategoriKuliner::insert([
            ['Kategori'=>'Kafe'],
            ['Kategori'=>'Resto'],
            ['Kategori'=>'Warung'],
            ['Kategori'=>'Pujasera'],
        ]);

        KategoriOffice::insert([
            ['Kategori'=>'Mining'],
            ['Kategori'=>'Energy'],
            ['Kategori'=>'Banking'],
            ['Kategori'=>'Finance'],
            ['Kategori'=>'Property'],
            ['Kategori'=>'Logistic'],
            ['Kategori'=>'Transport'],
            ['Kategori'=>'Professional'],
        ]);

        KategoriToko::insert([
            ['Kategori'=>'Mall'],
            ['Kategori'=>'Fashion'],
            ['Kategori'=>'Aksesoris'],
            ['Kategori'=>'Minimarket'],
            ['Kategori'=>'Supermarket'],
            ['Kategori'=>'Sport & Music'],
            ['Kategori'=>'Electronic & Gadget'],
        ]);

        KategoriTourism::insert([
            ['Kategori'=>'Hotel'],
            ['Kategori'=>'Travel'],
            ['Kategori'=>'Kos-kosan'],
            ['Kategori'=>'Stay House'],
        ]);

        LevelSekolah::insert([
            ['LEVEL'=>'TK'],
            ['LEVEL'=>'SD/MI'],
            ['LEVEL'=>'SMP/MTs'],
            ['LEVEL'=>'SMA/MA/SMK/MAK']
        ]);

        $user=User::insert([
            [
                'name'=>'Admin',
                'username'=>'Admin',
                'email'=>'admin@crud.test',
                'password'=>Hash::make("4dM1nistrat0r")
            ],
            [
                'name'=>'test user',
                'username'=>'testuser',
                'email'=>'testuser@crud.test',
                'password'=>Hash::make("!mT35tUs3R")
            ]
        ]);

        Permission::insert([
            [
                'name'=>'CRUD',
                'guard_name'=>'web'
            ]
        ]);

        Role::insert([
            [
                'name'=>'Administrator',
                'guard_name'=>'web'
            ],
            [
                'name'=>'AM',
                'guard_name'=>'web'
            ]
        ]);

        $role=Role::first();
        $role->givePermissionTo('CRUD');

        $role=Role::find(2);
        $role->givePermissionTo('CRUD');

        $user=User::first();
        $user->assignRole('Administrator');

        $user=User::find(2);
        $user->assignRole('AM');
    }
}