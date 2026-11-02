<?php

namespace Legacy\Activity;

use Illuminate\Support\Facades\DB;
use System\Traits\DatabaseObject;

class Area
{
    use DatabaseObject;

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
            return rows_to_objects(DB::table('sections')->select(Section::INDEX)->where('active', 1)->where(Section::AREA_INDEX, $this->id)->whereRaw('FIND_IN_SET(?, years)', [$yearNumber])->get(), Section::class);
        } else {
            return rows_to_objects(DB::table('sections')->select(Section::INDEX)->where('active', 1)->where(Section::AREA_INDEX, $this->id)->get(), Section::class);
        }
    }

    public function getAlphabeticalSections($yearNumber = null)
    {
        if ($yearNumber) {
            return rows_to_objects(DB::table('sections')->select(Section::INDEX)->where('active', 1)->where(Section::AREA_INDEX, $this->id)->whereRaw('FIND_IN_SET(?, years)', [$yearNumber])->orderBy('name')->get(), Section::class);
        } else {
            return rows_to_objects(DB::table('sections')->select(Section::INDEX)->where('active', 1)->where(Section::AREA_INDEX, $this->id)->orderBy('name')->get(), Section::class);
        }
    }

    public function getDoableSections($yearNumber = null)
    {
        if ($yearNumber) {
            return rows_to_objects(DB::table('sections')->select(Section::INDEX)->where('active', 1)->where('isStandard', 1)->where(Section::AREA_INDEX, $this->id)->whereRaw('FIND_IN_SET(?, years)', [$yearNumber])->get(), Section::class);
        } else {
            return rows_to_objects(DB::table('sections')->select(Section::INDEX)->where('active', 1)->where('isStandard', 1)->where(Section::AREA_INDEX, $this->id)->get(), Section::class);
        }
    }

    public function getAplhabeticalDoableSections($yearNumber = null)
    {
        if ($yearNumber) {
            return rows_to_objects(DB::table('sections')->select(Section::INDEX)->where('active', 1)->where('isStandard', 1)->where(Section::AREA_INDEX, $this->id)->whereRaw('FIND_IN_SET(?, years)', [$yearNumber])->orderBy('name')->get(), Section::class);
        } else {
            return rows_to_objects(DB::table('sections')->select(Section::INDEX)->where('active', 1)->where('isStandard', 1)->where(Section::AREA_INDEX, $this->id)->orderBy('name')->get(), Section::class);
        }
    }

    private function getUrl()
    {
        return route('analysis.student.area', ['area' => $this->id]);
    }
}
