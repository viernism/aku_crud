<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriTourism;
use App\Models\Tourism;

class TourismController extends Controller
{
    public function index()
    {
        $tourisms = Tourism::with('kategoritourism')->paginate(5);
        $kategoris=KategoriTourism::all();

        // Call the firstItem() method on the $tourisms variable
        $firstItem = $tourisms->firstItem();

        return view('pages.table-tourism', compact('tourisms', 'firstItem','kategoris'));
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
        Tourism::create ([
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

        return redirect('/tabel/tourism')->with('success', 'Tourism added successfully.');
    }

    public function update(Request $request, $tourismId){


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

        $tourism = new Tourism;
        $tourism=Tourism::findorfail($tourismId);
        $tourism->NAMA=$validatedData['NAMA'];
        $tourism->KATEGORI=$validatedData['KATEGORI'];
        $tourism->ALAMAT=$validatedData['ALAMAT'];
        $tourism->KOORDINAT=$validatedData['KOORDINAT'];
        $tourism->TEL_CUST=$validatedData['TEL_CUST'];
        $tourism->PIC_CUST=$validatedData['PIC_CUST'];
        $tourism->AM=$validatedData['AM'];
        $tourism->TEL_AM=$validatedData['TEL_AM'];
        $tourism->STO=$validatedData['STO'];
        $tourism->HERO=$validatedData['HERO'];
        $tourism->TEL_HERO=$validatedData['TEL_HERO'];
        $tourism->save();

        return redirect()->back()->with('success', 'Tourism updated successfully.');
    }

    public function destroy( $tourismId){
        $tourism = Tourism::find($tourismId);
        if (!$tourism) {
            return redirect()->back()->with('error', 'Tourism not found.');
        }

        $tourism->delete();

        return redirect()->back()->with('success', 'Tourism deleted successfully.');
    }
}
