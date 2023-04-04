<?php

namespace App\Exports;

use App\Models\Health;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HealthExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Health::select('NAMA','KATEGORI','ALAMAT','KOORDINAT','PIC_CUST','TEL_CUST','AM','TEL_AM','STO','HERO','TEL_HERO')->get();
    }

    public function map($health): array{
        return[
            $health->NAMA,
            $health->KATEGORI,
            $health->ALAMAT,
            $health->KOORDINAT,
            $health->PIC_CUST,
            $health->TEL_CUST,
            $health->AM,
            $health->TEL_AM,
            $health->STO,
            $health->HERO,
            $health->TEL_HERO,
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
