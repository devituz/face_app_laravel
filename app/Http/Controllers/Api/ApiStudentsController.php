<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ApiStudentsController extends  Controller
{

    public function myregister(Request $request)
    {
        $scan_id = Auth::id();
        try {
            $response = Http::post('http://127.0.0.1:5000/api/getme_register/', [
                'scan_id' => $scan_id,
            ]);

            if ($response->successful()) {

                return response()->json($response->json(), $response->status());
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
