<?php

namespace App\Exports;

use App\Models\Gedung;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GedungExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Gedung::select('id','NAMA','KATEGORI','ALAMAT','KOORDINAT','PIC_CUST','TEL_CUST','AM','TEL_AM','STO','HERO','TEL_HERO')->get();
    }

    public function map($gedung): array{
        return[
            $gedung->id,
            $gedung->NAMA,
            $gedung->KATEGORI,
            $gedung->ALAMAT,
            $gedung->KOORDINAT,
            $gedung->PIC_CUST,
            $gedung->TEL_CUST,
            $gedung->AM,
            $gedung->TEL_AM,
            $gedung->STO,
            $gedung->HERO,
            $gedung->TEL_HERO,
        ];
    }

    public function headings(): array
    {
        return [
        'id',
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
