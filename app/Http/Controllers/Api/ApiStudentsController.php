<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiAdmins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;



class ApiStudentsController extends  Controller
{

    public function myregister(Request $request)
    {
        $scan_id = Auth::id();

        try {
            $response = Http::post('http://172.24.25.141:5000/api/getme_register/', [
                'scan_id' => $scan_id,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Har bir natija uchun scan_id ni ApiAdmins jadvalidagi name bilan almashtiramiz
                foreach ($data['results'] as &$item) {
                    $adminName = ApiAdmins::getAdminNameById($item['scan_id']);
                    $item['scan_id'] = $adminName;

                    $item['created_at'] = Carbon::parse($item['created_at'])
                        ->setTimezone('Asia/Tashkent')  // Tashkent vaqti bo‘yicha
                        ->format('d-M-Y H:i');  // Format: 25-Mar-2025 15:31
                }

                return response()->json($data, 200);
            } else {
                Log::error("Hozircha yo'q", [
                    'body' => $response->body(),
                ]);
                return response()->json(['error' => "Hozircha yo'q"], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Error occurred in register method', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }



}
