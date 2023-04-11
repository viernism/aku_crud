<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\KategoriToko;
use App\Models\Toko ;
use App\Exports\TokoExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TokoController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $tokos = Toko::with('kategoritoko');

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $tokos->where(function($query) use ($search) {
                $query->where('NAMA', 'like', '%' . $search . '%')
                    ->orWhere('AM', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

         // filter by am
        if ($request->has('filter-am')) {
            $filterAm = $request->input('filter-am');
            if (!empty($filterAm)) {
                $tokos->where('AM', $filterAm);
            }
        }

        $tokos = $tokos->paginate($length);

        $kategoris=KategoriToko::all();
        // Call the firstItem() method on the $tokos variable
        $firstItem = $tokos->firstItem();

        $ams = Toko::distinct('AM')->pluck('AM')->toArray();
        return view('pages.table.table-toko', compact('tokos', 'firstItem','kategoris', 'ams'));
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
        Toko::create ([
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

        return redirect('/tabel/toko')->with('success', 'Toko added successfully.');
    }

    public function update(Request $request, $tokoId){


        if ($request->isMethod('post')) {
            $data=$request->all();
            $toko = Toko::find($tokoId);
            $toko->NAMA = $data['NAMA'];
            $toko->ALAMAT = $data['ALAMAT'];
            $toko->KOORDINAT = $data['KOORDINAT'];
            $toko->TEL_CUST = $data['TEL_CUST'];
            $toko->PIC_CUST = $data['PIC_CUST'];
            $toko->AM = $data['AM'];
            $toko->TEL_AM = $data['TEL_AM'];
            $toko->STO = $data['STO'];
            $toko->HERO = $data['HERO'];
            $toko->TEL_HERO = $data['TEL_HERO'];
            $kategoritoko=KategoriToko::where('Kategori',$data['KATEGORI'])->first();
            $toko->kategoritoko()->associate($kategoritoko);
            $toko->update();

            return redirect()->back()->with('success', 'Toko updated successfully.');
           }
    }

    public function destroy( $tokoId){
        $toko = Toko::find($tokoId);
        if (!$toko) {
            return redirect()->back()->with('error', 'Toko not found.');
        }

        $toko->delete();

        return redirect()->back()->with('success', 'Toko deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('id');
        Toko::whereIn('id', $ids)->delete();
    }

    public function exportexcel(){
        return Excel::download(new TokoExport,'datatoko.xlsx');
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

                $tokos = new Collection();
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
                        $toko = [];
                        foreach ($headers as $i => $header) {
                            if (isset($fieldMap[$header])) {
                                $toko[$fieldMap[$header]] = $row[$i];
                            }
                        }

                        // Add the row data to the collection
                        $tokos->push($toko);

                        // Extract the category from the row data
                        $kategori = [
                            'Kategori' => isset($toko['KATEGORI']) ? $toko['KATEGORI'] : '',
                        ];

                        // Check if the category already exists in the database
                        $existingKategori = KategoriToko::where('Kategori', $kategori['Kategori'])->first();
                        if ($existingKategori) {
                            // Use the existing category ID
                            $toko['KATEGORI'] = $existingKategori->id;
                        } else {
                            // Add the category to the collection
                            $kategoris->push($kategori);
                        }
                    }
                }

                // Insert the data into the database
                KategoriToko::insert($kategoris->toArray()); // Insert new categories first
                Toko::insert($tokos->toArray());

                return redirect()->back()->with('success', 'Imported successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
}
