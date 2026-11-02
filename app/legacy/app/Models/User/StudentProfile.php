<?php

namespace LegacyModels\User;

use LegacyModels\OldModel;

class StudentProfile extends OldModel
{
    /**
     * Database Model constants
     */
    protected const TABLE = 'student_profiles';

    /**
     * Static get methods
     */

    /**
     * Dynamic get methods
     */
    public function dynamicChoice(array|int|null $questionnaireId = 2)
    {
        $mappedChoiches = [];
        $relevantKeys = ['s2d2_1', 's2d2_2', 's2d2_3', 's2d2_4'];
        $intensities = ['Lo esclude', 'Lo sta valutando', 'Ne è quasi sicuro/a', 'Ne è sicuro/a'];
        $choices = explode(',', \App\Legacy\LegacyDB::find('`rows` FROM review_questions WHERE id = 2'));

        if (is_array($questionnaireId)) {
            $answers = \App\Legacy\LegacyDB::find('results FROM review_results WHERE studentId = ? AND reviewId IN ('.(implode(',', $questionnaireId)).') ORDER BY reviewId DESC', [$this->id]);
        } elseif (is_numeric($questionnaireId)) {
            $answers = \App\Legacy\LegacyDB::find('results FROM review_results WHERE studentId = ? AND reviewId = ? ORDER BY reviewId DESC', [$this->id, $questionnaireId]);
        } else {
            $answers = \App\Legacy\LegacyDB::find('results FROM review_results WHERE studentId = ? ORDER BY reviewId DESC', [$this->id]);
        }

        if ($answers) {
            $answers = explode(',', $answers);

            foreach ($answers as $answer) {
                if (strpos($answer, '=')) {
                    $answer = explode('=', $answer);
                    $answerKey = $answer[0];
                    $answerValue = $answer[1] ?? null;
                    $choiceKey = array_search($answerKey, $relevantKeys);

                    if ($choiceKey !== false) {
                        $mappedChoiches[$choices[$choiceKey]] = $answerValue;
                    }
                }
            }
        }

        if (! empty($mappedChoiches)) {
            $choiceArea = array_keys($mappedChoiches, max($mappedChoiches))[0];
            $choiceIntensity = $intensities[max($mappedChoiches) - 1];
            $choice =
                [
                    'primary_choice_area' => $choiceArea,
                    'primary_choice_intensity' => $choiceIntensity,
                ];

            self::post($choice);

            return $choice;
        }
    }
}
