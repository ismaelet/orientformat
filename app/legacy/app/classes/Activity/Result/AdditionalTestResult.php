<?php

namespace Legacy\Activity\Result;

/**
 * Additional results
 *
 * @property array primaryResults
 * @property array secondaryResults
 */
class AdditionalTestResult
{
    use \System\Traits\DatabaseObject;

    public const TABLE = 'results_additional';

    public const INDEX = 'id';

    public const USER_INDEX = 'studentId';

    public const TEST_INDEX = 'testId';

    /**
     * Get methods
     */
    private function getPrimaryResults()
    {
        return explode(',', $this->databaseEntry['primaryResults']);
    }

    private function getSecondaryResults()
    {
        return explode(',', $this->databaseEntry['secondaryResults']);
    }
}
