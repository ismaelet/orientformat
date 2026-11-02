<?php

namespace LegacyModels\Activities;

use LegacyModels\OldModel;

class Section extends OldModel
{
    /**
     * Table data
     */
    protected const TABLE = 'sections';

    protected const TABLE_LINKS = [
        Area::class => 'areaId',
    ];

    /**
     * Get methods
     */
    public static function newFromSlug(string $slug)
    {
        return self::newWhere(['slug' => $slug]);
    }
}
