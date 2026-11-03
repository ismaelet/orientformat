<?php

namespace App\Http\Requests;

use App\Models\Review;
use App\Models\ReviewResult;
use App\Services\Review\ReviewQuestionnaire;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class StoreReviewRequest extends FormRequest
{
    private ?Review $review = null;

    private ?ReviewQuestionnaire $questionnaire = null;

    public function authorize(): bool
    {
        return is_student();
    }

    public function review(): ?Review
    {
        $id = $this->input('review_id');

        return $this->review ??= is_string($id) || is_int($id) ? Review::find($id) : null;
    }

    public function questionnaire(): ReviewQuestionnaire
    {
        return $this->questionnaire ??= new ReviewQuestionnaire($this->review());
    }

    public function rules(): array
    {
        $rules = ['review_id' => ['required', 'integer', 'exists:reviews,id']];

        return $this->review() ? $rules + $this->questionnaire()->rules($this->all()) : $rules;
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $completed = $this->review() && ReviewResult::where('studentId', Auth::id())
                    ->where('reviewId', $this->review()->id)
                    ->exists();

                if ($completed) {
                    $validator->errors()->add('review_id', 'Questionario già completato.');
                }
            },
        ];
    }

    /** Validated answers keyed by field name, in questionnaire order. */
    public function answers(): array
    {
        return $this->questionnaire()->answers($this->validated());
    }
}
