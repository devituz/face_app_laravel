<?php

namespace App\Http\Controllers;
use App\Models\ApiAdmins;
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
                'student_api_students.image_path',
                'student_api_students.scan_id',
                'student_api_students.created_at as student_created_at'
            )
            ->get();

        $data = $data->map(function ($record) {
            // search_image_path ning to'liq URL manzilini olish
            $record->search_image_path = url('uploads/searches/' . basename($record->search_image_path));

            // image_path ning to'liq URL manzilini olish
            $record->image_path = url('uploads/students/' . basename($record->image_path));

            // scan_id ni tekshirib, ApiAdmins modelidan mos name olish
            if ($record->scan_id) {
                $admin = ApiAdmins::find($record->scan_id);  // scan_id ga mos adminni topish

                // Agar admin topilsa, uning name'ini qo'shish, aks holda scan_id ni qo'shish
                $record->scan_id = $admin ? $admin->name : $record->scan_id;
            }

            return $record;
        });

        return response()->json($data);
    }


}

