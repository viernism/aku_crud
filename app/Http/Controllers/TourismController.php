<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\KategoriTourism;
use App\Models\Tourism;
use App\Exports\TourismExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TourismController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $tourisms = Tourism::with('kategoritourism');

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $tourisms->where(function($query) use ($search) {
                $query->where('NAMA', 'like', '%' . $search . '%')
                    ->orWhere('AM', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

         // filter by am
        if ($request->has('filter-am')) {
            $filterAm = $request->input('filter-am');
            if (!empty($filterAm)) {
                $tourisms->where('AM', $filterAm);
            }
        }

        $tourisms = $tourisms->paginate($length);

        $kategoris=KategoriTourism::all();
        // Call the firstItem() method on the $tourisms variable
        $firstItem = $tourisms->firstItem();

        $ams = Tourism::distinct('AM')->pluck('AM')->toArray();
        return view('pages.table-tourism', compact('tourisms', 'firstItem','kategoris', 'ams'));
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


    public function exportexcel(){
        return Excel::download(new TourismExport,'datatourism.xlsx');
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

                $tourisms = new Collection();
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
                        $tourism = [];
                        foreach ($headers as $i => $header) {
                            if (isset($fieldMap[$header])) {
                                $tourism[$fieldMap[$header]] = $row[$i];
                            }
                        }

                        // Add the row data to the collection
                        $tourisms->push($tourism);

                        // Extract the category from the row data
                        $kategori = [
                            'Kategori' => isset($tourism['KATEGORI']) ? $tourism['KATEGORI'] : '',
                        ];

                        // Check if the category already exists in the database
                        $existingKategori = KategoriTourism::where('Kategori', $kategori['Kategori'])->first();
                        if ($existingKategori) {
                            // Use the existing category ID
                            $tourism['KATEGORI'] = $existingKategori->id;
                        } else {
                            // Add the category to the collection
                            $kategoris->push($kategori);
                        }
                    }
                }

                // Insert the data into the database
                KategoriTourism::insert($kategoris->toArray()); // Insert new categories first
                Tourism::insert($tourisms->toArray());

                return redirect()->back()->with('success', 'Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
}
