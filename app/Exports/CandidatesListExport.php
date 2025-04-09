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
            $record->search_id,  // Changed from $record['id'] to $record->search_id
            $record->name,       // Changed from $record['student']['name'] to $record->name
            $record->identifier, // Changed from $record['student']['identifier'] to $record->identifier
            $record->scan_id,    // Changed from $record['scan_id'] to $record->scan_id
            $record->search_created_at, // Changed from $record['created_at'] to $record->search_created_at
        ];
    }



}
