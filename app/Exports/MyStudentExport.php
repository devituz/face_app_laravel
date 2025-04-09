<?php

namespace App\Exports;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\FromCollection;

class MyStudentExport implements FromCollection, WithHeadings
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
        return collect($this->students)->map(function ($record) {
            return [
                'ID' => $record['id'],
                'Scan qilgan shaxs' => $record['scan_id'],
                'Ism' => $record['student_name'],
                'Vaqt' => $record['created_at'], // Formatlangan holda kelgan
            ];
        });
    }


    public function headings(): array
    {
        return ['ID', 'Scan qilgan shaxs', 'Ism', 'Vaqt'];
    }
}
