<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\KategoriKuliner;
use App\Models\Kuliner;
use App\Exports\KulinerExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        return view('pages.table.table-kuliner', compact('kuliners', 'firstItem','kategoris', 'ams'));
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
        if ($request->isMethod('post')) {
            $data=$request->all();
            $kuliner = Kuliner::find($kulinerId);
            $kuliner->NAMA = $data['NAMA'];
            $kuliner->ALAMAT = $data['ALAMAT'];
            $kuliner->KOORDINAT = $data['KOORDINAT'];
            $kuliner->TEL_CUST = $data['TEL_CUST'];
            $kuliner->PIC_CUST = $data['PIC_CUST'];
            $kuliner->AM = $data['AM'];
            $kuliner->TEL_AM = $data['TEL_AM'];
            $kuliner->STO = $data['STO'];
            $kuliner->HERO = $data['HERO'];
            $kuliner->TEL_HERO = $data['TEL_HERO'];
            $kategorikuliner=KategoriKuliner::where('Kategori',$data['KATEGORI'])->first();
            $kuliner->kategorikuliner()->associate($kategorikuliner);
            $kuliner->update();

            return redirect()->back()->with('success', 'Kuliner updated successfully.');
           }
    }

    public function destroy( $kulinerId){
        $kuliner = Kuliner::find($kulinerId);
        if (!$kuliner) {
            return redirect()->back()->with('error', 'Kuliner not found.');
        }

        $kuliner->delete();

        return redirect()->back()->with('success', 'Kuliner deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('id');
        Kuliner::whereIn('id', $ids)->delete();
    }


    public function exportexcel(){
        return Excel::download(new KulinerExport,'datakuliner.xlsx');
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

                $kuliners = new Collection();
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
                        $kuliner = [];
                        foreach ($headers as $i => $header) {
                            if (isset($fieldMap[$header])) {
                                $kuliner[$fieldMap[$header]] = $row[$i];
                            }
                        }

                        // Add the row data to the collection
                        $kuliners->push($kuliner);

                        // Extract the category from the row data
                        $kategori = [
                            'Kategori' => isset($kuliner['KATEGORI']) ? $kuliner['KATEGORI'] : '',
                        ];

                        // Check if the category already exists in the database
                        $existingKategori = KategoriKuliner::where('Kategori', $kategori['Kategori'])->first();
                        if ($existingKategori) {
                            // Use the existing category ID
                            $kuliner['KATEGORI'] = $existingKategori->id;
                        } else {
                            // Add the category to the collection
                            $kategoris->push($kategori);
                        }
                    }
                }

                // Insert the data into the database
                KategoriKuliner::insert($kategoris->toArray()); // Insert new categories first
                Kuliner::insert($kuliners->toArray());

                return redirect()->back()->with('success', 'Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
 }
