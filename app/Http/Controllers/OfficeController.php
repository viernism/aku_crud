<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\KategoriOffice;
use App\Models\Office;
use App\Exports\OfficeExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        return view('pages.table.table-office', compact('offices', 'firstItem','kategoris', 'ams'));
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

        return redirect('/tabel/office')->with('success', 'Data added successfully.');
    }

    public function update(Request $request, $officeId){
        if ($request->isMethod('post')) {
            $data=$request->all();
            $office = Office::find($officeId);
            $office->NAMA = $data['NAMA'];
            $office->ALAMAT = $data['ALAMAT'];
            $office->KOORDINAT = $data['KOORDINAT'];
            $office->TEL_CUST = $data['TEL_CUST'];
            $office->PIC_CUST = $data['PIC_CUST'];
            $office->AM = $data['AM'];
            $office->TEL_AM = $data['TEL_AM'];
            $office->STO = $data['STO'];
            $office->HERO = $data['HERO'];
            $office->TEL_HERO = $data['TEL_HERO'];
            $kategorioffice=KategoriOffice::where('Kategori',$data['KATEGORI'])->first();
            $office->kategorioffice()->associate($kategorioffice);
            $office->update();

            return redirect()->back()->with('success', 'Data updated successfully.');
           }
    }

    public function destroy( $officeId){
        $office = Office::find($officeId);
        if (!$office) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        $office->delete();

        return redirect()->back()->with('success', 'Data deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('id');
        Office::whereIn('id', $ids)->delete();
    }

    public function addKategori(Request $request){
        $validatedKategori=$request->validate([
            'Kategori'=>'required'
        ]);

        KategoriOffice::create([
            'Kategori'=>$validatedKategori['Kategori']
        ]);

        return redirect()->back()->with('success', 'Kategori successfully added');
    }


    public function exportexcel(){
        return Excel::download(new OfficeExport,'dataoffice.xlsx');
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

                $offices = new Collection();
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
                        $office = [];
                        foreach ($headers as $i => $header) {
                            if (isset($fieldMap[$header])) {
                                $office[$fieldMap[$header]] = $row[$i];
                            }
                        }

                        // Extract the category from the row data
                        $kategori = [
                            'Kategori' => isset($office['KATEGORI']) ? $office['KATEGORI'] : '',
                        ];

                        // Check similar category already exists in the database
                        $similarKategori = KategoriOffice::where('Kategori','like','%'.$kategori['Kategori'].'%')->get();

                        if ($similarKategori->isNotEmpty()) {
                            // Use the existing detected similar category
                            $office['KATEGORI'] = $similarKategori->first()->Kategori;
                        } else {
                            // Add the category to the collection
                            $kategoris->push($kategori);
                        }

                        //check to prevent duplicated row also update 
                        $existingOffice = Office::where('NAMA', $office['NAMA'])->first();
                        if ($existingOffice) {
                            //update existing data
                            $existingOffice->update($office);
                        }
                        else {
                            $offices->push($office);
                        }

                    }
                }

                // Insert the data into the database
                KategoriOffice::insert($kategoris->toArray()); // Insert new categories first
                Office::insert($offices->toArray());

                return redirect()->back()->with('success', 'Data Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
}
