<?php

use App\Models\Review;
use App\Models\ReviewQuestion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('review_review_question', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('review_id');

            $table->unsignedBigInteger('review_question_id');

            $table->timestamps();

            // avoid duplicates
            $table->unique(['review_id', 'review_question_id']);
        });

        $reviews = Review::query()
            ->orderBy('id')
            ->get();

        $reviewQuestions = ReviewQuestion::all();

        foreach ($reviewQuestions as $reviewQuestion) {
            if (empty($reviewQuestion->reviewIds)) {

                foreach ($reviews as $review) {
                    DB::table('review_review_question')->insert([
                        'review_id' => $review->id,
                        'review_question_id' => $reviewQuestion->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {

                $reviewIds = explode(',', $reviewQuestion->reviewIds);

                foreach ($reviewIds as $reviewId) {
                    if (empty($reviewId)) {
                        continue;
                    }

                    DB::table('review_review_question')->insert([
                        'review_id' => $reviewId,
                        'review_question_id' => $reviewQuestion->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void {
        Schema::dropIfExists('review_review_question');
    }
};
