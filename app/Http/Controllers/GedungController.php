<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\KategoriGedung;
use App\Models\Gedung;
use App\Exports\GedungExport;
// use App\Imports\GedungImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GedungController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $gedungs = Gedung::with('kategorigedung');

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $gedungs->where(function($query) use ($search) {
                $query->where('NAMA', 'like', '%' . $search . '%')
                    ->orWhere('AM', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

         // filter by am
        if ($request->has('filter-am')) {
            $filterAm = $request->input('filter-am');
            if (!empty($filterAm)) {
                $gedungs->where('AM', $filterAm);
            }
        }

        $gedungs = $gedungs->paginate($length);

        $kategoris=KategoriGedung::all();

        // Call the firstItem() method on the $gedungs variable
        $firstItem = $gedungs->firstItem();

        $ams = Gedung::distinct('AM')->pluck('AM')->toArray();
        return view('pages.table.table-gedung', compact('gedungs', 'firstItem','kategoris', 'ams'));
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
        Gedung::create ([
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

        return redirect('/tabel/gedung')->with('success', 'Gedung added successfully.');
    }

    public function update(Request $request, $gedungId)
    {

       if ($request->isMethod('post')) {
        $data=$request->all();
        $gedung = Gedung::find($gedungId);
        $gedung->NAMA = $data['NAMA'];
        $gedung->ALAMAT = $data['ALAMAT'];
        $gedung->KOORDINAT = $data['KOORDINAT'];
        $gedung->TEL_CUST = $data['TEL_CUST'];
        $gedung->PIC_CUST = $data['PIC_CUST'];
        $gedung->AM = $data['AM'];
        $gedung->TEL_AM = $data['TEL_AM'];
        $gedung->STO = $data['STO'];
        $gedung->HERO = $data['HERO'];
        $gedung->TEL_HERO = $data['TEL_HERO'];
        $kategorigedung=KategoriGedung::where('Kategori',$data['KATEGORI'])->first();
        $gedung->kategorigedung()->associate($kategorigedung);
        $gedung->update();

        return redirect()->back()->with('success', 'Gedung updated successfully.');
       }
    }

    public function destroy ($gedungId)
    {
        $gedung = Gedung::find($gedungId);
        if (!$gedung) {
            return redirect()->back()->with('error', 'Gedung not found.');
        }

        $gedung->delete();

        return redirect()->back()->with('success', 'Gedung deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('id');
        Gedung::whereIn('id', $ids)->delete();
    }

    public function addKategori(Request $request){
        $validatedKategori=$request->validate([
            'Kategori'=>'required'
        ]);

        KategoriGedung::create([
            'Kategori'=>$validatedKategori['Kategori']
        ]);

        return redirect()->back()->with('success', 'Kategori successfully added');
    }

    public function exportexcel(){
        return Excel::download(new GedungExport,'datagedung.xlsx');
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

                $gedungs = new Collection();
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
                        $gedung = [];
                        foreach ($headers as $i => $header) {
                            if (isset($fieldMap[$header])) {
                                $gedung[$fieldMap[$header]] = $row[$i];
                            }
                        }

                        //check to prevent duplicated row
                        $existingGedung = Gedung::where('NAMA', $gedung['NAMA'])->first();
                        if ($existingGedung) {
                        // Skip this row since the gedung already exists
                        continue;
                        }

                        // Add the row data to the collection
                        $gedungs->push($gedung);

                        // Extract the category from the row data
                        $kategori = [
                            'Kategori' => isset($gedung['KATEGORI']) ? $gedung['KATEGORI'] : '',
                        ];

                        // Check if the category already exists in the database
                        $existingKategori = KategoriGedung::where('Kategori', $kategori['Kategori'])->first();
                        if ($existingKategori) {
                            // Use the existing category ID
                            $gedung['KATEGORI'] = $existingKategori->id;
                        } else {
                            // Add the category to the collection
                            $kategoris->push($kategori);
                        }
                    }
                }

                // Insert the data into the database
                KategoriGedung::insert($kategoris->toArray()); // Insert new categories first
                Gedung::insert($gedungs->toArray());

                return redirect()->back()->with('success', 'Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
    }
}
