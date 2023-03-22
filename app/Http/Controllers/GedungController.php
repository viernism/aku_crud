<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriGedung;
use App\Models\Gedung;

class GedungController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::with('kategorigedung')->paginate(5);

        $kategoris=KategoriGedung::all();

        // Call the firstItem() method on the $gedungs variable
        $firstItem = $gedungs->firstItem();

        return view('pages.table-gedung', compact('gedungs', 'firstItem','kategoris'));
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
        Gedung::create ([
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

        return redirect('/tabel/gedung')->with('success', 'Gedung added successfully.');
    }

    public function update(Request $request, $gedungId)
    {
        $validatedData = $request->validate([
            'NAMA' => 'required',
            'KATEGORI' => 'required',
            'ALAMAT' => 'required',
            'KOORDINAT' => 'required',
            'TEL_CUST' => 'required',
            'PIC_CUST' => 'required',
            'AM' => 'required',
            'TEL_AM' => 'required',
            'STO' => 'required',
            'HERO' => 'required',
            'TEL_HERO' => 'required',
        ]);

        $gedung = new Gedung;
        $gedung = Gedung::find($gedungId);
        $gedung->NAMA = $validatedData['NAMA'];
        $gedung->KATEGORI = $validatedData['KATEGORI'];
        $gedung->ALAMAT = $validatedData['ALAMAT'];
        $gedung->KOORDINAT = $validatedData['KOORDINAT'];
        $gedung->TEL_CUST = $validatedData['TEL_CUST'];
        $gedung->PIC_CUST = $validatedData['PIC_CUST'];
        $gedung->AM = $validatedData['AM'];
        $gedung->TEL_AM = $validatedData['TEL_AM'];
        $gedung->STO = $validatedData['STO'];
        $gedung->HERO = $validatedData['HERO'];
        $gedung->TEL_HERO = $validatedData['TEL_HERO'];
        $gedung->save();

        return redirect()->back()->with('success', 'Gedung updated successfully.');
    }

    public function destroy ($gedungId)
    {
        $gedung = Gedung::find($gedungId);
        if (!$gedung) {
            return redirect()->back()->with('error', 'Gedung not found.');
        }

        $gedung->delete();

        return redirect()->back()->with('success', 'Gedung deleted successfully.');
    }
}
