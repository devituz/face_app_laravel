<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class DjangoController extends Controller
{
    public function getSearchRecords()
    {
        // Django bazasidagi table'dan ma'lumot olish
        $data = DB::connection('sqlite_django')->table('student_api_searchrecord')->get();

        // Fayl yo‘lini to'liq URL formatiga o'zgartirish va student_api_students jadvalidan qo'shimcha ma'lumotlarni olish
        $data = $data->map(function ($record) {
            // Faylning to'liq URL manzilini olish
            $record->search_image_path = url('uploads/searches/' . basename($record->search_image_path));

            // student_api_students jadvalidan `id`ga mos keladigan ma'lumotlarni olish
            $student = DB::connection('sqlite_django')
                ->table('student_api_students')
                ->where('id', $record->id)
                ->first();

            // Agar ma'lumot topilsa, ularni qo'shish
            if ($student) {
                $record->name = $student->name;
                $record->identifier = $student->identifier;
                $record->scan_id = $student->scan_id;
                $record->created_at = $student->created_at;
            }

            return $record;
        });

        // JSON formatida javob qaytarish
        return response()->json($data);
    }


}

