<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKuliner;
use App\Models\Kuliner;

class KulinerController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $kuliners = Kuliner::with('kategorikuliner');

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $kuliners->where(function($query) use ($search) {
                $query->where('NAMA', 'like', '%' . $search . '%')
                    ->orWhere('AM', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

         // filter by am
        if ($request->has('filter-am')) {
            $filterAm = $request->input('filter-am');
            if (!empty($filterAm)) {
                $kuliners->where('AM', $filterAm);
            }
        }

        $kuliners = $kuliners->paginate($length);

        $kategoris=KategoriKuliner::all();
        // Call the firstItem() method on the $kuliners variable
        $firstItem = $kuliners->firstItem();

        $ams = Kuliner::distinct('AM')->pluck('AM')->toArray();
        return view('pages.table-kuliner', compact('kuliners', 'firstItem','kategoris', 'ams'));
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
        Kuliner::create ([
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

        return redirect('/tabel/kuliner')->with('success', 'Kuliner facility added successfully.');
    }

    public function update(Request $request, $kulinerId)
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

        $kuliner = new Kuliner;
        $kuliner = Kuliner::find($kulinerId);
        $kuliner->NAMA=$validatedData['NAMA'];
        $kuliner->KATEGORI=$validatedData['KATEGORI'];
        $kuliner->ALAMAT=$validatedData['ALAMAT'];
        $kuliner->KOORDINAT=$validatedData['KOORDINAT'];
        $kuliner->TEL_CUST=$validatedData['TEL_CUST'];
        $kuliner->PIC_CUST=$validatedData['PIC_CUST'];
        $kuliner->AM=$validatedData['AM'];
        $kuliner->TEL_AM=$validatedData['TEL_AM'];
        $kuliner->STO=$validatedData['STO'];
        $kuliner->HERO=$validatedData['HERO'];
        $kuliner->TEL_HERO=$validatedData['TEL_HERO'];
        $kuliner->save();

        return redirect()->back()->with('success', 'Kuliner updated successfully.');
    }

    public function destroy( $kulinerId){
        $kuliner = Kuliner::find($kulinerId);
        if (!$kuliner) {
            return redirect()->back()->with('error', 'Kuliner not found.');
        }

        $kuliner->delete();

        return redirect()->back()->with('success', 'Kuliner deleted successfully.');
    }
 }
