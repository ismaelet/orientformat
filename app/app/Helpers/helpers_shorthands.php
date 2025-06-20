<?php

use App\Helpers\FileHelper;
use App\Models\User\Teacher;
use Illuminate\Support\Facades\Auth;

/**
 * Check if the user is a student
 */
function is_student(): bool {
	return (bool) Auth::user()?->student;
}

/**
 * Check if the user is a teacher
 */
function is_teacher(): bool {
	return (bool) teacher();
}

/**
 * Get the teacher associated with the authenticated user
 */
function teacher(): Teacher|null {
	return Auth::user()?->teacher;
}

/**
 * Check if the user is a teacher
 */
function is_administrator(): bool {
	return (bool) Auth::user()?->administrator;
}

/**
 * Get the path of a file in the public storage directory
 */
function public_asset(string $path): string {
	return FileHelper::publicAsset($path);
}
