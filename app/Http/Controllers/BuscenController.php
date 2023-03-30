<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBuscen;
use App\Models\Buscen;

class BuscenController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $buscens = Buscen::with('kategoribuscen');

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $buscens->where(function($query) use ($search) {
                $query->where('NAMA', 'like', '%' . $search . '%')
                    ->orWhere('AM', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

         // filter by am
        if ($request->has('filter-am')) {
            $filterAm = $request->input('filter-am');
            if (!empty($filterAm)) {
                $buscens->where('AM', $filterAm);
            }
        }

        $buscens = $buscens->paginate($length);

        $kategoris=KategoriBuscen::all();
        // Call the firstItem() method on the $buscens variable
        $firstItem = $buscens->firstItem();

        $ams = Buscen::distinct('AM')->pluck('AM')->toArray();
        return view('pages.table-buscen', compact('buscens', 'firstItem','kategoris', 'ams'));
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
