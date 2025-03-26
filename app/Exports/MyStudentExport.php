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
                'Vaqt' => Carbon::parse($record['created_at'])->format('Y-m-d H:i:s'),
            ];
        });
    }


    public function headings(): array
    {
        return ['ID', 'Scan qilgan shaxs', 'Ism', 'Vaqt'];
    }
}
