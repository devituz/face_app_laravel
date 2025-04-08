<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class DjangoController extends Controller
{
    public function getSearchRecords()
    {
        // Django bazasidagi searchrecord va students jadvalarini bog'lab olish
        $data = DB::connection('sqlite_django')
            ->table('student_api_searchrecord')
            ->join('student_api_students', 'student_api_searchrecord.student_id', '=', 'student_api_students.id')
            ->select(
                'student_api_searchrecord.id as search_id',
                'student_api_searchrecord.search_image_path',
                'student_api_searchrecord.created_at as search_created_at',
                'student_api_students.name',
                'student_api_students.identifier',
                'student_api_students.scan_id',
                'student_api_students.created_at as student_created_at'
            )
            ->get();

        // Fayl yo‘lini to'liq URL formatiga o'zgartirish
        $data = $data->map(function ($record) {
            // Faylning to'liq URL manzilini olish
            $record->search_image_path = url('uploads/searches/' . basename($record->search_image_path));
            return $record;
        });

        return response()->json($data);
    }



}

