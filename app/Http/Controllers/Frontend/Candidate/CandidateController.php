<?php

namespace App\Http\Controllers\Frontend\Candidate;
use App\Models\ApiAdmins;
use App\Rules\ExistsOnConnection;
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
use Carbon\Carbon;


class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */




    public function export()
    {
        // Ma'lumotlarni SQLite-dan olish
        $data = DB::connection('sqlite_django')
            ->table('student_api_students')
            ->select('id', 'name', 'identifier', 'created_at')
            ->get();

        // Faqat kerakli maydonlar bilan qaytarish va created_at ni O'zbekiston vaqti bilan formatlash
        $students = $data->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'identifier' => $student->identifier,
                'created_at' => Carbon::parse($student->created_at)
                    ->setTimezone('Asia/Tashkent') // O'zbekiston vaqti
                    ->format('M d, Y H:i:s'), // Formatlash
            ];
        });

        // Excel faylni yaratish va qaytarish
        return Excel::download(new CandidateExport($students), 'Candidate.xlsx');
    }





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
            ->orderBy('created_at', 'desc')
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

            $response = $client->post('http://172.24.25.141:5000/api/upload/', [
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










    public function bulkDelete(Request $request)
    {
        // Validatsiya qoidasini o'rnatish
        $this->validate($request, [
            'ids' => 'required|array',
            'ids.*' => ['required', new ExistsOnConnection('sqlite_django', 'student_api_students')],
        ]);

        try {
            // O'chirish operatsiyasini bajarish
            $deletedCount = DB::connection('sqlite_django')
                ->table('student_api_students')
                ->whereIn('id', $request->ids)
                ->delete();

            // Natijani tekshirish va javob yuborish
            if ($deletedCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tanlangan ma\'lumotlar o\'chirildi.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Hech qanday ma\'lumot o\'chirilmadi.',
                ], 404);
            }
        } catch (\Exception $e) {
            // Xatolikni qaytarish
            return response()->json([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage(),
            ], 500);
        }
    }





}
