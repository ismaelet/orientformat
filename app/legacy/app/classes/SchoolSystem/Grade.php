<?php

namespace Legacy\SchoolSystem;

use Illuminate\Support\Facades\Auth;
use \Legacy\Activity\Area;
use \Legacy\Activity\Result\GradeResult;
use \Legacy\Activity\Result\TestResult;
use \Legacy\Activity\Section;
use \Legacy\Activity\Test;

/**
 * Grade class
 * 
 * @property string name
 * @property string romanNumeral
 * @property string adjective
 * 
 * @property string relativeId
 * @property string fullId
 * @property bool isMiddleSchool
 * @property bool isHighSchool
 * 
 * @property array standardTestIds
 * @property int standardTestCount
 * 
 * @property array sections
 * @property array doableSectionIds
 * @property string doableSectionIdsString
 * @property array doableSections
 * @property int doableSectionCount
 * @property int progressPercentage
 */
class Grade {

    use \System\Traits\DynamicProperties;

    private const NAMES = ['Prima', 'Seconda', 'Terza', 'Quarta', 'Quinta'];
    private const ROMAN_NUMERALS = ['I', 'II', 'III', 'IV', 'V'];
    private const ADJECTIVES = ['first', 'second', 'third', 'fourth', 'fifth'];

    public $id = null;
    private $schoolClass = null;

    function __construct(int $gradeNumber, object $schoolClass = null) {
        $this->id = $gradeNumber;
        $this->schoolClass = $schoolClass ?: (is_teacher_or_administrator() ? 0 : new SchoolClass(Auth::user()->student->class->id));
    }

    /*
	* Get methods
	*/
    private function getRelativeId() {
        return $this->isMiddleSchool ? $this->id : $this->id - 3;
    }

    private function getFullId() {
        $professionalSchoolClass = $this->isProfessional;

        return $this->id > 5 ? ($professionalSchoolClass ? $this->id . 'P' : $this->id . 'L') : $this->id;
    }

    private function getIsMiddleSchool() {
        return $this->id <= 3;
    }

    private function getIsProfessional() {
        return $this->schoolClass->isProfessional;
    }

    private function getIsHighSchool() {
        return !$this->isMiddleSchool;
    }

    private function getName() {
        return self::NAMES[$this->relativeId - 1];
    }

    private function getRomanNumeral() {
        return self::ROMAN_NUMERALS[$this->relativeId - 1];
    }

    private function getAdjective() {
        return __(self::ADJECTIVES[$this->relativeId - 1]);
    }

    private function getAreas() {
        return rows_to_objects(\App\Legacy\LegacyDB::select(Area::INDEX . ' FROM ' . Area::TABLE . ' WHERE id IN (SELECT ' . Section::AREA_INDEX . ' FROM sections WHERE FIND_IN_SET(?, years))', [$this->fullId]), Area::class);
    }

    private function getSections() {
        return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX . ' FROM sections WHERE FIND_IN_SET(?, years) AND active = 1', [$this->fullId]), Section::class);
    }

    private function getDoableSections() {
        return rows_to_objects(\App\Legacy\LegacyDB::select(Section::INDEX . ' FROM sections WHERE FIND_IN_SET(?, years) AND active = 1 AND isStandard = 1', [$this->fullId]), Section::class);
    }

    private function getDoableSectionIds() {
        $sectionIds = [];

        foreach ($this->doableSections as $legacySection) {
            $sectionIds[] = $legacySection->id;
        }

        return $sectionIds;
    }

    private function getDoableSectionIdsString() {
        return implode(',', $this->doableSectionIds);
    }

    private function getDoableSectionCount() {
        return count($this->doableSections);
    }

    private function getResultId() {
        $resultId = \App\Legacy\LegacyDB::find(GradeResult::INDEX . ' FROM ' . GradeResult::TABLE . ' WHERE ' . GradeResult::GRADE_INDEX . ' = ?  AND ' . GradeResult::USER_INDEX . ' = ?', [$this->id, \Illuminate\Support\Facades\Auth::id()]);

        if (!$resultId) {
            $resultId = GradeResult::new($this->id);
            $this->updateProgress();
        }

        return $resultId;
    }

    private function getResult() {
        return $this->resultId ? new GradeResult($this->resultId) : null;
    }

    private function getProgressPercentage() {
        return $this->result ? $this->result->progressPercentage : 0;
    }

    private function getStandardTestIds() {
        $res = \App\Legacy\LegacyDB::select(
            Test::TABLE . '.' . Test::INDEX . ' FROM ' . Test::TABLE . ' INNER JOIN ' .
                Section::TABLE . ' ON ' . Test::TABLE . '.' . Test::SECTION_INDEX . ' = sections.id
				WHERE isStandard = 1 AND ' . Test::TABLE . '.active = 1 AND sections.active = 1 AND FIND_IN_SET(?, years)',
            [$this->fullId]
        );

        $testIds = extract_subvalue($res->res, 'id');

        return $testIds;
    }

    private function getStandardTestCount() {
        return count($this->standardTestIds);
    }

    /**
     * Set methods
     */
    public function setIsProfessional(bool $isProfessional) {
        $this->data['isProfessional'] = $isProfessional;

        unset($this->data['fullId']);

        return $this;
    }

    /**
     * Update methods
     */
    public function updateProgress() {
        $progressPercentage = $this->calcProgress();

        \App\Legacy\LegacyDB::update(GradeResult::TABLE . ' SET progressPercentage = ? WHERE ' . GradeResult::GRADE_INDEX . ' = ? AND ' . GradeResult::USER_INDEX . ' = ?', [$progressPercentage, $this->id, \Illuminate\Support\Facades\Auth::id()]);
    }

    /**
     * Calc methods
     */
    private function calcProgress() {
        $legacyTestCount = $this->standardTestCount;

        $completedTestCount = \App\Legacy\LegacyDB::count(
            TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND completed = 1 AND FIND_IN_SET(' . TestResult::TEST_INDEX . ', "' . implode(',', $this->standardTestIds) . '")',
            [\Illuminate\Support\Facades\Auth::id()]
        );

        return round($completedTestCount / $legacyTestCount * 100);
    }
}
