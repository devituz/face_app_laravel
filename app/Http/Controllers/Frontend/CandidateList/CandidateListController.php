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

        // Agar query mavjud bo'lsa, qidiruv so'rovi yuboriladi
        $url = $query
            ? 'http://facesec.newuu.uz/api/all/?query=' . urlencode($query) // Qidiruv bilan so'rov
            : 'http://facesec.newuu.uz/api/all/'; // Barcha yozuvlar uchun so'rov

        // API dan ma'lumot olish
        $response = Http::get($url);
        $data = $response->json();

        // Ma'lumotlarni o'zgartirish va formatlash
        $students = collect($data['search_records'])->map(function ($record) {
            // scan_id tekshiruvi va admin ismini olish
            if (!is_null($record['scan_id']) && is_numeric($record['scan_id'])) {
                $admin = ApiAdmins::find($record['scan_id']);
                $record['scan_id'] = $admin ? $admin->name : null; // Admin topilmasa, null
            } else {
                $record['scan_id'] = null;
            }

            // created_at ni O'zbekiston vaqti bilan ko'rsatish
            if (isset($record['created_at'])) {
                $record['created_at'] = Carbon::parse($record['created_at'])
                    ->setTimezone('Asia/Tashkent')
                    ->format('M d, Y H:i:s');
            }

            // Student ichidagi created_at ni ham O'zbekiston vaqti bilan ko'rsatish
            if (isset($record['student']['created_at'])) {
                $record['student']['created_at'] = Carbon::parse($record['student']['created_at'])
                    ->setTimezone('Asia/Tashkent')
                    ->format('M d, Y H:i:s');
            }

            return $record;
        })->filter(function ($record) {
            return !is_null($record['scan_id']); // scan_id null bo'lsa, o‘chiriladi
        });

        // View-ga o'zgartirilgan ma'lumotlarni yuborish
        return view('pages.candidates-list.candidate-list.candidate-list', compact('students'));
    }



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
