<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class DjangoController extends Controller
{
    public function getSearchRecords()
    {
        // Django bazasidagi table dan ma’lumot olish
        $data = DB::connection('sqlite_django')->table('student_api_searchrecord')->get();

        // Fayl yo‘lini to'liq URL formatiga o'zgartirish
        $data = $data->map(function ($record) {
            // Faylning to'liq URL manzilini olish
            $record->search_image_path = url('uploads/searches/' . basename($record->search_image_path));
            return $record;
        });

        return response()->json($data);
    }
}

