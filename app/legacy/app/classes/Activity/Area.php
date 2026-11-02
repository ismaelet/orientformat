<?php

namespace Legacy\Activity;

class Area
{
    use \System\Traits\DatabaseObject;

    public const TABLE = 'activities_areas';

    public const INDEX = 'id';

    /**
     * Get methods
     */
    private function getName()
    {
        return __('areas.'.$this->id);
    }

    private function getIcon()
    {
        return APP_ICONS_DIR.'/areas/area-'.$this->id;
    }

    public function getSections($yearNumber = null)
    {
        if ($yearNumber) {
            return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX.' FROM sections WHERE active = 1 AND '.Section::AREA_INDEX.' = ? AND FIND_IN_SET(?, years)', [$this->id, $yearNumber]), Section::class);
        } else {
            return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX.' FROM sections WHERE active = 1 AND '.Section::AREA_INDEX.' = ?', [$this->id]), Section::class);
        }
    }

    public function getAlphabeticalSections($yearNumber = null)
    {
        if ($yearNumber) {
            return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX.' FROM sections WHERE active = 1 AND '.Section::AREA_INDEX.' = ? AND FIND_IN_SET(?, years) ORDER BY name ASC', [$this->id, $yearNumber]), Section::class);
        } else {
            return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX.' FROM sections WHERE active = 1 AND '.Section::AREA_INDEX.' = ?  ORDER BY name ASC', [$this->id]), Section::class);
        }
    }

    public function getDoableSections($yearNumber = null)
    {
        if ($yearNumber) {
            return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX.' FROM sections WHERE active = 1 AND isStandard = 1 AND '.Section::AREA_INDEX.' = ? AND FIND_IN_SET(?, years) ', [$this->id, $yearNumber]), Section::class);
        } else {
            return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX.' FROM sections WHERE active = 1 AND isStandard = 1 AND '.Section::AREA_INDEX.' = ?', [$this->id]), Section::class);
        }
    }

    public function getAplhabeticalDoableSections($yearNumber = null)
    {
        if ($yearNumber) {
            return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX.' FROM sections WHERE active = 1 AND isStandard = 1 AND '.Section::AREA_INDEX.' = ? AND FIND_IN_SET(?, years) ORDER BY name ASC', [$this->id, $yearNumber]), Section::class);
        } else {
            return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX.' FROM sections WHERE active = 1 AND isStandard = 1 AND '.Section::AREA_INDEX.' = ? ORDER BY name ASC', [$this->id]), Section::class);
        }
    }

    private function getUrl()
    {
        return route('analysis.student.area', ['area' => $this->id]);
    }
}
