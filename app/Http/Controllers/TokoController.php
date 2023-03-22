<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriToko;
use App\Models\Toko ;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::with('kategoritoko')->paginate(5);
        $kategoris=KategoriToko::all();

        // Call the firstItem() method on the $tokos variable
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

    public function update(Request $request, $tokoId){


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

        $toko = new Toko;
        $toko=Toko::findorfail($tokoId);
        $toko->NAMA=$validatedData['NAMA'];
        $toko->KATEGORI=$validatedData['KATEGORI'];
        $toko->ALAMAT=$validatedData['ALAMAT'];
        $toko->KOORDINAT=$validatedData['KOORDINAT'];
        $toko->TEL_CUST=$validatedData['TEL_CUST'];
        $toko->PIC_CUST=$validatedData['PIC_CUST'];
        $toko->AM=$validatedData['AM'];
        $toko->TEL_AM=$validatedData['TEL_AM'];
        $toko->STO=$validatedData['STO'];
        $toko->HERO=$validatedData['HERO'];
        $toko->TEL_HERO=$validatedData['TEL_HERO'];
        $toko->save();

        return redirect()->back()->with('success', 'Tourism updated successfully.');
    }

    public function destroy( $tokoId){
        $toko = Toko::find($tokoId);
        if (!$toko) {
            return redirect()->back()->with('error', 'Toko not found.');
        }

        $toko->delete();

        return redirect()->back()->with('success', 'Toko deleted successfully.');
    }
}
