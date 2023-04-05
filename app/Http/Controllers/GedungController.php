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
        $validatedData = $request->validate([
            'NAMA' => 'required',
            'KATEGORI' => 'required',
            'ALAMAT' => 'nullable',
            'KOORDINAT' => 'nullable',
            'TEL_CUST' => 'nullable',
            'PIC_CUST' => 'nullable',
            'AM' => 'nullable',
            'TEL_AM' => 'nullable',
            'STO' => 'nullable',
            'HERO' => 'nullable',
            'TEL_HERO' => 'nullable',
        ]);

        $gedung = new Gedung;
        $gedung = Gedung::find($gedungId);
        $gedung->NAMA = $validatedData['NAMA'];
        $gedung->KATEGORI = $validatedData['KATEGORI'];
        $gedung->ALAMAT = $validatedData['ALAMAT'];
        $gedung->KOORDINAT = $validatedData['KOORDINAT'];
        $gedung->TEL_CUST = $validatedData['TEL_CUST'];
        $gedung->PIC_CUST = $validatedData['PIC_CUST'];
        $gedung->AM = $validatedData['AM'];
        $gedung->TEL_AM = $validatedData['TEL_AM'];
        $gedung->STO = $validatedData['STO'];
        $gedung->HERO = $validatedData['HERO'];
        $gedung->TEL_HERO = $validatedData['TEL_HERO'];
        $gedung->save();

        return redirect()->back()->with('success', 'Gedung updated successfully.');
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
//     public function importexcel(Request $request)
//     {
//         $request->validate([
//             'upexcel' => 'required|mimes:xlsx',
//         ]);

//         $file = $request->file('upexcel');

//         try {
//             $import = Excel::toCollection(null, $file)[0];

//             // Store the Excel file in the storage
//             $filename = $file->getClientOriginalName();
//             $file->storeAs('excel', $filename);

//             $gedungs = new Collection();
//             $kategoris = new Collection();

//             // Get the headers
//             $headers = $import->shift()->toArray();

//             foreach ($import as $row) {
//                 if (!empty($row[0])) {
//                     $gedung = [
//                         'NAMA' => $row[0],
//                         'KATEGORI' => $row[1],
//                         'ALAMAT' => $row[2],
//                         'KOORDINAT' => $row[3],
//                         'TEL_CUST' => $row[4],
//                         'PIC_CUST' => $row[5],
//                         'AM' => $row[6],
//                         'TEL_AM' => $row[7],
//                         'STO' => $row[8],
//                         'HERO' => $row[9],
//                         'TEL_HERO' => $row[10],
//                     ];

//                     $gedungs->push($gedung);

//                     $kategori = [
//                         'Kategori' => $row[1],
//                     ];

//                     $kategoris->push($kategori);
//                 }
//             }

//             // dd($gedungs, $kategoris);

//             Gedung::insert($gedungs->toArray());
//             KategoriGedung::upsert($kategoris->toArray(), ['KATEGORI']);


//             return redirect()->back()->with('success', 'Imported successfully.');
//         } catch (\Exception $e) {
//             return redirect()->back()->with('error', $e->getMessage());
//         }
//     }
// }
    // public function importExcel(Request $request)
    // {
    //     $this->validate($request, [
    //         'upexcel' => 'required|mimes:xlsx',
    //     ]);

    //     $file = $request->file('upexcel');

    //     Excel::import(new GedungImport, $file);

    //     return redirect()->back()->with('success', 'Excel file imported successfully.');
    // }


    // public function importexcel(Request $request){
    //     if ($request->hasFile('upexcel')) {
    //         $data=$request->file('upexcel');
    //         $validatedData = $request->validate([
    //             'upexcel' => 'required|mimes:xlsx',
    //         ]);

    //         $namafile=$data;
    //         $path=$data->move('submitteddata',$namafile);
    //         Excel::import(new GedungImport,\public_path('/submitteddata/'.$namafile));
    //         return redirect()->back();
    //     }
    //     else {
    //         # code...
    //     }
    // }
// }
