<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CandidateExport implements FromCollection,WithHeadings
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
        return collect($this->students)->map(function ($student) {
            return [
                'id' => $student['id'],
                'name' => $student['name'],
                'identifier' => $student['identifier'],
                'created_at' => $student['created_at'],
            ];
        });
    }

    /**
     * Excel faylida sarlavhalar (headings)
     * @return array
     */
    public function headings(): array
    {
        return [
            'Id',
            'Full name',
            'Identifier',
            'Created at',
        ];
    }
}
