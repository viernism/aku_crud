<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriHealth;
use App\Models\Health;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HealthExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HealthController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $healths = Health::with('kategorihealth');

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $healths->where(function($query) use ($search) {
                $query->where('NAMA', 'like', '%' . $search . '%')
                    ->orWhere('AM', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

         // filter by am
        if ($request->has('filter-am')) {
            $filterAm = $request->input('filter-am');
            if (!empty($filterAm)) {
                $healths->where('AM', $filterAm);
            }
        }

        $healths = $healths->paginate($length);

        $kategoris=KategoriHealth::all();
        // Call the firstItem() method on the $healths variable
        $firstItem = $healths->firstItem();

        $ams = Health::distinct('AM')->pluck('AM')->toArray();
        return view('pages.table.table-health', compact('healths', 'firstItem','kategoris', 'ams'));
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

    public function update(Request $request, $healthId)
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

        $health = new Health;
        $health = Health::find($healthId);
        $health->NAMA=$validatedData['NAMA'];
        $health->KATEGORI=$validatedData['KATEGORI'];
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

        return redirect()->back()->with('success', 'Health updated successfully.');
    }

    public function destroy( $healthId){
        $health = Health::find($healthId);
        if (!$health) {
            return redirect()->back()->with('error', 'Health not found.');
        }

        $health->delete();

        return redirect()->back()->with('success', 'Health deleted successfully.');
    }

    public function exportexcel(){
        return Excel::download(new HealthExport,'datahealth.xlsx');
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

                $healths = new Collection();
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
                        $health = [];
                        foreach ($headers as $i => $header) {
                            if (isset($fieldMap[$header])) {
                                $health[$fieldMap[$header]] = $row[$i];
                            }
                        }

                        // Add the row data to the collection
                        $healths->push($health);

                        // Extract the category from the row data
                        $kategori = [
                            'Kategori' => isset($health['KATEGORI']) ? $health['KATEGORI'] : '',
                        ];

                        // Check if the category already exists in the database
                        $existingKategori = KategoriHealth::where('Kategori', $kategori['Kategori'])->first();
                        if ($existingKategori) {
                            // Use the existing category ID
                            $health['KATEGORI'] = $existingKategori->id;
                        } else {
                            // Add the category to the collection
                            $kategoris->push($kategori);
                        }
                    }
                }

                // Insert the data into the database
                KategoriHealth::insert($kategoris->toArray()); // Insert new categories first
                Health::insert($healths->toArray());

                return redirect()->back()->with('success', 'Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
 }
