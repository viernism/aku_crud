<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\LevelSekolah;
use App\Exports\SekolahExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        return view('pages.table-sekolah', compact('sekolahs', 'firstItem', 'levels', 'ams'));
    }

    public function store(Request $request)
    {
        // validate the form data
        $validatedData = $request->validate([
            'nama' => 'required',
            'LEVEL' => 'required',
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
            'LEVEL' => $validatedData['LEVEL'],
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
        $validatedData = $request->validate([
            'NAMA' => 'required',
            'LEVEL' => 'required',
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
        $sekolah->LEVEL = $validatedData['LEVEL'];
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


    public function exportexcel(){
        return Excel::download(new SekolahExport,'datasekolah.xlsx');
    }

    public function importexcel(Request $request)
    {
            $request->validate([
                'upexcel' => 'required|mimes:xlsx',
            ]);

            $file = $request->file('upexcel');

            try {
                $import = Excel::toCollection(null, $file)[0];

                // Store the Excel file in the storage
                $filename = $file->getClientOriginalName();
                $file->storeAs('excel', $filename);

                $sekolahs = new Collection();
                $levels = new Collection();

                // Get the headers
                $headers = $import->shift()->toArray();

                // Map the headers to database fields
                $fieldMap = [
                    'NAMA' => 'NAMA',
                    'LEVEL' => 'LEVEL',
                    'ALAMAT' => 'ALAMAT',
                    'KOORDINAT' => 'KOORDINAT',
                    'TEL_CUST' => 'TEL_CUST',
                    'PIC_CUST' => 'PIC_CUST',
                    'AM' => 'AM',
                    'TEL_AM' => 'TEL_AM',
                    'STO' => 'STO',
                    'HERO' => 'HERO',
                    'TEL_HERO' => 'TEL_HERO',
                ];

                foreach ($import as $row) {
                    // Validate the row data
                    if (!empty($row[0]) && is_string($row[0])) {

                        // Map the row data to database fields
                        $sekolah = [];
                        foreach ($headers as $i => $header) {
                            if (isset($fieldMap[$header])) {
                                $sekolah[$fieldMap[$header]] = $row[$i];
                            }
                        }

                        // Add the row data to the collection
                        $sekolahs->push($sekolah);

                        // Extract the category from the row data
                        $level = [
                            'LEVEL' => isset($sekolah['LEVEL']) ? $sekolah['LEVEL'] : '',
                        ];

                        // Check if the category already exists in the database
                        $existingLEVEL = LEVELSekolah::where('LEVEL', $level['LEVEL'])->first();
                        if ($existingLEVEL) {
                            // Use the existing category ID
                            $sekolah['LEVEL'] = $existingLEVEL->id;
                        } else {
                            // Add the category to the collection
                            $levels->push($level);
                        }
                    }
                }

                // Insert the data into the database
                LEVELSekolah::insert($levels->toArray()); // Insert new categories first
                Sekolah::insert($sekolahs->toArray());

                return redirect()->back()->with('success', 'Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
}

