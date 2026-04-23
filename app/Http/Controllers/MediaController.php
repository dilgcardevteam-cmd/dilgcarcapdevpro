<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function public(Request $request, string $path)
    {
        $normalized = ltrim(str_replace(["\0", "\r", "\n"], '', $path), '/');
        if (str_starts_with($normalized, 'storage/')) {
            $normalized = substr($normalized, strlen('storage/'));
        }
        if (str_starts_with($normalized, 'public/')) {
            $normalized = substr($normalized, strlen('public/'));
        }
        if ($normalized === '' || str_contains($normalized, '..')) {
            abort(404);
        }

        $extension = strtolower(pathinfo($normalized, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf'];
        if ($extension === '' || !in_array($extension, $allowedExtensions, true)) {
            abort(404);
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($normalized)) {
            abort(404);
        }

        $mime = 'application/octet-stream';
        try {
            $detected = $disk->mimeType($normalized);
            if (is_string($detected) && $detected !== '') {
                $mime = $detected;
            }
        } catch (\Throwable $e) {
        }
        $stream = $disk->readStream($normalized);
        if (!is_resource($stream)) {
            abort(404);
        }

        $etag = '"' . sha1($normalized . '|' . ((string) $disk->lastModified($normalized))) . '"';
        if ($request->headers->get('If-None-Match') === $etag) {
            return response('', 304, [
                'ETag' => $etag,
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        }

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'public, max-age=31536000',
            'ETag' => $etag,
        ]);
    }
}
