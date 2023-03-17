<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gedung;

class GedungController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::paginate(5);

        // Call the firstItem() method on the $gedungs variable
        $firstItem = $gedungs->firstItem();

        return view('pages.table-gedung', compact('gedungs', 'firstItem'));
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

        return redirect('/gedung')->with('success', 'Gedung added successfully.');
    }

    public function update(Request $request, $id)
    {
        $gedungs = Gedung::findOrFail($id);

        // Validate the form data
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

        // Update the gedung data in the database
        $gedungs->NAMA = $validatedData['nama'];
        $gedungs->KATEGORI = $validatedData['kategori'];
        $gedungs->ALAMAT = $validatedData['alamat'];
        $gedungs->KOORDINAT = $validatedData['koordinat'];
        $gedungs->TEL_CUST = $validatedData['tel_cust'];
        $gedungs->PIC_CUST = $validatedData['pic_cust'];
        $gedungs->AM = $validatedData['am'];
        $gedungs->TEL_AM = $validatedData['tel_am'];
        $gedungs->STO = $validatedData['sto'];
        $gedungs->HERO = $validatedData['hero'];
        $gedungs->TEL_HERO = $validatedData['tel_hero'];

        // Save the changes to the database
        $gedungs->save();

        return redirect()->back()->with('success', 'Gedung has been updated successfully.');
    }
}
