<?php

namespace Legacy\Review;

use Illuminate\Support\Facades\DB;
use System\Traits\DatabaseObject;

class Area
{
    use DatabaseObject;

    public const TABLE = 'review_areas';

    public const INDEX = 'id';

    public function getQuestions(int $reviewId)
    {
        $questions = [];

        if ($reviewId) {
            $questionRows = DB::table('review_questions')
                ->select('id')
                ->where('areaId', $this->id)
                ->where(function ($query) use ($reviewId) {
                    $query->where('reviewIds', '')->orWhereRaw('FIND_IN_SET(?, reviewIds)', [$reviewId]);
                })
                ->get();

            foreach ($questionRows as $questionRow) {
                $questions[] = new Question($questionRow->id);
            }
        }

        return $questions;
    }
}
