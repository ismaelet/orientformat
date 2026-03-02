<?php

use App\Helpers\FileHelper;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

/**
 * Get the student or simulated student associated with the authenticated user
 */
function student(): Student|Teacher|null {
    return Auth::user()?->student ?? Auth::user()?->teacher;
}

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
 * Check if the user is an admin
 */
function is_admin(): bool {
    return Auth::user()?->is_admin;
}

/**
 * Get the path of a file in the public storage directory
 */
function public_asset(string $path): string {
    return FileHelper::publicAsset($path);
}

/**
 * Convert an integer to a Roman numeral
 */
function toRoman(int $number): string {
    $map = [
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1,
    ];

    $result = '';

    foreach ($map as $roman => $int) {
        while ($number >= $int) {
            $result .= $roman;
            $number -= $int;
        }
    }

    return $result;
}

/**
 * Reverse translate a word from a given locale to English
 */
function __en(?string $word, string $file = 'shared'): ?string {
    if (!$word) {
        return null;
    }

    $locales = ['it', 'de'];

    foreach ($locales as $locale) {
        $translations = Lang::get($file, [], $locale);

        if ($key = array_search($word, $translations, true)) {
            return $key;
        }
    }

    return $word;
}

/**
 * Check if the application is in placeholder mode, used to render placeholders instead of real data
 */
function display_placeholders(): bool {
    return app()->environment('local') && request()->query('placeholders') === 'true';
}
