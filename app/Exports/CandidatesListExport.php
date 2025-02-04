<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class CandidatesListExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return collect($this->students); // Qayta to'plangan ma'lumotlar
    }


    public function headings(): array
    {
        return [
            'Id',
            'Full Name',
            'Identifier',
            'Scan',
            'Created At',

        ];
    }

    public function map($record): array
    {
        return [
            $record['id'],
            $record['student']['name'],
            $record['student']['identifier'],
            $record['scan_id'],
            $record['created_at'],

        ];
    }


}
