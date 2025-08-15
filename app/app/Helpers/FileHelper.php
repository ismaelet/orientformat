<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileHelper {

	/**
	 * Get the versioned path of a file in the public storage directory
	 */
	public static function publicAsset(string $file): string {
		$storagePath = public_path('storage/' . $file);
		$version = file_exists($storagePath) ? filemtime($storagePath) : time();

		return asset('storage/' . $file) . '?v=' . $version;
	}

	/**
	 * Check if a file exists in the storage
	 */
	public static function exists(string $path): bool {
		return file_exists(public_path($path));
	}

	/**
	 * Delete a file from the storage
	 */
	public static function delete(string $path): bool {
		return Storage::disk('public')->delete($path);
	}

	/**
	 * Download a file from the public storage directory
	 */
	public static function download(string $path): BinaryFileResponse {
		$fullPath = public_path('storage/' . $path);

		if (!file_exists($fullPath)) {
			abort(404, 'File not found');
		}

		return response()->download($fullPath);
	}

	/**
	 * Move a file to the public storage directory
	 */
	public static function upload(UploadedFile $file, string $filePath): bool {
		$fileDirectory = ArrayHelper::explodeLast('/', $filePath)[0];
		$fileName = ArrayHelper::explodeLast('/', $filePath)[1];

		if (Storage::disk('public')->exists($filePath)) {
			Storage::disk('public')->delete($filePath);
		}

		$storedFile = $file->storeAs($fileDirectory, $fileName, 'public');

		return (bool) $storedFile;
	}
}
