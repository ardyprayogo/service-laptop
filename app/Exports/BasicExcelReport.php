<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BasicExcelReport implements FromCollection, WithHeadings
{
    public function __construct($data) {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Service Code',
            'Tanggal',
            'Customer',
            'Kasir',
            'Biaya Service'
        ];
    }
}
