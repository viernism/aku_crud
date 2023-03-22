<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBuscen;
use App\Models\Buscen;

class BuscenController extends Controller
{
    public function index()
    {
        $buscens = Buscen::with('kategoribuscen')->paginate(5);

        $kategoris=KategoriBuscen::all();
        // Call the firstItem() method on the $buscens variable
        $firstItem = $buscens->firstItem();

        return view('pages.table-buscen', compact('buscens', 'firstItem','kategoris'));
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
        Buscen::create ([
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

        return redirect('/tabel/buscen')->with('success', 'Buscen facility added successfully.');
    }

    public function update(Request $request, $buscenId)
    {
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

        $buscen = new Buscen;
        $buscen = Buscen::find($buscenId);
        $buscen->NAMA=$validatedData['NAMA'];
        $buscen->KATEGORI=$validatedData['KATEGORI'];
        $buscen->ALAMAT=$validatedData['ALAMAT'];
        $buscen->KOORDINAT=$validatedData['KOORDINAT'];
        $buscen->TEL_CUST=$validatedData['TEL_CUST'];
        $buscen->PIC_CUST=$validatedData['PIC_CUST'];
        $buscen->AM=$validatedData['AM'];
        $buscen->TEL_AM=$validatedData['TEL_AM'];
        $buscen->STO=$validatedData['STO'];
        $buscen->HERO=$validatedData['HERO'];
        $buscen->TEL_HERO=$validatedData['TEL_HERO'];
        $buscen->save();

        return redirect()->back()->with('success', 'Buscen updated successfully.');
    }

    public function destroy( $buscenId)
    {
        $buscen = Buscen::find($buscenId);
        if (!$buscen) {
            return redirect()->back()->with('error', 'Buscen not found.');
        }

        $buscen->delete();

        return redirect()->back()->with('success', 'Buscen deleted successfully.');
    }
}
