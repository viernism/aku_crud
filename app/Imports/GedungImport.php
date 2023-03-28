<?php

namespace App\Imports;

use App\Models\Gedung;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GedungImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Gedung([
            'id' => $row['id'],
            'NAMA'=> $row['NAMA'],
            'KATEGORI'=>$row['KATEGORI'],
            'ALAMAT'=>$row['ALAMAT'],
            'KOORDINAT'=>$row['KOORDINAT'],
            'PIC_CUST'=>$row['PIC_CUST'],
            'TEL_CUST'=>$row['TEL_CUST'],
            'AM'=>$row['AM'],
            'TEL_AM'=>$row['TEL_AM'],
            'STO'=>$row['STO'],
            'HERO'=>$row['HERO'],
            'TEL_HERO'=>$row['TEL_HERO']
        ]);
    }
}
