<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriGedung;
use App\Models\Gedung;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::with('kategoritoko')->paginate(5);
        $kategoris=KategoriToko::all();

        // Call the firstItem() method on the $gedungs variable
        $firstItem = $tokos->firstItem();

        return view('pages.table-toko', compact('tokos', 'firstItem','kategoris'));
    }

    public function store(Request $request)
    {
        // validate the form data
        $validatedData = $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'alamat' => 'required',
            'koordinat' => 'required',
            'tel_cust' => 'required',
            'pic_cust' => 'required',
            'am' => 'required',
            'tel_am' => 'required',
            'sto' => 'required',
            'hero' => 'required',
            'tel_hero' => 'required',
        ]);

        //  Create a new data in the db
        Toko::create ([
            'NAMA' => $validatedData['nama'],
            'KATEGORI' => $validatedData['kategori'],
            'ALAMAT' => $validatedData['alamat'],
            'KOORDINAT' => $validatedData['koordinat'],
            'TEL_CUST' => $validatedData['tel_cust'],
            'PIC_CUST' => $validatedData['pic_cust'],
            'AM' => $validatedData['am'],
            'TEL_AM' => $validatedData['tel_am'],
            'STO' => $validatedData['sto'],
            'HERO' => $validatedData['hero'],
            'TEL_HERO' => $validatedData['tel_hero'],
        ]);

        return redirect('/tabel/toko')->with('success', 'Toko added successfully.');
    }

    public function update(Request $request, $id){
        $gedung=Gedung::findorfail($id);

        $validatedData=$request->validate([
            'NAMA' => 'required',
            'KATEGORI' =>'required',
            'ALAMAT' => 'required',
            'KOORDINAT' => 'required',
            'TEL_CUST' => 'required',
            'PIC_CUST' => 'required',
            'AM' => 'required',
            'TEL_AM' => 'required',
            'STO' => 'required',
            'HERO' => 'required',
            'TEL_HERO' => 'required'
        ]);

        $gedung->NAMA=$validatedData['NAMA'];
        $gedung->LEVEL_ID=$validatedData['KATEGORI'];
        $gedung->ALAMAT=$validatedData['ALAMAT'];
        $gedung->KOORDINAT=$validatedData['KOORDINAT'];
        $gedung->TEL_CUST=$validatedData['TEL_CUST'];
        $gedung->PIC_CUST=$validatedData['PIC_CUST'];
        $gedung->AM=$validatedData['AM'];
        $gedung->TEL_AM=$validatedData['TEL_AM'];
        $gedung->STO=$validatedData['STO'];
        $gedung->HERO=$validatedData['HERO'];
        $gedung->TEL_HERO=$validatedData['TEL_HERO'];
        $gedung->save();
    }

    public function remove(Gedung $gedung){
        $gedung->delete();
        return redirect()->back()->with('success', 'Gedung deleted successfully.');
    }
}
