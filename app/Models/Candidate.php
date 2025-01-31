<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Candidate extends Model
{
    use HasFactory;

    // Modelda bazaga bog'lanishning oldini olish uchun table null qilib o'rnatish
    protected $table = null;

    // Faqat kerakli ustunlarni kiritish
    protected $fillable = ['name', 'image_url'];

    protected static function booted()
    {
        static::created(function ($candidate) {
            Log::info('Creating candidate record', [
                'candidate_name' => $candidate->name,
                'image_url' => $candidate->image_url,
            ]);

            if (empty($candidate->image_url)) {
                Log::error('Image URL is missing for candidate', [
                    'name' => $candidate->name,
                    'image_url' => $candidate->image_url,
                ]);
                return;
            }

            $filePath = 'public/api/' . basename($candidate->image_url);
            Log::info('Attempting to read file from storage', ['file_path' => $filePath]);

            try {
                $fileContents = Storage::disk('public')->get('api/' . basename($candidate->image_url));
                Log::info('File successfully read from storage', ['file_path' => $filePath]);
            } catch (\Exception $e) {
                Log::error('Error reading file from storage', [
                    'file_path' => $filePath,
                    'error' => $e->getMessage(),
                ]);
                return;
            }

            $uploadPath = 'http://127.0.0.1:5000/api/upload/';
            $response = Http::attach('image_url', $fileContents, basename($candidate->image_url)) // image file attached
            ->post($uploadPath, [
                'name' => $candidate->name,
            ]);

            if ($response->successful()) {
                Log::info('Image successfully uploaded to API', [
                    'candidate_name' => $candidate->name,
                    'image_url' => $candidate->image_url,
                    'destination_url' => $uploadPath,
                ]);

                Storage::delete('api/' . basename($candidate->image_url));
                Log::info('File deleted from storage after successful upload', [
                    'file_path' => 'api/' . basename($candidate->image_url),
                ]);
            } else {
                Log::error('API request failed to upload image', [
                    'candidate_name' => $candidate->name,
                    'image_url' => $candidate->image_url,
                    'response' => $response->body(),
                ]);
            }
        });
    }

}



