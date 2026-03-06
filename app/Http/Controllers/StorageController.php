<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageController extends Controller
{
    /**
     * Serve files from the public storage directory
     */
    public function show($path)
    {
        // Prevent directory traversal attacks
        if (str_contains($path, '..')) {
            return response('Unauthorized', 403);
        }

        if (!Storage::disk('public')->exists($path)) {
            return response('File not found', 404);
        }

        return Storage::disk('public')->download($path);
    }

    /**
     * Get file URL for inline display (images, etc.)
     */
    public function inline($path)
    {
        // Prevent directory traversal attacks
        if (str_contains($path, '..')) {
            return response('Unauthorized', 403);
        }

        if (!Storage::disk('public')->exists($path)) {
            return response('File not found', 404);
        }

        try {
            $path_full = Storage::disk('public')->path($path);
            $mimeType = mime_content_type($path_full);
            return response()->file($path_full, ['Content-Type' => $mimeType]);
        } catch (\Exception $e) {
            return response('Error serving file: ' . $e->getMessage(), 500);
        }
    }
}
