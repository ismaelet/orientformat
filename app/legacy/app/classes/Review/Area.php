<?php

namespace Legacy\Review;

use App\Legacy\LegacyDB;
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
            $questionRows = LegacyDB::select('id FROM review_questions WHERE areaId=? AND (reviewIds="" OR FIND_IN_SET('.$reviewId.', reviewIds))', [$this->id]);

            while ($questionRow = $questionRows->fetch_assoc()) {
                $questions[] = new Question($questionRow['id']);
            }
        }

        return $questions;
    }
}
