<?php

namespace App\Exports;

use App\Models\Buscen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BuscenExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Buscen::select('NAMA','KATEGORI','ALAMAT','KOORDINAT','PIC_CUST','TEL_CUST','AM','TEL_AM','STO','HERO','TEL_HERO')->get();
    }

    public function map($buscen): array{
        return[
            $buscen->NAMA,
            $buscen->KATEGORI,
            $buscen->ALAMAT,
            $buscen->KOORDINAT,
            $buscen->PIC_CUST,
            $buscen->TEL_CUST,
            $buscen->AM,
            $buscen->TEL_AM,
            $buscen->STO,
            $buscen->HERO,
            $buscen->TEL_HERO,
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
