<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;

class ScriverePunteggiaturaHelper implements TestHelperInterface
{
    /**
     * Property: the list of punctuation signs used in the test, mapped by their corresponding numbers
     */
    private array $punctuationSigns = [
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
     * Property: the sentences used in the test, with placeholders for the selectors
     */
    private array $sentences = [
        'Si alza di buonumore{{selector}} con la testa leggera{{selector}} ha voglia di una colazione sostanziosa{{selector}}',
        'Però{{selector}} durante il giorno{{selector}} continuano a riaffiorare interrogativi{{selector}} che genere di monete erano quelle{{selector}}',
        'Il cane{{selector}} che lo vede assorto e distante{{selector}} vorrebbe dirgli{{selector}}  {{selector}}Andiamo a passeggiare{{selector}}{{selector}}',
        'Ora basta{{selector}} Prende una decisione{{selector}} domani andrà in paese{{selector}} parlerà con qualcuno{{selector}} chiederà consiglio{{selector}}',
        'E  già studiava la frase con cui sarebbe entrato in argomento{{selector}}  qualcosa come{{selector}} {{selector}}Sai{{selector}}  giusto stanotte{{selector}}{{selector}}',
        'L’uomo{{selector}} mentre si stiracchia e sbadiglia{{selector}} ride di sé stesso{{selector}} è incredibile come una sciocchezza lo abbia suggestionato{{selector}}',
        'Sulla pagina è scritto{{selector}}  {{selector}}Non possiamo decidere niente per ora{{selector}} quando e se torneremo a prenderlo{{selector}} tutto dipenderà da ciò che ci verrà offerto{{selector}}{{selector}}',
        'Il bambino notò allora che per terra{{selector}} in un angolo{{selector}} c’erano delle macchinine{{selector}} e da un’altra parte dei Lego{{selector}} allora la sua ospite aveva probabilmente un nipotino{{selector}}',
        'Presa  la decisione{{selector}}  anche se si sente  un po’ ridicolo{{selector}}  è più tranquillo  e  rimanda al giorno dopo  la decisione{{selector}}  pazienza  se gli diranno  che  è  un  ingenuo{{selector}}',
    ];

    /**
     * Property: the correct answers for each selector in the test, mapped by their corresponding numbers
     */
    private array $correctAnswers = [1, 3, 2, 1, 1, 3, 7, 1, 1, 3, 8, 6, 9, 6, 3, 1, 1, 2, 1, 3, 8, 1, 5, 9, 1, 1, 3, 6, 3, 8, 4, 1, 9, 2, 1, 1, 1, 3, 6, 1, 1, 3, 6];

    /**
     * Constructor: initializes the helper
     */
    public function __construct() {}

    public function sentences(): array
    {
        $selectors = [];

        for ($i = 1; $i <= count($this->correctAnswers); $i++) {
            $options = ['<option value="0" selected></option>'];

            foreach ($this->punctuationSigns as $punctcuationKey => $punctcuation) {
                $result = $results[$i - 1] ?? null;
                $selected = $result && $result == $punctcuationKey;
                $options[] = '<option value="'.$punctcuationKey.'" '.($selected ? 'selected' : null).'>'.$punctcuation.'</option>';
            }

            $selectors[] = implode(PHP_EOL, $options);
        }

        $selectorKey = 0;
        $sentencesHtml = [];
        $placeholder = '{{selector}}';

        foreach ($this->sentences as $sentence) {
            while (strpos($sentence, $placeholder) !== false) {
                $selector = $selectors[$selectorKey];
                $selectorHtml = '<select class="js-field" name="field[]">'.$selector.'</select>';
                $position = strpos($sentence, $placeholder);
                $sentence = substr_replace($sentence, $selectorHtml, $position, strlen($placeholder));

                $selectorKey++;
            }

            $sentencesHtml[] = $sentence;
        }

        return $sentencesHtml;
    }

    public function completedText(?array $results): array
    {
        $sentencesHtml = [];
        $selectorKey = 0;
        $placeholder = '{{selector}}';

        foreach ($this->sentences as $sentence) {
            while (strpos($sentence, $placeholder) !== false) {
                $answerId = $results[$selectorKey] ?? null;
                $correctResult = $answerId == $this->correctAnswers[$selectorKey];
                $answer = $this->punctuationSigns[$answerId] ?? '-';

                $selectorHtml = '<span class="answer '.($correctResult ? 'answer-right' : 'answer-wrong').'">'.$answer.'</span>';
                $position = strpos($sentence, $placeholder);
                $sentence = substr_replace($sentence, $selectorHtml, $position, strlen($placeholder));

                $selectorKey++;
            }

            $sentencesHtml[] = $sentence;
        }

        return $sentencesHtml;
    }

    /**
     * Helper method: calculates the test result percentage based on the user's selections
     */
    public function calculatePercentage(array $results): int
    {
        $correctAnswerCount = 0;

        foreach ($results as $answerKey => $answer) {
            if ($answer == $this->correctAnswers[$answerKey]) {
                $correctAnswerCount++;
            }
        }

        return $correctAnswerCount / count($this->correctAnswers) * 100;
    }
}
