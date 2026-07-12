<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SupabaseStorageService
{
    protected $projectId;
    protected $bucket;
    protected $key;

    public function __construct()
    {
        $this->projectId = config('services.supabase.project_id');
        $this->bucket = config('services.supabase.bucket');
        $this->key = config('services.supabase.key');
    }

    /**
     * Upload an UploadedFile to Supabase Storage.
     *
     * @param UploadedFile $file
     * @param string $folder folder prefix (e.g. 'products' or 'qris_proofs')
     * @return string|null public URL of the uploaded file, or null on failure
     */
    public function upload(UploadedFile $file, string $folder = 'uploads')
    {
        $filename = $folder . '/' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $url = "https://{$this->projectId}.supabase.co/storage/v1/object/{$this->bucket}/{$filename}";

        $mimeType = $file->getClientMimeType() ?: 'application/octet-stream';
        $fileContents = file_get_contents($file->getRealPath());

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->key}",
                'apikey' => $this->key,
                'Content-Type' => $mimeType,
            ])->withBody($fileContents, $mimeType)
              ->post($url);

            if ($response->successful()) {
                // Return public URL of the uploaded object
                return "https://{$this->projectId}.supabase.co/storage/v1/object/public/{$this->bucket}/{$filename}";
            } else {
                Log::error("Supabase Storage Upload failed: Status: " . $response->status() . " Body: " . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            Log::error("Supabase Storage Exception during upload: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete a file from Supabase Storage by its public URL.
     *
     * @param string $publicUrl
     * @return bool
     */
    public function delete(string $publicUrl)
    {
        $prefix = "https://{$this->projectId}.supabase.co/storage/v1/object/public/{$this->bucket}/";
        if (!str_starts_with($publicUrl, $prefix)) {
            return false;
        }

        $filename = str_replace($prefix, '', $publicUrl);
        $url = "https://{$this->projectId}.supabase.co/storage/v1/object/{$this->bucket}/{$filename}";

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->key}",
                'apikey' => $this->key,
            ])->delete($url);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Supabase Storage Exception during delete: " . $e->getMessage());
            return false;
        }
    }
}
