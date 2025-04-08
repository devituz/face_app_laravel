<?php

namespace App\Http\Controllers\Frontend\Candidate;
use App\Models\ApiAdmins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Exports\CandidateExport;
use Maatwebsite\Excel\Facades\Excel;



class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function export()
    {
        // JSON ma'lumotlarini olish
        $response = Http::get('http://facesec.newuu.uz/api/user_json/');
        $data = $response->json();

        // Excel faylni yaratish va qaytarish
        return Excel::download(new CandidateExport($data['students']), 'Candidate.xlsx');
    }

    public function search(Request $request)
    {
        // So‘rovdan 'query' parametrini olish
        $query = $request->input('query');

        // API manzilini yaratish
        $apiUrl = "http://facesec.newuu.uz/api/search_user_json/?query=" . urlencode($query);

        // API ga so‘rov yuborish
        $response = Http::get($apiUrl);

        // Agar API so‘rovda xatolik bo‘lsa, error qaytarish
        if ($response->failed()) {
            return response()->json(['message' => 'API maʼlumotini olishda xatolik!'], 500);
        }

        // JSON javobni olish
        $students = collect($response->json());

        return view('pages.candidates.candidate.index', compact('students'));
    }


//    public function index(Request $request)
//    {
//        $page = $request->query('page', 1);
//
//        $response = Http::get("http://facesec.newuu.uz/api/user_images/?page={$page}");
//        $data = $response->json();
//
//        // Keyingi sahifa mavjud yoki yo'qligini tekshiramiz
//        $nextPage = count($data['students']) > 0 ? $page + 1 : null;
//        $prevPage = $page > 1 ? $page - 1 : null;
//
//        return view('pages.candidates.candidate.index', [
//            'students' => $data['students'],
//            'prevPage' => $prevPage,
//            'nextPage' => $nextPage
//        ]);
//    }


    public function index(Request $request)
    {
        $query = $request->query('query', null);
        $page = $request->query('page', 1);

        // Faqat student_api_students jadvalidan ma'lumot olish
        $data = DB::connection('sqlite_django')
            ->table('student_api_students')
            ->select(
                'id',
                'name',
                'identifier',
                'image_path',
                'scan_id',
                'created_at'
            )
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->paginate(5);

        // Ma'lumotlarni formatlash
        $students = $data->getCollection()->map(function ($record) {
            $record->image_path = url('uploads/students/' . basename($record->image_path));

            if ($record->scan_id) {
                $admin = ApiAdmins::find($record->scan_id);
                $record->scan_id = $admin ? $admin->name : $record->scan_id;
            }

            return $record;
        });

        $prevPage = $data->currentPage() > 1 ? $data->currentPage() - 1 : null;
        $nextPage = $data->currentPage() < $data->lastPage() ? $data->currentPage() + 1 : null;

        return view('pages.candidates.candidate.index', [
            'students' => $students,
            'prevPage' => $prevPage,
            'nextPage' => $nextPage,
            'currentPage' => $data->currentPage(),
            'lastPage' => $data->lastPage(),
            'query' => $query
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.candidates.candidate.create');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        try {
            // 1. **Validatsiya qilish**
            $request->validate([
                'name' => 'required|string|max:255',
                'identifier' => 'required|string|max:255',
                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // 2. **Faylni olish va vaqtincha saqlash**
            $image = $request->file('image_url');
            $extension = $image->getClientOriginalExtension(); // Fayl kengaytmasini olish
            $newFileName = $request->identifier . '.' . $extension; // Yangi nom

            $filePath = $image->storeAs('public/uploads', $newFileName); // Storage'ga yuklash
            $fullPath = storage_path('app/' . $filePath);
            $mimeType = $image->getMimeType();

            // 3. **Guzzle orqali API'ga yuborish**
            $client = new Client();
            $headers = [
                'Accept' => 'application/json'
            ];

            $options = [
                'multipart' => [
                    [
                        'name' => 'name',
                        'contents' => $request->name
                    ],
                    [
                        'name' => 'identifier',
                        'contents' => $request->identifier
                    ],
                    [
                        'name' => 'image_url',
                        'contents' => Utils::tryFopen($fullPath, 'r'),
                        'filename' => $newFileName, // Yangi fayl nomi bilan yuborish
                        'headers'  => [
                            'Content-Type' => $mimeType
                        ]
                    ]
                ]
            ];

            $response = $client->post('http://facesec.newuu.uz/api/upload/', [
                'headers' => $headers,
                'multipart' => $options['multipart']
            ]);

            // 4. **API muvaffaqiyatli javob qaytarsa**
            if ($response->getStatusCode() == 200) {
                Storage::delete($filePath); // Faylni storage'dan o‘chirish
                return redirect()->route('candidate.index')->with('success', 'Rasm API ga muvaffaqiyatli yuklandi!');
            } else {
                return redirect()->back()->withErrors([
                    'error' => 'API so‘rov bajarilmadi! Kod: ' . $response->getStatusCode()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('API orqali rasm yuklashda xatolik', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }







    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */


    public function bulkDestroy(Request $request)
    {
        // Yuborilgan IDlar
        $candidateIds = $request->input('ids'); // 'candidate_ids' o'rniga 'ids' ishlatilmoqda
        Log::info('Yuborilgan ids:', ['ids' => $candidateIds]);

        // IDsni integer formatiga o'tkazish
        $candidateIds = array_map('intval', $candidateIds);
        Log::info('Ids integer formatida:', ['ids' => $candidateIds]);

        // Django API URL
        $djangoApiUrl = "http://facesec.newuu.uz/api/candidates/delete/";
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
