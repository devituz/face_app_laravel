<?php

namespace App\Http\Controllers\Frontend\CandidateList;
use App\Exports\CandidatesListExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ApiAdmins;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class CandidateListController extends Controller
{



    public function export()
    {
        $response = Http::get('http://facesec.newuu.uz/api/all/');
        $data = $response->json();

        $students = collect($data['search_records'])->map(function ($record) {
            if (!is_null($record['scan_id']) && is_numeric($record['scan_id'])) {
                $admin = ApiAdmins::find($record['scan_id']);
                $record['scan_id'] = $admin ? $admin->name : null; // Admin topilmasa, null
            } else {
                $record['scan_id'] = null;
            }

            // created_at ni O'zbekiston vaqti bilan ko'rsatish (search_records darajasida)
            if (isset($record['created_at'])) {
                $record['created_at'] = Carbon::parse($record['created_at'])
                    ->setTimezone('Asia/Tashkent') // O'zbekiston vaqti
                    ->format('M d, Y H:i:s'); // Formatlash
            }

            // Student ichidagi created_at ni ham O'zbekiston vaqti bilan ko'rsatish
            if (isset($record['student']['created_at'])) {
                $record['student']['created_at'] = Carbon::parse($record['student']['created_at'])
                    ->setTimezone('Asia/Tashkent') // O'zbekiston vaqti
                    ->format('M d, Y H:i:s'); // Formatlash
            }

            return $record;
        })->filter(function ($record) {
            return !is_null($record['scan_id']); // scan_id null bo'lsa, o‘chiriladi
        });


        // Excelni eksport qilish
        return Excel::download(new CandidatesListExport($students), 'Scan-list.xlsx');
    }

    // show metodiga ehtiyoj yo'q




    public function index(Request $request)
    {
        // query parametrini olish
        $query = $request->query('query', null);
        $page = $request->query('page', 1); // Sahifa raqamini olish (default: 1)

        // Data olish va pagination qo'llash
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
            // Agar query bo'lsa, name bo'yicha filtrlash
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('student_api_students.name', 'like', '%' . $query . '%');
            })
            ->paginate(5); // Pagination, har sahifada 5 ta yozuv



        // Data o'zgartirish va formatlash
        $students = $data->getCollection()->map(function ($record) {
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

        // Paginationni hisoblash
        $prevPage = $data->currentPage() > 1 ? $data->currentPage() - 1 : null;
        $nextPage = $data->currentPage() < $data->lastPage() ? $data->currentPage() + 1 : null;

        // View-ga o'zgartirilgan ma'lumotlarni yuborish
        return view('pages.candidates-list.candidate-list.candidate-list', [
            'students' => $students,  // Faqat students ma'lumotlari
            'prevPage' => $prevPage,  // Oldingi sahifa
            'nextPage' => $nextPage,  // Keyingi sahifa
            'currentPage' => $data->currentPage(), // Joriy sahifa
            'lastPage' => $data->lastPage(), // Oxirgi sahifa
            'query' => $query // Foydalanuvchi kiritgan qidiruv so'zi

        ]);
    }





    public function bulkDelete(Request $request)
    {
        // Validatsiya qoidasini o'zgartirib, 'sqlite_django' ulanishini ishlatamiz
        $this->validate($request, [
            'ids' => 'required|array',
            'ids.*' => [
                'required',
                Rule::exists('student_api_searchrecord', 'id')->connection('sqlite_django'),
            ],
        ]);

        try {
            // Perform the delete operation using the provided IDs
            // Tanlangan ID'larni o'chirish
            $deletedCount = DB::connection('sqlite_django')
                ->table('student_api_searchrecord')
                ->whereIn('id', $request->ids)
                ->delete();

            // Check if any records were deleted and return appropriate response
            if ($deletedCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tanlangan ma\'lumotlar o\'chirildi', // Translated: 'Selected data deleted'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Xatolik yuz berdi', // Translated: 'An error occurred'
                ], 500);
            }
        } catch (\Exception $e) {
            // Handle any errors that might occur during deletion
            return response()->json([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage(), // Return the exception message in case of error
            ], 500);
        }}



    public function bulkDestroy(Request $request)
    {
        // Yuborilgan IDlar
        $candidateIds = $request->input('ids'); // 'candidate_ids' o'rniga 'ids' ishlatilmoqda
        Log::info('Yuborilgan ids:', ['ids' => $candidateIds]);

        // IDsni integer formatiga o'tkazish
        $candidateIds = array_map('intval', $candidateIds);
        Log::info('Ids integer formatida:', ['ids' => $candidateIds]);

        // Django API URL
        $djangoApiUrl = "http://facesec.newuu.uz/api/user_delete/";
        Log::info('Django API URL:', ['url' => $djangoApiUrl]);

        // Guzzle HTTP Client
        $client = new Client();

        try {
            // POST so'rov yuborish
            Log::info('So\'rov yuborilmoqda...');

            $response = $client->post($djangoApiUrl, [
                'json' => [
                    'ids' => $candidateIds,  // Django APIga 'ids' yuboriladi
                ]
            ]);

            // Javobni olish
            $responseBody = $response->getBody()->getContents();
            Log::info('API javobi olindi:', ['response' => $responseBody]);

            $responseData = json_decode($responseBody, true);

            // API javobining status kodini tekshirish
            if ($response->getStatusCode() === 200) {
                Log::info('API muvaffaqiyatli javob berdi');
                return response()->json(['success' => 'Candidates successfully deleted']);
            } else {
                Log::error('Django API xatolik qaytardi', ['response' => $responseData]);
                return response()->json(['error' => 'Error occurred in Django API'], 500);
            }
        } catch (\Exception $e) {
            Log::error('API bilan bog\'lanishda xatolik', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to connect to Django API: ' . $e->getMessage()], 500);
        }
    }

}
