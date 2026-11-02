<?php

namespace Legacy\UserSystem;

use App\Legacy\User;
use Illuminate\Support\Facades\DB;
use Legacy\SchoolSystem\School;
use Legacy\SchoolSystem\SchoolClass;
use Legacy\UserSystem\Student\Advice;
use LegacyModels\User\StudentProfile;
use System\Traits\DatabaseObject;

/**
 * Student class
 *
 * @property object user
 * @property string invertedFullName
 * @property int schoolClassId
 * @property object schoolClass
 * @property object school
 * @property object grade
 * @property bool isInMiddleschool
 * @property bool isInHighschool
 * @property object profile
 */
class Student
{
    use DatabaseObject;

    public const TABLE = 'students';

    public const INDEX = 'userId';

    public const SCHOOL_CLASS_INDEX = 'schoolClassId';

    /**
     * Get methods
     */
    private function getId()
    {
        return $this->{self::INDEX};
    }

    private function getUser()
    {
        return new User($this->userId);
    }

    private function getUsername()
    {
        return $this->user->username;
    }

    private function getfirst_name()
    {
        return $this->user->first_name;
    }

    private function getlast_name()
    {
        return $this->user->last_name;
    }

    private function getFullName()
    {
        return $this->user->fullName;
    }

    private function getInvertedFullName()
    {
        return $this->user->invertedFullName;
    }

    private function getSchoolClass()
    {
        return $this->schoolClassId ? new SchoolClass($this->schoolClassId) : null;
    }

    private function getSchool()
    {
        return new School($this->schoolClass->schoolId);
    }

    private function getGrade()
    {
        return $this->schoolClass ? $this->schoolClass->grade : null;
    }

    private function getIsInMiddleschool()
    {
        return $this->grade && $this->grade->isMiddleSchool;
    }

    private function getIsInHighschool()
    {
        return $this->grade && $this->grade->isHighSchool;
    }

    private function getHasCompletedEndReview()
    {
        return DB::table('survey_end')->where('userID', $this->id)->exists();
    }

    private function getStartReviewId()
    {
        return DB::table('review_results')->where('studentId', $this->id)->whereIn('reviewId', [1, 2])->orderByDesc('reviewId')->value('id');
    }

    private function getEndReviewId()
    {
        return DB::table('review_results')->where('studentId', $this->id)->where('reviewId', 3)->value('id');
    }

    private function getProfile()
    {
        return StudentProfile::newAdd($this->id);
    }

    private function getAdvicesString()
    {
        return $this->parseAdvices();
    }

    private function getAdvices()
    {
        $advices = false;

        $advicesData = DB::table('advices')->where('userID', $this->id)->value('advices');

        if ($advicesData) {
            $advices = [];
            $advicesData = explode(',', $advicesData);

            foreach ($advicesData as $adviceId) {
                $advices[] = new Advice($adviceId);
            }
        }

        return $advices;
    }

    private function parseAdvices()
    {
        if ($this->advices) {
            $advicesStr = [];

            foreach ($this->advices as $key => $advice) {
                $advicesStr[] = $key + 1 .'. '.$advice->name;
            }

            $advicesStr = implode('<br>', $advicesStr);
        } else {
            $advicesStr = '';
        }

        return $advicesStr;
    }

    private function getChoices()
    {
        $choices = [];

        $profile = $this->profile;

        if ($profile->id) {

            $surveyResults = $profile->results;
            $genericResults = $surveyResults['s2d2'] ?? false;

            if ($genericResults) {
                foreach ($genericResults as $surveyResultTitle => $surveyResult) {
                    $choices[$surveyResultTitle] = $surveyResult;
                }
            }
        }

        return $choices;
    }

    private function getSpecificChoices()
    {
        $choices = [];

        $answerIds = ['Liceo' => 's2d3a', 'Istituto Tecnico' => 's2d3b', 'Istruzione e Formazione Professionale' => 's2d3c', 'Istituto Professionale (Istituto “Don Milani” e Istituto “I. De Carneri” Oxford)' => 's2d3d'];

        $profile = $this->profile;

        if ($profile->id) {

            $surveyResults = $profile->results;

            foreach ($answerIds as $answerTitle => $answerSlug) {
                $specificChoice = $surveyResults[$answerSlug] ?? null;
                $choice = $specificChoice && $specificChoice != 'Non ci ho ancora pensato' ? $specificChoice : null;
                if ($choice) {
                    $choices[$answerTitle] = $choice;
                }
            }
        }

        return $choices;
    }

    private function getCombinedChoices()
    {
        $combinedChoices = [];
        $choices = $this->getChoices();
        $specificChoices = $this->getspecificChoices();

        foreach ($choices as $choiceTitle => $result) {
            $choice = $choiceTitle;
            if (isset($specificChoices[$choiceTitle])) {
                $choice = $specificChoices[$choiceTitle];
            }
            $combinedChoices[$choice] = $result;
        }

        return $combinedChoices;
    }

    /**
     * Misc
     */
    public function calcPersonalData()
    {
        if (! DB::table('students_data')->where('studentId', $this->id)->exists()) {
            $tempData = [];
            $tempSurveryData = [];

            if ($tempSurvery = DB::table('review_results')->where('studentId', $this->id)->whereRaw('FIND_IN_SET(reviewId, ?)', ['1,2'])->value('results')) {
                foreach (explode(',', $tempSurvery) as $tempSurveryVal) {
                    $tempSurveryVal = explode('=', $tempSurveryVal);
                    $tempSurveryData[$tempSurveryVal[0]] = $tempSurveryVal[1] ?? false;
                }

                $tempData['gender'] = $tempSurveryData['s1d1'] ?? 9;
                $tempData['decided'] = $tempSurveryData['s2d1'] ?? 0;
                $newDegreeLevel = isset($tempSurveryData['s4d1_1']) && isset($tempSurveryData['s4d1_2']) ? max($tempSurveryData['s4d1_1'], $tempSurveryData['s4d1_2']) : 7;

                switch ($newDegreeLevel) {
                    case 5:
                        $oldDegreeLevel = 8;
                        break;
                    case 6:
                    case 7:
                        $oldDegreeLevel = 0;
                        break;
                    default:
                        $oldDegreeLevel = $newDegreeLevel;
                        break;
                }

                $tempData['degree'] = $oldDegreeLevel;
            }

            if (! empty($tempData)) {
                DB::table('students_data')->insert([
                    'studentId' => $this->id,
                    'gender' => $tempData['gender'],
                    'decided' => $tempData['decided'],
                    'degree' => $tempData['degree'],
                ]);
            }
        }
    }
}
