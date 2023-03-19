<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriHealth;
use App\Models\Health;

class HealthController extends Controller
{
    public function index()
    {
        $healths = Health::with('kategorihealth')->paginate(5);
        $kategoris=KategoriHealth::all();
        // Call the firstItem() method on the $healths variable
        $firstItem = $healths->firstItem();

        return view('pages.table-health', compact('healths', 'firstItem','kategoris'));
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
        Health::create ([
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

        return redirect('/tabel/health')->with('success', 'Health facility added successfully.');
    }

    public function update(Request $request, $id){
        $health=Health::findorfail($id);

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

        $health->NAMA=$validatedData['NAMA'];
        $health->LEVEL_ID=$validatedData['KATEGORI'];
        $health->ALAMAT=$validatedData['ALAMAT'];
        $health->KOORDINAT=$validatedData['KOORDINAT'];
        $health->TEL_CUST=$validatedData['TEL_CUST'];
        $health->PIC_CUST=$validatedData['PIC_CUST'];
        $health->AM=$validatedData['AM'];
        $health->TEL_AM=$validatedData['TEL_AM'];
        $health->STO=$validatedData['STO'];
        $health->HERO=$validatedData['HERO'];
        $health->TEL_HERO=$validatedData['TEL_HERO'];
        $health->save();
    }

    public function remove(Health $health){
        $health->delete();
        return redirect()->back()->with('success', 'health deleted successfully.');
    }
}
