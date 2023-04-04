<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\KategoriBuscen;
use App\Models\Buscen;
use App\Exports\BuscenExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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


    public function exportexcel(){
        return Excel::download(new BuscenExport,'databuscen.xlsx');
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

                $buscens = new Collection();
                $kategoris = new Collection();

                // Get the headers
                $headers = $import->shift()->toArray();

                // Map the headers to database fields
                $fieldMap = [
                    'NAMA' => 'NAMA',
                    'KATEGORI' => 'KATEGORI',
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
                        $buscen = [];
                        foreach ($headers as $i => $header) {
                            if (isset($fieldMap[$header])) {
                                $buscen[$fieldMap[$header]] = $row[$i];
                            }
                        }

                        // Add the row data to the collection
                        $buscens->push($buscen);

                        // Extract the category from the row data
                        $kategori = [
                            'Kategori' => isset($buscen['KATEGORI']) ? $buscen['KATEGORI'] : '',
                        ];

                        // Check if the category already exists in the database
                        $existingKategori = KategoriBuscen::where('Kategori', $kategori['Kategori'])->first();
                        if ($existingKategori) {
                            // Use the existing category ID
                            $buscen['KATEGORI'] = $existingKategori->id;
                        } else {
                            // Add the category to the collection
                            $kategoris->push($kategori);
                        }
                    }
                }

                // Insert the data into the database
                KategoriBuscen::insert($kategoris->toArray()); // Insert new categories first
                Buscen::insert($buscens->toArray());

                return redirect()->back()->with('success', 'Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
}
