<?php

namespace App\Exports;

use App\Models\Toko;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TokoExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Toko::select('NAMA','KATEGORI','ALAMAT','KOORDINAT','PIC_CUST','TEL_CUST','AM','TEL_AM','STO','HERO','TEL_HERO')->get();
    }

    public function map($toko): array{
        return[
            $toko->NAMA,
            $toko->KATEGORI,
            $toko->ALAMAT,
            $toko->KOORDINAT,
            $toko->PIC_CUST,
            $toko->TEL_CUST,
            $toko->AM,
            $toko->TEL_AM,
            $toko->STO,
            $toko->HERO,
            $toko->TEL_HERO,
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
