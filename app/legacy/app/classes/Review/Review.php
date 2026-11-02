<?php

namespace Legacy\Review;

use App\Legacy\LegacyDB;
use System\Traits\DatabaseObject;

class Review
{
    use DatabaseObject;

    public const TABLE = 'reviews';

    public const INDEX = 'id';

    /**
     * Get methods
     */
    private function getStudentId()
    {
        return $this->data['studentId'] ?? userId();
    }

    private function getAreas()
    {
        $areas = [];
        $areaIds = explode(',', $this->data['areas']);

        foreach ($areaIds as $areaId) {
            $areas[] = new Area($areaId, $this->id);
        }

        return $areas;
    }

    private function getCompleted()
    {
        return LegacyDB::exists('review_results WHERE reviewId = ? AND studentId = ?', [$this->id, $this->studentId]);
    }

    /**
     * Set methods
     */
    public function setStudentId(int $studentId)
    {
        $this->data['studentId'] = $studentId;

        return $this;
    }
}
