<?php

use App\Models\Support\SupportCategory;
use Illuminate\Support\Facades\Vite;

$categoryId = $_GET['category'] ?? null;
$categoryId = SupportCategory::where('id', $categoryId)->exists() ? $categoryId : null;
$topicId = $categoryId ? ($_GET['topic'] ?? null) : null;
$topicText = '';

// fetch categories
$categories = SupportCategory::orderBy('sort')->get();

// fetch topics
if ($categoryId) {
    $categoryData = SupportCategory::find($categoryId);
    $topics = $categoryData ? $categoryData->topics()->orderBy('id', 'asc')->get() : collect();
}

function _fill_text($text, $topicId) {
    // place counters
    $counterId = 0;

    while (strpos($text, $needle = '{{ counter }}') !== false) {
        $counterId++;

        $text = preg_replace('/' . $needle . '/', '<br><strong>' . $counterId . '.</strong> ', $text, 1);
    }

    // place quotes
    while (strpos($text, $needle = '{q ') !== false) {
        $text = preg_replace('/' . $needle . '/', '"<strong>', $text, 1);
    }

    while (strpos($text, $needle = ' q}') !== false) {
        $text = preg_replace('/' . $needle . '/', '</strong>"', $text, 1);
    }

    // place images
    $imgId = 0;

    while (strpos($text, $needle = '{{ img }}') !== false) {
        $imgId++;

        if (file_exists(resource_path('images/support/' . $topicId . '-' . $imgId . '.webp'))) {
            $imagePath = Vite::image('support/' . $topicId . '-' . $imgId . '.webp');
        } else {
            $imagePath = asset('legacy/pages/assets/support/' . $topicId . '-' . $imgId . '.jpg');
        }

        $text = preg_replace('/' . $needle . '/', '<br><br><img class="topic_img js-open-modal" src="' . $imagePath . '" loading="lazy" data-target="img-modal"><br>', $text, 1);
    }

    return $text;
}
