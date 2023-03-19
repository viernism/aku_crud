<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategorioffice;
use App\Models\office;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::with('kategorioffice')->paginate(5);
        $kategoris=KategoriOffice::all();

        // Call the firstItem() method on the $offices variable
        $firstItem = $offices->firstItem();

        return view('pages.table-office', compact('offices', 'firstItem','kategoris'));
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
        Office::create ([
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

        return redirect('/tabel/office')->with('success', 'office added successfully.');
    }

    public function update(Request $request, $id){
        $Office=Office::findorfail($id);

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

        $office->NAMA=$validatedData['NAMA'];
        $office->LEVEL_ID=$validatedData['KATEGORI'];
        $office->ALAMAT=$validatedData['ALAMAT'];
        $office->KOORDINAT=$validatedData['KOORDINAT'];
        $office->TEL_CUST=$validatedData['TEL_CUST'];
        $office->PIC_CUST=$validatedData['PIC_CUST'];
        $office->AM=$validatedData['AM'];
        $office->TEL_AM=$validatedData['TEL_AM'];
        $office->STO=$validatedData['STO'];
        $office->HERO=$validatedData['HERO'];
        $office->TEL_HERO=$validatedData['TEL_HERO'];
        $office->save();
    }

    public function remove(Office $office){
        $office->delete();
        return redirect()->back()->with('success', 'office deleted successfully.');
    }
}
