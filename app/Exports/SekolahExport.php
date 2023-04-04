<?php

namespace App\Exports;

use App\Models\Sekolah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SekolahExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sekolah::select('NAMA','LEVEL','ALAMAT','KOORDINAT','PIC_CUST','TEL_CUST','AM','TEL_AM','STO','HERO','TEL_HERO')->get();
    }

    public function map($sekolah): array{
        return[
            $sekolah->NAMA,
            $sekolah->LEVEL,
            $sekolah->ALAMAT,
            $sekolah->KOORDINAT,
            $sekolah->PIC_CUST,
            $sekolah->TEL_CUST,
            $sekolah->AM,
            $sekolah->TEL_AM,
            $sekolah->STO,
            $sekolah->HERO,
            $sekolah->TEL_HERO,
        ];
    }

    public function headings(): array
    {
        return [
        'NAMA',
        'LEVEL',
        'ALAMAT',
        'KOORDINAT',
        'PIC_CUST',
        'TEL_CUST',
        'AM',
        'TEL_AM',
        'STO',
        'HERO',
        'TEL_HERO',];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:C1')->applyFromArray([
                    'fill' => [
                        'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startcolor' => [
                            'hex' => '64f571',
                        ],
                    ],
                ]);
            },
        ];
    }
}
