<?php

namespace App\Models;
use Illuminate\Support\Carbon; // Carbon kutubxonasini ulash

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AllSearchGet extends Model
{
    use Sushi;
    // Modelda bazaga bog'lanishning oldini olish uchun table null qilib o'rnatish
    protected $table = null;
    // Model uchun kerakli ustunlar
    protected $fillable = ['id', 'search_image_url', 'scan_id', 'student_name', 'student_image_url', 'created_at'];

    // API'dan ma'lumotlarni olish
    public function getRows(): array
    {

        $response = Http::get('http://facesec.newuu.uz/api/all');


        $data = $response->json();

        if ($response->successful() && isset($data['search_records']) && is_array($data['search_records'])) {
            $searchRecords = $data['search_records'];
        } else {
            Log::error('API response invalid or missing search_records array', [
                'response_body' => $response->body()
            ]);
            return [];
        }

        return collect($searchRecords)->map(function ($item) {
            $admin = ApiAdmins::find($item['scan_id']);

            return [
                'id' => $item['id'],
                'search_image_url' => $item['search_image_url'],
                'scan_id' => $admin ? $admin->name : 'N/A',
                'student_name' => $item['student']['name'],
                'student_image_url' => $item['student']['image_url'],
                'created_at' => Carbon::parse($item['created_at'])->setTimezone('Asia/Tashkent')->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }
}
