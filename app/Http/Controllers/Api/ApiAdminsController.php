<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ApiAdmins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ApiAdminsController extends Controller
{


    public function dashboard()
    {
        return response()->json(['message' => 'Admin boshqaruv paneliga xush kelibsiz']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        $validator = Validator::make($credentials, [
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Telefon raqam bo'yicha foydalanuvchini tekshirish
        $admin = ApiAdmins::where('phone', $credentials['phone'])->first();

        $phoneError = false;
        $passwordError = false;

        if (!$admin) {
            $phoneError = true; // Telefon raqam noto'g'ri
        } else if ($admin->password !== $credentials['password']) {
            $passwordError = true; // Parol noto'g'ri
        }

        // Xato holatlarni qaytarish
        if ($phoneError && $passwordError) {
            return response()->json(['message' => 'Both informations are wrong'], 401);
        } elseif ($phoneError) {
            return response()->json(['message' => 'The phone number is incorrect'], 401);
        } elseif ($passwordError) {
            return response()->json(['message' => 'The password is incorrect'], 401);
        }

        if (!$admin->is_admin) {
            return response()->json(['message' => 'Limited time'], 403);
        }

        $token = $admin->createToken('AdminToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'admin' => $admin,
        ]);
    }

    public function getAdmins()
    {
        $admin = auth()->user();

        if ($admin->image) {
            $admin->image = URL::to(Storage::url($admin->image));
        }

        // Telefon raqamini formatlash
        if ($admin->phone) {
            $admin->phone = $this->formatPhoneNumber($admin->phone);
        }

        return response()->json($admin);
    }

    private function formatPhoneNumber($phone)
    {
        return preg_replace('/(\+998)(\d{2})(\d{3})(\d{2})(\d{2})/', '$1 $2 $3 $4 $5', $phone);
    }



    public function search(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('file');

        try {
            $scan_id = Auth::id(); // Avtomatik foydalanuvchi ID

            $response = Http::attach('file', file_get_contents($file), $file->getClientOriginalName())
                ->post('http://172.24.25.141:5000/api/search/', [
                    'scan_id' => $scan_id,
                ]);

            if (!$response->successful()) {
                Log::error('API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json(['error' => 'Search failed'], $response->status());
            }

            $responseData = $response->json();

            // Tashqi APIdan olingan student ID
            $studentId = $responseData['id'] ?? null;

            if ($studentId) {
                // SQLite orqali student_api_students jadvalidan image_path ni olish
                $student = DB::connection('sqlite_django')
                    ->table('student_api_students')
                    ->where('id', $studentId)
                    ->select('image_path')
                    ->first();


                if ($student && $student->image_path) {
                    // Faqat fayl nomini olish
                    $fileName = basename($student->image_path);

                    // URL yasash
                    $imageUrl = url("uploads/students/" . $fileName);

                    $responseData['file'] = $imageUrl;
                } else {
                    $responseData['file'] = null;
                }
            }

                return response()->json($responseData, 200);
        } catch (\Exception $e) {
            Log::error('Error occurred in search method', [
                'message' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


}
