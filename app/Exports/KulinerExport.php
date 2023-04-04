<?php

namespace App\Exports;

use App\Models\Kuliner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KulinerExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kuliner::select('NAMA','KATEGORI','ALAMAT','KOORDINAT','PIC_CUST','TEL_CUST','AM','TEL_AM','STO','HERO','TEL_HERO')->get();
    }

    public function map($kuliner): array{
        return[
            $kuliner->NAMA,
            $kuliner->KATEGORI,
            $kuliner->ALAMAT,
            $kuliner->KOORDINAT,
            $kuliner->PIC_CUST,
            $kuliner->TEL_CUST,
            $kuliner->AM,
            $kuliner->TEL_AM,
            $kuliner->STO,
            $kuliner->HERO,
            $kuliner->TEL_HERO,
        ];
    }

    public function headings(): array
    {
        return [
        'NAMA',
        'KATEGORI',
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
