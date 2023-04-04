<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\LevelSekolah;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $sekolahs = Sekolah::with('sekolahlevels');

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $sekolahs->where(function($query) use ($search) {
                $query->where('NAMA', 'like', '%' . $search . '%')
                    ->orWhere('AM', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

       // filter by am
        if ($request->has('filter-am')) {
            $filterAm = $request->input('filter-am');
            if (!empty($filterAm)) {
                $sekolahs->where('AM', $filterAm);
            }
        }

        $sekolahs = $sekolahs->paginate($length);

        $levels = LevelSekolah::all();

        // Call the firstItem() method on the $sekolahs variable
        $firstItem = $sekolahs->firstItem();

        $ams = Sekolah::distinct('AM')->pluck('AM')->toArray();
        return view('pages.table.table-sekolah', compact('sekolahs', 'firstItem', 'levels', 'ams'));
    }

    public function store(Request $request)
    {
        // validate the form data
        $validatedData = $request->validate([
            'nama' => 'required',
            'LEVEL_ID' => 'required',
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
        Sekolah::create ([
            'NAMA' => $validatedData['nama'],
            'LEVEL_ID' => $validatedData['LEVEL_ID'],
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

        // $enumValues = Sekolah::getEnumValues('LEVEL');

        return redirect('/tabel/sekolah')->with('success', 'sekolah added successfully.');

        // ->with(['enumValues' => $enumValues])
    }

    public function update(Request $request, $sekolahId)
    {
        // $sekolahId = $request->input('id');
        $validatedData = $request->validate([
            'NAMA' => 'required',
            'LEVEL_ID' => 'required',
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

        $sekolah = new Sekolah;
        $sekolah = Sekolah::find($sekolahId);
        $sekolah->NAMA = $validatedData['NAMA'];
        $sekolah->LEVEL_ID = $validatedData['LEVEL_ID'];
        $sekolah->ALAMAT = $validatedData['ALAMAT'];
        $sekolah->KOORDINAT = $validatedData['KOORDINAT'];
        $sekolah->TEL_CUST = $validatedData['TEL_CUST'];
        $sekolah->PIC_CUST = $validatedData['PIC_CUST'];
        $sekolah->AM = $validatedData['AM'];
        $sekolah->TEL_AM = $validatedData['TEL_AM'];
        $sekolah->STO = $validatedData['STO'];
        $sekolah->HERO = $validatedData['HERO'];
        $sekolah->TEL_HERO = $validatedData['TEL_HERO'];
        $sekolah->save();

        return redirect()->back()->with('success', 'Sekolah updated successfully.');
    }


    public function destroy ($sekolahId)
    {
        $sekolah = Sekolah::find($sekolahId);
        if (!$sekolah) {
            return redirect()->back()->with('error', 'Sekolah not found.');
        }

        $sekolah->delete();

        return redirect()->back()->with('success', 'Sekolah deleted successfully.');
    }
}

