<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;

class ScrivereAvanzatoPunteggiaturaHelper implements TestHelperInterface {

    /**
     * Property: The punctuation marks used in the test, where the keys correspond to the punctuation mark keys used in the correct answers, and the values correspond to the actual punctuation characters
     */
    protected const array PUNCTUATIONS = [
        1 => ',',
        2 => '.',
        3 => ':',
        4 => ';',
        5 => '...',
        6 => '!',
        7 => '?',
        8 => '«',
        9 => '»',
    ];

    /**
     * Property: The correct answers for the test, where the keys correspond to the question numbers and the values correspond to the punctuation mark keys defined in the PUNCTUATIONS array
     */
    protected const array CORRECT_ANSWERS = [
        1,
        3,
        1,
        1,
        1,
        4,
        1,
        1,
        1,
        1,
        1,
        1,
        3,
        8,
        1,
        1,
        9
    ];

    /**
     * Property: The text of the test with {{selector}} placeholders for the punctuation selectors
     */
    protected const string TEXT = 'Francesca aveva gironzolato tutto il pomeriggio per casa senza riuscire ad impegnarsi in niente. Aveva fatto in fretta un po’ di compiti e poi si era stesa sul letto con un giornalino{{selector}} ma lo aveva sfogliato senza interesse. Era la fine di novembre e faceva buio presto. D’estate almeno stava fino a sera in cortile{{selector}} non era un granché{{selector}} senza un albero{{selector}} con tutte quelle finestre che ci si affacciavano{{selector}} senza un posto dove stare veramente in pace. Ma comunque all’aperto era meglio. In casa la mamma da un po’ di tempo era sempre nervosa{{selector}} andava di continuo intorno a pulire{{selector}} riordinare{{selector}} e ogni tanto{{selector}} proprio quando lei aveva appena iniziato un gioco o un libro interessante{{selector}} la chiamava con tono duro{{selector}} irritato{{selector}} e le chiedeva di aiutarla{{selector}} {{selector}}Invece di star lì a perdere tempo{{selector}} almeno facessi qualcosa per la scuola{{selector}} ormai sei grande{{selector}} e così via.';

    /**
     * Property: The text of the test with {{selector}} placeholders for the punctuation selectors
     */
    protected string $text = 'Francesca aveva gironzolato tutto il pomeriggio per casa senza riuscire ad impegnarsi in niente. Aveva fatto in fretta un po’ di compiti e poi si era stesa sul letto con un giornalino{{selector}} ma lo aveva sfogliato senza interesse. Era la fine di novembre e faceva buio presto. D’estate almeno stava fino a sera in cortile{{selector}} non era un granché{{selector}} senza un albero{{selector}} con tutte quelle finestre che ci si affacciavano{{selector}} senza un posto dove stare veramente in pace. Ma comunque all’aperto era meglio. In casa la mamma da un po’ di tempo era sempre nervosa{{selector}} andava di continuo intorno a pulire{{selector}} riordinare{{selector}} e ogni tanto{{selector}} proprio quando lei aveva appena iniziato un gioco o un libro interessante{{selector}} la chiamava con tono duro{{selector}} irritato{{selector}} e le chiedeva di aiutarla{{selector}} {{selector}}Invece di star lì a perdere tempo{{selector}} almeno facessi qualcosa per la scuola{{selector}} ormai sei grande{{selector}} e così via.';

    /**
     * Helper method: return the array of correct answers for the test
     * The keys of the array correspond to the question numbers, and the values correspond to the correct punctuation mark keys
     */
    protected function correctAnswers(): array {
        return self::CORRECT_ANSWERS;
    }

    /**
     * Helper method: return the array of punctuation marks used in the test
     * The keys of the array correspond to the punctuation mark keys used in the correct answers, and the values correspond to the actual punctuation characters
     */
    protected function punctuations(): array {
        return self::PUNCTUATIONS;
    }

    /**
     * Helper method: get the total number of questions in the test
     */
    protected function count(): int {
        return count(self::CORRECT_ANSWERS);
    }

    /**
     * Helper method: build the options for each selector based on the punctuation marks and the student's previous answers (if any)
     */
    protected function buildSelectors(): array {
        $selectors = [];

        for ($i = 1; $i <= $this->count(); $i++) {
            $options = [];

            if (!legacy_test()->completed) {
                $options[] = '<option value="0" disabled selected>-</option>';
            }

            foreach (self::PUNCTUATIONS as $punctuationKey => $punctuation) {
                $result = legacy_test()->rawResults[$i - 1] ?? null;
                $selected = $result && (int) $result === $punctuationKey;

                $options[] = sprintf(
                    '<option value="%d" %s>%s</option>',
                    $punctuationKey,
                    $selected ? 'selected' : '',
                    e($punctuation)
                );
            }

            $selectors[] = implode(PHP_EOL, $options);
        }

        return $selectors;
    }

    /**
     * Helper method: build the HTML for a single selector, applying the appropriate classes and disabled state based on whether the test is completed and whether the answer is correct
     */
    protected function buildSelectorHtml(int $selectorKey, string $options): string {
        $completed = legacy_test()->completed;
        $rawResult = legacy_test()->rawResults[$selectorKey] ?? null;
        $correctAnswer = self::CORRECT_ANSWERS[$selectorKey];

        $resultClass = '';

        if ($completed) {
            $resultClass = ((int) $rawResult === $correctAnswer) ? 'right' : 'wrong';
        }

        $disabled = ($completed || isSupervisor()) ? 'disabled' : '';

        return sprintf(
            '<select class="js-field %s" name="field[]" %s>%s</select>',
            $resultClass,
            $disabled,
            $options
        );
    }

    /**
     * Helper method: generate the HTML for the test text with embedded selectors
     */
    public function htmlText(): string {
        $textHtml = self::TEXT;
        $selectors = $this->buildSelectors();
        $placeholder = '{{selector}}';
        $selectorKey = 0;

        while (($position = strpos($textHtml, $placeholder)) !== false) {
            $selectorHtml = $this->buildSelectorHtml($selectorKey, $selectors[$selectorKey]);

            $textHtml = substr_replace(
                $textHtml,
                $selectorHtml,
                $position,
                strlen($placeholder)
            );

            $selectorKey++;
        }

        return $textHtml;
    }

    /**
     * Calculate the percentage score based on the submitted answers and the correct answers
     */
    public function calculatePercentage(array $submittedAnswers): int {
        $correctAnswers = $this->correctAnswers();
        $total = count($correctAnswers);
        $correctCount = 0;

        foreach ($submittedAnswers as $index => $answer) {
            if ((int) $answer === $correctAnswers[$index]) {
                $correctCount++;
            }
        }

        return round(($correctCount / $total) * 100);
    }
}
