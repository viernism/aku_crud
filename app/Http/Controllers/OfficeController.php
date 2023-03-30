<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriOffice;
use App\Models\Office;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $offices = Office::with('kategorioffice');

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $offices->where(function($query) use ($search) {
                $query->where('NAMA', 'like', '%' . $search . '%')
                    ->orWhere('AM', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

         // filter by am
        if ($request->has('filter-am')) {
            $filterAm = $request->input('filter-am');
            if (!empty($filterAm)) {
                $offices->where('AM', $filterAm);
            }
        }

        $offices = $offices->paginate($length);

        $kategoris=KategoriOffice::all();
        // Call the firstItem() method on the $offices variable
        $firstItem = $offices->firstItem();

        $ams = Office::distinct('AM')->pluck('AM')->toArray();
        return view('pages.table-office', compact('offices', 'firstItem','kategoris', 'ams'));
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

        return redirect('/tabel/office')->with('success', 'Office added successfully.');
    }

    public function update(Request $request, $officeId){


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

        $office = new Office;
        $office=Office::findorfail($officeId);
        $office->NAMA=$validatedData['NAMA'];
        $office->KATEGORI=$validatedData['KATEGORI'];
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

        return redirect()->back()->with('success', 'Office updated successfully.');
    }

    public function destroy( $officeId){
        $office = Office::find($officeId);
        if (!$office) {
            return redirect()->back()->with('error', 'Office not found.');
        }

        $office->delete();

        return redirect()->back()->with('success', 'Office deleted successfully.');
    }
}
