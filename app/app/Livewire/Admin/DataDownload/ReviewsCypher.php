<?php

namespace App\Livewire\Admin\DataDownload;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\Review;
use App\Models\ReviewQuestion;
use App\Models\ReviewResult;
use App\Models\User\Student;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ReviewsCypher extends Component {


    /**
     * Lifecycle Hook: Render the component view
     */
    public function render() {
        return view('livewire.admin.data-download.reviews-cypher');
    }

    /**
     * Action: Download data based on selected parameters
     */
    public function downloadData() {


        /**
         * Reviews list
         */
        $reivewNames = [
            1 => 'Questionario iniziale medie (vecchio)',
            2 => 'Questionario iniziale medie',
            3 => 'Questionario finale medie',
            4 => 'Primo questionario iniziale superiori',
            5 => 'Altro questionario iniziale superiori',
            6 => 'Questionario finale superiori',
        ];

        $reviews = Review::query()
            ->orderBy('id')
            ->get();

        $reviewQuestions = ReviewQuestion::query()
            ->whereHas('reviews', function ($q) use ($reviews) {
                $q->whereIn('reviews.id', $reviews->pluck('id'));
            })
            ->with('reviews')
            ->orderBy('full_slug')
            ->get();

        $flatQuestions = collect();

        foreach ($reviews as $review) {
            $questions = $reviewQuestions->filter(fn($q) => $q->reviews->contains('id', $review->id));

            foreach ($questions as $question) {
                $flatQuestions->push([
                    'label' => $reivewNames[$review->id] . ' > ' . $question->full_slug,
                    'slug' => $question->full_slug,
                    'review_id' => $review->id,
                    'text' => $question->text,
                ]);


                if ($question->optionCount() > 1) {
                    for ($optionKey = 1; $optionKey <= $question->optionCount(); $optionKey++) {
                        $questionFullSlug = $question->full_slug . '_' . $optionKey;

                        $flatQuestions->push(
                            [
                                'label' => $reivewNames[$review->id] . ' > ' . $questionFullSlug,
                                'slug' => $questionFullSlug,
                                'review_id' => $review->id,
                                'answer' => $question->option($optionKey - 1) ?? '.',
                            ]
                        );
                    }
                }
            }
        }

        $fileName = 'Cifrario_questionari.csv';

        /**
         * Stream the CSV download response
         */
        return response()->streamDownload(function () use (
            $reivewNames,
            $flatQuestions,
            $reviews,
        ) {
            $out = fopen('php://output', 'w');

            $baseHeader = ['Questionario', 'Codice', 'Testo'];
            fputcsv($out, $baseHeader);

            foreach ($reviews as $review) {
                $questions = $flatQuestions->filter(fn($q) => $q['review_id'] == $review->id);

                foreach ($questions as $question) {
                    $row = [
                        $reivewNames[$review->id] ?? '.',
                        $question['slug'] ?? '.',
                        $question['text'] ?? $question['answer'] ?? '.',
                    ];

                    fputcsv($out, $row);
                }
            }

            fclose($out);
        }, $fileName);
    }
}
