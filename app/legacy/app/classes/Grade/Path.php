<?php

namespace Grade;

use Illuminate\Support\Facades\DB;

class Path
{
    public $id = null;

    public $name;

    public $sectionIdsStr;

    public $areaIdsStr;

    public function __construct($id)
    {
        if ($row = (array) DB::table('paths')->where('id', $id)->first()) {
            $this->id = $id;
            $this->name = $row['name'];
            $this->sectionIdsStr = $row['sectionIds'];
            $this->areaIdsStr = $row['areaIds'];
        }
    }

    public function __get($name)
    {
        switch ($name) {
            case 'sectionIdsSql':
                return $this->sectionIdsSql = '"'.$this->sectionIdsStr.'"';
                break;
        }
    }
}
