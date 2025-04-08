<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class DjangoController extends Controller
{
    public function getSearchRecords()
    {
        // Django bazasidagi table dan ma’lumot olish
        $records = DB::connection('sqlite_django')
            ->table('student_api_searchrecord')
            ->get();

        return response()->json($records);
    }
}
