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
            'alamat' => 'nullable',
            'koordinat' => 'nullable',
            'tel_cust' => 'nullable',
            'pic_cust' => 'nullable',
            'am' => 'nullable',
            'tel_am' => 'nullable',
            'sto' => 'nullable',
            'hero' => 'nullable',
            'tel_hero' => 'nullable',
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

        return redirect('/tabel/health')->with('success', 'Data added successfully.');
    }

    public function update(Request $request, $healthId)
    {

        if ($request->isMethod('post')) {
            $data=$request->all();
            $health = Health::find($healthId);
            $health->NAMA = $data['NAMA'];
            $health->ALAMAT = $data['ALAMAT'];
            $health->KOORDINAT = $data['KOORDINAT'];
            $health->TEL_CUST = $data['TEL_CUST'];
            $health->PIC_CUST = $data['PIC_CUST'];
            $health->AM = $data['AM'];
            $health->TEL_AM = $data['TEL_AM'];
            $health->STO = $data['STO'];
            $health->HERO = $data['HERO'];
            $health->TEL_HERO = $data['TEL_HERO'];
            $kategorihealth=KategoriHealth::where('Kategori',$data['KATEGORI'])->first();
            $health->kategorihealth()->associate($kategorihealth);
            $health->update();

            return redirect()->back()->with('success', 'Data updated successfully.');
           }
    }

    public function destroy( $healthId){
        $health = Health::find($healthId);
        if (!$health) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $health->delete();

        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('id');
        Health::whereIn('id', $ids)->delete();
    }

    public function addKategori(Request $request){
        $validatedKategori=$request->validate([
            'Kategori'=>'required'
        ]);

        KategoriHealth::create([
            'Kategori'=>$validatedKategori['Kategori']
        ]);

        return redirect()->back()->with('success', 'Kategori successfully added');
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

                        // Extract the category from the row data
                        $kategori = [
                            'Kategori' => isset($health['KATEGORI']) ? $health['KATEGORI'] : '',
                        ];

                        // Check similar category already exists in the database
                        $similarKategori = KategoriHealth::where('Kategori','like','%'.$kategori['Kategori'].'%')->get();

                        if ($similarKategori->isNotEmpty()) {
                            // Use the existing detected similar category
                            $health['KATEGORI'] = $similarKategori->first()->Kategori;
                        } else {
                            // Add the category to the collection
                            $kategoris->push($kategori);
                        }

                        //check to prevent duplicated row also update 
                        $existingHealth = Health::where('NAMA', $health['NAMA'])->first();
                        if ($existingHealth) {
                            //update existing data
                            $existingHealth->update($health);
                        }
                        else {
                            $healths->push($health);
                        }

                    }
                }

                // Insert the data into the database
                KategoriHealth::insert($kategoris->toArray()); // Insert new categories first
                Health::insert($healths->toArray());

                return redirect()->back()->with('success', 'Data Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
 }
