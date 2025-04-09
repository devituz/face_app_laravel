<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ApiAdmins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use App\Exports\MyStudentExport;
use Maatwebsite\Excel\Facades\Excel;


class ApiStudentsController extends  Controller
{

    public function myregister(Request $request)
    {
        $scan_id = Auth::id(); // Yoki istalgan boshqa manbadan olinadi

        try {
            // Bazadan ma'lumot olish
            $data = DB::connection('sqlite_django')
                ->table('student_api_searchrecord')
                ->join('student_api_students', 'student_api_searchrecord.student_id', '=', 'student_api_students.id')
                ->where('student_api_students.scan_id', $scan_id)
                ->orderByDesc('student_api_searchrecord.id')
                ->select(
                    'student_api_searchrecord.id as search_id',
                    'student_api_searchrecord.search_image_path',
                    'student_api_searchrecord.created_at as search_created_at',
                    'student_api_students.id as student_id',
                    'student_api_students.name',
                    'student_api_students.identifier',
                    'student_api_students.image_path',
                    'student_api_students.created_at as student_created_at',
                    'student_api_students.scan_id'
                )
                ->get();

            // Ma'lumotni tayyorlash
            $results = $data->map(function ($item) {
                // Admin nomini olish
                $adminName = ApiAdmins::getAdminNameById($item->scan_id);

                // Student image URL
                $studentImage = $item->image_path ? url("uploads/students/" . basename($item->image_path)) : null;

                // Search image URL
                $searchImage = $item->search_image_path ? url("uploads/searches/" . basename($item->search_image_path)) : null;

                // Tashkent vaqti formatlash
                $createdAt = Carbon::parse($item->search_created_at)
                    ->setTimezone('Asia/Tashkent')
                    ->format('d-M-Y H:i');

                return [
                    'id' => $item->search_id,
                    'student_name' => $item->name ?? "Noma'lum",
                    'student_image' => array_filter([$studentImage, $searchImage]),
                    'identifier' => $item->identifier,
                    'scan_id' => $adminName,
                    'created_at' => $createdAt,
                ];
            });

            if ($results->isEmpty()) {
                return response()->json(['detail' => 'Ushbu scan_id uchun yozuv topilmadi'], 404);
            }

            return response()->json(['results' => $results], 200);
        } catch (\Exception $e) {
            Log::error('DB connection orqali ma\'lumot olishda xatolik', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function exportExcel()
    {
        $scan_id = Auth::id(); // Foydalanuvchi ID si

        // Bazadan ma’lumotlarni olish
        $data = DB::connection('sqlite_django')
            ->table('student_api_searchrecord')
            ->join('student_api_students', 'student_api_searchrecord.student_id', '=', 'student_api_students.id')
            ->where('student_api_students.scan_id', $scan_id)
            ->orderByDesc('student_api_searchrecord.id')
            ->select(
                'student_api_searchrecord.id as search_id',
                'student_api_searchrecord.created_at as search_created_at',
                'student_api_students.name as student_name',
                'student_api_students.scan_id'
            )
            ->get();

        // Ma'lumotni tayyorlash
        $students = $data->map(function ($item) {
            return [
                'id' => $item->search_id,
                'scan_id' => \App\Models\ApiAdmins::getAdminNameById($item->scan_id),
                'student_name' => $item->student_name ?? 'Noma’lum',
                'created_at' => Carbon::parse($item->search_created_at)
                    ->setTimezone('Asia/Tashkent')
                    ->format('Y-m-d H:i:s'),
            ];
        });

        // Fayl nomi
        $fileName = 'ScanList_' . now()->format('Ymd_His') . '.xlsx';

        // Faylni storage/app/public/ga saqlash
        Excel::store(new MyStudentExport($students), 'public/' . $fileName);

        // Public URLni olish
        $url = asset('storage/' . $fileName);

        // JSON javob
        return response()->json([
            'download_url' => $url
        ]);
    }

}
